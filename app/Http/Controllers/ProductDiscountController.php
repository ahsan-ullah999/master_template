<?php

namespace App\Http\Controllers;

use App\Models\ProductDiscount;
use Illuminate\Http\Request;

class ProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $query = ProductDiscount::query();

        // Filter: organization/member scope could be added here later
        if ($request->active !== null) {
            $query->where('active', $request->active);
        }

        $discounts = $query->orderBy('min_count')->paginate(10);

        return view('product_discounts.list', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product_discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'min_count' => 'required|integer|min:0',
            'max_count' => 'nullable|integer|gte:min_count',
            'min_subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percent',
            'active' => 'boolean',
        ]);

        ProductDiscount::create($data);

        return redirect()->route('product-discounts.index')->with('success', 'Product discount created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductDiscount $productDiscount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductDiscount $productDiscount)
    {
        return view('product_discounts.edit', compact('productDiscount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductDiscount $productDiscount)
    {
        $data = $request->validate([
            'min_count' => 'required|integer|min:0',
            'max_count' => 'nullable|integer|gte:min_count',
            'min_subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percent',
            'active' => 'boolean',
        ]);

        $productDiscount->update($data);

        return redirect()->route('product-discounts.index')->with('success', 'Product discount updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDiscount $productDiscount)
    {
        $productDiscount->delete();

        return redirect()->route('product-discounts.index')->with('success', 'Product discount deleted successfully');
    
    }
}
