<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Display a listing of the resource with pagination and search functionality.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Search by name or detail
        $search = $request->get('search') ?? '';
        $category = $request->get('category_id') ?? '';
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('detail', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Filter by category
        if (!empty($category)) {
            $query->where('category_id', $category);
        }
        
        // Sort by
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $products = $query->paginate(10)->withQueryString();
        $i = 0;
        $categories = Category::all();
        
        return view('products.index', compact('products', 'i', 'categories', 'search', 'category'));
    }
    



    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        // Create the product (without photo handling)
        $product = Product::create($request->validated());
        
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, Product $product)
    {
        $product->update($request->validated());
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
