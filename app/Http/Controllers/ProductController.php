<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view product', only: ['index']),
            new Middleware('permission:edit product', only: ['edit']),
            new Middleware('permission:create product', only: ['create','store']),
            new Middleware('permission:delete product', only: ['delete']),
        ];
    }




    //for show products page
    public function index(Request $request)
    {
        $query = Product::query();

        // Search filter
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        // Sort filter
        if ($request->sort) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'ASC');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'DESC');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'ASC');
                    break;
                default:
                    $query->orderBy('created_at', 'DESC');
            }
        } else {
            $query->orderBy('created_at', 'DESC'); // default
        }

        $products = $query->paginate(10);

        if ($request->ajax()) {
            return view('products.partials.table', compact('products'))->render();
        }
        return view('products.list', compact('products'));
    }


    //for create products
    public function create(){
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:products,code',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = $request->only('name', 'code','description');

        if ($request->hasFile('image')) {
            $product['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($product);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }
    //for edit product
    public function edit($id){
        $product = Product::findOrFail($id);
        return view('products.edit',[
            'product'=> $product
        ]);
    }
    //for update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:products,code,' . $product->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $products = $request->only('name', 'code','description');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $products['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($products);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }
    //for delete product 
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'product deleted successfully');
    }
    // public function search(Request $request)
    // {
    //     $query = Product::query();

    //     if ($request->search) {
    //         $query->where('name', 'like', '%' . $request->search . '%')
    //             ->orWhere('code', 'like', '%' . $request->search . '%');
    //     }

    //     $products = $query->latest()->paginate(10);

    //     // Return only the partial table
    //     return view('products.partials.table', compact('products'));
    // }

    



}
