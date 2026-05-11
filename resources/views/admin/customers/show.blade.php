@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Customer Details</h1>

    <div class="card w-full max-w-2xl bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ $customer->name }}</h2>
            <div class="divider"></div>
            <p><strong>Phone:</strong> {{ $customer->phone }}</p>
            <p><strong>Email:</strong> {{ $customer->email ?? '-' }}</p>
            <p><strong>Address:</strong> {{ $customer->address ?? '-' }}</p>
            <p><strong>Created At:</strong> {{ $customer->created_at->format('d M Y H:i') }}</p>
            <p><strong>Updated At:</strong> {{ $customer->updated_at->format('d M Y H:i') }}</p>

            <div class="card-actions justify-end gap-2">
                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-ghost">Back</a>
            </div>
        </div>
    </div>
@endsection
