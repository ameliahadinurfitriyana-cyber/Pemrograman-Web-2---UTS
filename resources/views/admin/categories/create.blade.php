@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Tambah Kategori</h1>
            <p class="text-gray-600">Buat kategori baru untuk produk</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <span>Mohon periksa kembali input yang Anda isi.</span>
            </div>
        @endif

        <form method="POST" action="{{ route('categories.store') }}" class="bg-white rounded-xl shadow border p-6 space-y-5">
            @csrf

            <div class="form-control">
                <label class="label" for="name">
                    <span class="label-text font-medium">Nama Kategori</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    class="input input-bordered w-full @error('name') input-error @enderror"
                    placeholder="Contoh: Minuman"
                    required
                />
                @error('name')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary flex-1">Simpan Kategori</button>
                <a href="{{ route('categories.index') }}" class="btn btn-ghost flex-1">Kembali</a>
            </div>
        </form>
    </div>
@endsection
