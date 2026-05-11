@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Edit Customer</h1>

    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2-2l2 2m-2-2l-2-2m0 0l-2 2m2-2l2 2"></path></svg>
            <span>Please fix the errors below:</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}" class="max-w-lg">
        @csrf
        @method('PUT')

        <div class="form-control mb-4">
            <label for="name" class="label">
                <span class="label-text">Name</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $customer->name) }}" class="input input-bordered w-full @error('name') input-error @enderror" required />
            @error('name')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="phone" class="label">
                <span class="label-text">Phone</span>
            </label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" class="input input-bordered w-full @error('phone') input-error @enderror" required />
            @error('phone')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="email" class="label">
                <span class="label-text">Email (Optional)</span>
            </label>
            <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}" class="input input-bordered w-full" />
        </div>

        <div class="form-control mb-4">
            <label for="address" class="label">
                <span class="label-text">Address (Optional)</span>
            </label>
            <textarea id="address" name="address" class="textarea textarea-bordered w-full">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="form-control mb-4 flex flex-row gap-2">
            <button type="submit" class="btn btn-primary flex-1">Update Customer</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-ghost flex-1">Cancel</a>
        </div>
    </form>
@endsection
