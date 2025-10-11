<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\Routine;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /** Dashboard-style index with tabs */
    public function index()
    {
        return view('reports.index');
    }

    /** Shared query builder for all filters */
    private function filteredOrders(Request $request)
    {
        $query = ProductOrder::with(['member', 'routine', 'slot'])
            ->where('status', '!=', 'cancelled');

        // Member filter
        if ($request->filled('member') && $request->member !== 'all') {
            $query->where('member_id', $request->member);
        }

        // Date range filter
        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to   = Carbon::parse($request->to)->endOfDay();
            $query->whereBetween('order_date', [$from, $to]);
        }

        return $query;
    }

    private function summarize($orders)
    {
        $totalOrders = $orders->count();
        $totalMeals = $orders->sum(function ($o) {
            return $o->routine?->product_count ?? 0;
        });
        $delivered = $orders->where('status', 'delivered')->count();

        return compact('totalOrders', 'totalMeals', 'delivered');
    }

    public function today(Request $request)
    {
        // Clone the base query and apply 'today' constraint
        $query = $this->filteredOrders($request)->whereDate('order_date', today());
        
        // Fetch all results for summary calculation (a quick fix for small datasets)
        $allOrders = $query->get();
        $summary = $this->summarize($allOrders);

        // Paginate the final query
        $orders = $query->paginate(15)->withQueryString();
        
        return view('reports.partials.table', compact('orders', 'summary'));
    }


    public function tomorrow(Request $request)
    {
        $query = $this->filteredOrders($request)->whereDate('order_date', today()->addDay());
        
        $allOrders = $query->get();
        $summary = $this->summarize($allOrders);

        $orders = $query->paginate(15)->withQueryString();
        
        return view('reports.partials.table', compact('orders', 'summary'));
    }

    public function monthly(Request $request)
    {
        $query = $this->filteredOrders($request)
            ->whereMonth('order_date', today()->month)
            ->whereYear('order_date', today()->year);
            
        $allOrders = $query->get();
        $summary = $this->summarize($allOrders);
        
        $orders = $query->paginate(15)->withQueryString();
        
        return view('reports.partials.table', compact('orders', 'summary'));
    }

    public function yearly(Request $request)
    {
        $query = $this->filteredOrders($request)->whereYear('order_date', today()->year);

        $allOrders = $query->get();
        $summary = $this->summarize($allOrders);
        
        $orders = $query->paginate(15)->withQueryString();
        
        return view('reports.partials.table', compact('orders', 'summary'));
    }

    public function dateRange(Request $request)
    {
        $query = $this->filteredOrders($request);

        // Fetch all results for accurate summary calculation
        $allOrders = $query->get();
        $summary = $this->summarize($allOrders);
        
        // Paginate the result for the table display
        $orders = $query->paginate(15)->withQueryString();

        return view('reports.partials.table', compact('orders', 'summary'));
    }
}
