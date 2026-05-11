@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Customers</h1>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">Create New Customer</a>
    </div>

    <form method="GET" action="{{ route('admin.customers.index') }}" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name" class="input input-bordered w-full max-w-xs" />
    </form>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email ?? '-' }}</td>
                        <td>{{ Str::limit($customer->address, 30) ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No customers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>
@endsection
