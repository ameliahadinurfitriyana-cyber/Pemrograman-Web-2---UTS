@extends('layouts.admin')

@section('content')
    @php
        $routePrefix = request()->routeIs('admin.products.*') ? 'admin.products' : 'products';
    @endphp

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Products</h1>
        <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary">Create New Product</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="GET" action="{{ route($routePrefix . '.index') }}" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="input input-bordered w-full max-w-xs" />
    </form>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category?->name ?? '-' }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="flex gap-2">
                            <a href="{{ route($routePrefix . '.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route($routePrefix . '.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection
