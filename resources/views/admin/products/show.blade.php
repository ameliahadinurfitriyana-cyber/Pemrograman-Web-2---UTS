@extends('layouts.admin')

@section('content')
    @php
        $routePrefix = request()->routeIs('admin.products.*') ? 'admin.products' : 'products';
    @endphp

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Product Detail</h1>
        <a href="{{ route($routePrefix . '.index') }}" class="btn btn-ghost">Back to Products</a>
    </div>

    <div class="card bg-base-100 shadow-xl max-w-2xl">
        <div class="card-body space-y-2">
            <div><span class="font-semibold">Name:</span> {{ $product->name }}</div>
            <div><span class="font-semibold">Category:</span> {{ $product->category?->name ?? '-' }}</div>
            <div><span class="font-semibold">Price:</span> Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div><span class="font-semibold">Stock:</span> {{ $product->stock }}</div>
            <div><span class="font-semibold">Description:</span> {{ $product->description ?: '-' }}</div>
        </div>
    </div>
@endsection
