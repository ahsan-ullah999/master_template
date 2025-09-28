<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ProductOrderItem;
use App\Models\ProductDiscount;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductOrderController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // new Middleware('permission:view order', only: ['index']),
            new Middleware('permission:deliver order', only: ['deliver']),
            new Middleware('permission:show order', only: ['show']),
            new Middleware('permission:cancel order', only: ['cancel']),
            new Middleware('permission:create order', only: ['create','store']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    // index
    public function index(Request $r)
    {
        $query = ProductOrder::with(['items.product','slot','member']);
        if ($r->member_id) {
            $query->where('member_id', $r->member_id);
        }

        $orders = $query->orderBy('order_date','desc')->paginate(10);

        // Attach discount info for each order
        foreach ($orders as $order) {
            $totalQty = $order->items->sum('qty');
            $order->calculated_discount = ProductDiscount::discountAmountFor($totalQty, (float) $order->total);
        }

        return view('product_orders.list', compact('orders'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $slots = Slot::where('status','active')->get();

        // preload all routines with products + alternatives
        $routines = \App\Models\Routine::with(['items.product','items.alternative'])
            ->get()
            ->groupBy('slot_id');

        return view('product_orders.create', compact('slots','routines'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'member_id' => 'required|exists:members,id',
            'order_date' => 'required|date',
            'slot_id' => 'required|exists:slots,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        // Check slot cutoff time
        $slot = Slot::findOrFail($data['slot_id']);
        $orderDate = Carbon::parse($data['order_date']);
        $now = Carbon::now();

        if ($slot->order_cutoff_time) {
            $cutoff = Carbon::createFromFormat('H:i:s', $slot->order_cutoff_time)
                ->setDate($orderDate->year, $orderDate->month, $orderDate->day);

            if ($orderDate->isSameDay($now) && $now->greaterThan($cutoff)) {
                return back()->withErrors('Ordering for this slot is closed for today (cutoff reached).')->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $totalQty = 0;

            // Create order placeholder
            $order = ProductOrder::create([
                'member_id' => $data['member_id'],
                'slot_id'   => $data['slot_id'],
                'order_date'=> $data['order_date'],
                'total'     => 0,
                'discount_amount' => 0,
                'grand_total' => 0,   // 🔹 changed from final_total
                'status'    => 'ordered',
                'created_by'=> Auth::id()
            ]);

            // Insert items ...
            foreach ($data['items'] as $it) {
                $product = Product::findOrFail($it['product_id']);
                $qty = intval($it['qty']);
                $price = $product->price ?? 0;
                $lineTotal = $price * $qty;

                ProductOrderItem::create([
                    'product_order_id' => $order->id,
                    'product_id'       => $product->id,
                    'qty'              => $qty,
                    'price'            => $price,
                    'total'            => $lineTotal
                ]);

                $subtotal += $lineTotal;
                $totalQty += $qty;
            }

            // Discount + grand total
            $discountAmount = ProductDiscount::discountAmountFor($totalQty, (float)$subtotal);
            $grandTotal = max(0, round($subtotal - $discountAmount, 2));

            // Update order totals
            $order->update([
                'total'          => round($subtotal, 2),
                'discount_amount'=> round($discountAmount, 2),
                'grand_total'    => $grandTotal   // 🔹 changed from final_total
            ]);

            DB::commit();
            return redirect()->route('product_orders.index')
                ->with('success', 'Order created successfully' . ($discountAmount > 0 ? ' with discount applied.' : '.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    // show
    // public function show(ProductOrder $productOrder)
    // {
    //     $productOrder->load('items.product','member','slot');
    //     $totalQty = $productOrder->items->sum('qty');
    //     $productCount = ProductOrder::where('member_id',$productOrder->member_id)
    //         ->where('status','!=','cancelled')
    //         ->count();

    //     $discountAmount = ProductDiscount::discountAmountFor($totalQty, (float)$productOrder->total);

    //     return view('product_orders.show', [
    //         'order' => $productOrder,
    //         'productCount' => $productCount,
    //         'discountAmount' => $discountAmount,
    //     ]);
    // }
    public function show(ProductOrder $productOrder)
    {
        $productOrder->load('items.product','member','slot');

        $totalQty = $productOrder->items->sum('qty');
        $rule = ProductDiscount::matchingRule($totalQty, (float)$productOrder->total); // rule object
        $discountAmount = ProductDiscount::discountAmountFor($totalQty, (float)$productOrder->total); // float amount

        return view('product_orders.show', [
            'order' => $productOrder,
            'discountRule' => $rule,
            'discountAmount' => $discountAmount,
        ]);
    }


    /**
     * Mark as delivered.
     */
    public function deliver(Request $r, $id)
    {
        $order = ProductOrder::findOrFail($id);
        $order->update([
            'status'=>'delivered',
            'delivered_by'=>Auth::id(),
            'delivered_at'=>now()
        ]);
        return redirect()->back()->with('success','Marked delivered');
    }

    /**
     * Cancel an order.
     */
    public function cancel(Request $r, $id)
    {
        $order = ProductOrder::findOrFail($id);
        $order->update(['status'=>'cancelled']);
        return redirect()->back()->with('success','Order cancelled');
    }

    /**
     * Compute billing for a member in a date range.
     */
// computeBillingForMember
public function computeBillingForMember($memberId, $fromDate, $toDate)
    {
        $count = ProductOrder::where('member_id',$memberId)
            ->whereBetween('order_date', [$fromDate,$toDate])
            ->where('status','!=','cancelled')
            ->count();

        $discountAmount = ProductDiscount::discountAmountFor($count, 0);

        return [
            'product_count' => $count,
            'discount'      => $discountAmount,
        ];
    }

    // //self ordre for member

    // public function memberIndex()
    // {
    //     $member = Member::where('user_id', Auth::id())->firstOrFail();
    //     $orders = ProductOrder::with(['items.product','slot'])
    //         ->where('member_id', $member->id)
    //         ->orderBy('order_date','desc')
    //         ->paginate(10);

    //     return view('product_orders.member.index', compact('orders'));
    // }

    // public function memberCreate()
    // {
    //     $member = Member::where('user_id', Auth::id())->firstOrFail();
    //     $slots = Slot::where('status','active')->get();
    //     $products = Product::where('status','active')->get();

    //     return view('product_orders.member.create', compact('slots','products','member'));
    // }

    // public function memberStore(Request $r)
    // {
    //     $member = Member::where('user_id', Auth::id())->firstOrFail();

    //     $data = $r->validate([
    //         'order_date'=>'required|date',
    //         'slot_id'=>'required|exists:slots,id',
    //         'items'=>'required|array|min:1',
    //         'items.*.product_id'=>'required|exists:products,id',
    //         'items.*.qty'=>'required|integer|min:1'
    //     ]);

    //     $data['member_id'] = $member->id;

    //     return $this->store(new Request($data + $r->all())); // reuse store logic
    // }

}
