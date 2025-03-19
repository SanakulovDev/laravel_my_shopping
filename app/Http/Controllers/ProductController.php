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
     * param slug
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     * param slug
     */

    public function edit(string  $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, Product $product)
    {
        $validated = $request->validated();
        
        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Store the new photo
            $photoPath = $request->file('photo')->store('products', 'public');
            $validated['photo'] = $photoPath;
            
            // Delete old photo if exists
            if ($product->photo && file_exists(storage_path('app/public/' . $product->photo))) {
                unlink(storage_path('app/public/' . $product->photo));
            }
        }
        
        $product->update($validated);
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // delete photo
        if ($product->photo && file_exists(storage_path('app/public/' . $product->photo))) {
            unlink(storage_path('app/public/' . $product->photo));
        }
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');

    }
}
