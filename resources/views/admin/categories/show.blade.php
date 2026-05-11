@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Kategori</h1>
            <p class="text-gray-600">Daftar produk yang termasuk di dalam kategori ini</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('categories.index') }}" class="btn btn-ghost">Kembali</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Nama Kategori</p>
            <h2 class="mt-2 text-2xl font-semibold text-gray-900">{{ $category->name }}</h2>
            <div class="mt-4 space-y-2 text-sm text-gray-600">
                <p><span class="font-medium text-gray-800">Total Produk:</span> {{ $category->products->count() }}</p>
                <p><span class="font-medium text-gray-800">Dibuat:</span> {{ $category->created_at?->format('d M Y H:i') }}</p>
                <p><span class="font-medium text-gray-800">Diperbarui:</span> {{ $category->updated_at?->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Produk dalam Kategori</h3>
                    <p class="text-sm text-gray-500">Item yang terdaftar pada kategori ini</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($category->products as $product)
                            <tr>
                                <td class="font-medium">{{ $product->name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-500">Belum ada produk pada kategori ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
