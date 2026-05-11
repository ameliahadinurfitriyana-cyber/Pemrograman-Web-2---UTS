@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Category Management</h1>
            <p class="text-gray-600">Kelola kategori produk dengan cepat</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    <div class="mb-4">
        <form method="GET" action="{{ route('categories.index') }}" class="flex gap-2 max-w-md">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kategori..." class="input input-bordered w-full" />
            <button type="submit" class="btn btn-outline">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow border">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Total Produk</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="font-medium">{{ $category->name }}</td>
                        <td>{{ $category->products_count ?? $category->products()->count() }}</td>
                        <td>{{ $category->created_at?->format('d M Y H:i') }}</td>
                        <td class="space-x-2">
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-error">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">Belum ada kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection
