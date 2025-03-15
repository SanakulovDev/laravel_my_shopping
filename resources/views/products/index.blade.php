@extends('products.layout')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Products</h2>
        <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 mb-4 rounded shadow">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-2">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Search products..." class="w-full p-2 border rounded" value="{{ request('search') }}">
            </div>
            <div class="w-auto">
                <select name="category" class="p-2 border rounded w-full">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-auto">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">No</th>
                <th class="py-2 px-4 border-b">Category</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Details</th>
                <th class="py-2 px-4 border-b text-right">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td class="py-2 px-4 border-b">{{ ++$i }}</td>
                <td class="py-2 px-4 border-b">{{ $product->category?->name }}</td>
                <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                <td class="py-2 px-4 border-b">{{ $product->detail }}</td>
                <td class="py-2 px-4 border-b text-right">
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST" class="inline-block">
                        <a href="{{ route('products.show',$product->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection