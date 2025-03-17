@extends('products.layout')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl">Add New Product</h2>
        <a class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded" href="{{ route('products.index') }}"> Back</a>
    </div>
    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div class="form-group @error('name') has-error @enderror">
                <label class="block text-gray-700">Name:</label>
                <input type="text" name="name" class="form-control border rounded w-full py-2 px-3" placeholder="Name" value="{{ old('name') }}">
                @error('name')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group @error('detail') has-error @enderror">
                <label class="block text-gray-700">Detail:</label>
                <input type="text" name="detail" class="form-control border rounded w-full py-2 px-3" placeholder="Detail" value="{{ old('detail') }}">
                @error('detail')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group @error('price') has-error @enderror">
                <label class="block text-gray-700">Price:</label>
                <input type="number" step="0.01" name="price" class="form-control border rounded w-full py-2 px-3" placeholder="Price" value="{{ old('price') }}">
                @error('price')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group @error('category_id') has-error @enderror">
                <label class="block text-gray-700">Category:</label>
                <select name="category_id" class="form-control border rounded w-full py-2 px-3">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group @error('product_type_id') has-error @enderror">
                <label class="block text-gray-700">Product Type (Dimensions):</label>
                <select name="product_type_id" class="form-control border rounded w-full py-2 px-3">
                    <option value="">Select Product Type</option>
                    @foreach($productTypes as $type)
                        <option value="{{ $type->id }}" {{ old('product_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} ({{ $type->dimensions }})
                        </option>
                    @endforeach
                </select>
                @error('product_type_id')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group @error('photos') has-error @enderror">
                <label class="block text-gray-700">Photos:</label>
                <input type="file" name="photos[]" class="form-control border rounded w-full py-2 px-3" multiple accept="image/*">
                <p class="text-gray-500 text-sm mt-1">You can select multiple photos</p>
                @error('photos')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
                @error('photos.*')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </div>
    </form>
@endsection

