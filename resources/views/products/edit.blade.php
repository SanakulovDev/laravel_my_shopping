@extends('products.layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Edit Product</h2>
        <a class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-md" href="{{ route('products.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back
        </a>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md">
        <div class="flex items-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="font-medium">Please correct the following errors:</p>
        </div>
        <ul class="list-disc ml-8">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="bg-white shadow-lg rounded-xl p-8 mb-8" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6 md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Basic Information</h3>
            </div>
            
            <div class="form-group @error('name') has-error @enderror">
                <label class="block text-gray-700 font-medium mb-2" for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Enter product name" value="{{ $product->name }}">
                @error('name')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group @error('price') has-error @enderror">
                <label class="block text-gray-700 font-medium mb-2" for="price">Price</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" id="price" step="0.01" name="price" class="form-control w-full pl-8 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="0.00" value="{{ $product->price }}">
                </div>
                @error('price')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group @error('count') has-error @enderror">
                <label class="block text-gray-700 font-medium mb-2" for="count">Inventory Count</label>
                <input type="number" id="count" name="count" class="form-control w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Available quantity" value="{{ $product->count }}">
                @error('count')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group @error('category_id') has-error @enderror">
                <label class="block text-gray-700 font-medium mb-2" for="category">Category</label>
                <select id="category" name="category_id" class="form-control w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none bg-white">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group @error('detail') has-error @enderror md:col-span-2">
                <label class="block text-gray-700 font-medium mb-2" for="editor">Product Description</label>
                <textarea id="editor" name="detail" class="form-control w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" rows="5" placeholder="Detailed product description">{{ $product->detail }}</textarea>
                @error('detail')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group @error('photo') has-error @enderror md:col-span-2">
                <label class="block text-gray-700 font-medium mb-2">Product Image</label>
                
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    @if($product->photo)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="text-center mb-2">
                            <span class="text-xs font-medium bg-blue-100 text-blue-600 py-1 px-2 rounded">Current Image</span>
                        </div>
                        <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-40 h-40 object-cover rounded-lg shadow-md">
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <label for="photo-upload" class="flex flex-col items-center w-full max-w-lg p-6 text-center bg-white border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-gray-500">Click to upload new image</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
                            <input id="photo-upload" type="file" name="photo" class="hidden">
                        </label>
                        <p class="text-sm text-gray-500 mt-2">Leave empty to keep current image</p>
                    </div>
                </div>
                
                @error('photo')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="mt-10 border-t pt-6 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium px-8 py-3 rounded-lg transition-all duration-200 shadow-md flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'],
                placeholder: 'Enter detailed product description here...'
            })
            .catch(error => {
                console.error(error);
            });
            
        // Show file name when selected
        const fileInput = document.getElementById('photo-upload');
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                const fileInfo = document.createElement('p');
                fileInfo.className = 'text-sm text-blue-600 mt-2';
                fileInfo.textContent = `Selected: ${fileName}`;
                
                // Remove previous file info if exists
                const previousInfo = fileInput.parentNode.querySelector('.text-blue-600');
                if (previousInfo) {
                    previousInfo.remove();
                }
                
                fileInput.parentNode.appendChild(fileInfo);
            }
        });
    });
</script>
@endsection
