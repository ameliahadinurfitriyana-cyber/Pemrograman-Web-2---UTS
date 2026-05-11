@extends('layouts.admin')

@section('content')
    @php
        $routePrefix = request()->routeIs('admin.products.*') ? 'admin.products' : 'products';
    @endphp

    <h1 class="text-2xl font-semibold mb-4">Create New Product</h1>

    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <span>Please fix the errors below:</span>
        </div>
    @endif

    <form method="POST" action="{{ route($routePrefix . '.store') }}" class="max-w-lg">
        @csrf

        <div class="form-control mb-4">
            <label for="name" class="label">
                <span class="label-text">Name</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" required />
            @error('name')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="category_id" class="label">
                <span class="label-text">Category</span>
            </label>
            <select id="category_id" name="category_id" class="select select-bordered w-full @error('category_id') select-error @enderror" required>
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="price" class="label">
                <span class="label-text">Price</span>
            </label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" class="input input-bordered w-full @error('price') input-error @enderror" min="0" step="0.01" required />
            @error('price')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="stock" class="label">
                <span class="label-text">Stock</span>
            </label>
            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" class="input input-bordered w-full @error('stock') input-error @enderror" min="0" step="1" required />
            @error('stock')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="description" class="label">
                <span class="label-text">Description (Optional)</span>
            </label>
            <textarea id="description" name="description" class="textarea textarea-bordered w-full">{{ old('description') }}</textarea>
        </div>

        <div class="form-control mb-4 flex flex-row gap-2">
            <button type="submit" class="btn btn-primary flex-1">Create Product</button>
            <a href="{{ route($routePrefix . '.index') }}" class="btn btn-ghost flex-1">Cancel</a>
        </div>
    </form>
@endsection
