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
                <input type="text" name="search" placeholder="Search products..." class="w-full p-2 border rounded" value="{{ $search ?? request('search') }}">
            </div>
            <div class="w-auto">
                <select name="category_id" class="p-2 border rounded w-full select2">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
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
                <th class="py-2 px-4 border-b">Price</th>
                <th class="py-2 px-4 border-b">Count</th>
                {{-- photo --}}
                <th class="py-2 px-4 border-b">Photo</th>
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
                <td class="py-2 px-4 border-b">{{ $product->price }} $</td>
                <td class="py-2 px-4 border-b">{{ $product->count }}</td>
                {{-- photo --}}
                <td class="py-2 px-4 border-b">
                    @if($product->photo && file_exists(public_path('storage/' . str_replace('public/', '', $product->photo))))
                        <img src="{{ asset('storage/' . str_replace('public/', '', $product->photo)) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-full">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($product->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-full">
                    @endif
                </td>
                <td class="py-2 px-4 border-b">{{ $product->detail }}</td>
                <td class="py-2 px-4 border-b text-right">
                    <form action="{{ route('products.destroy',$product->slug) }}" method="POST" class="inline-block">
                        <a href="{{ route('products.show',$product->slug) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('products.edit',$product->slug) }}" class="btn btn-primary btn-sm">
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

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a category',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush