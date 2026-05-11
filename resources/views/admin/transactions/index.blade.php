@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Transactions</h1>
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">Create New Transaction</a>
    </div>

    <form method="GET" action="{{ route('admin.transactions.index') }}" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name" class="input input-bordered w-full max-w-xs" />
    </form>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Grand Total</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->customer->name ?? '-' }}</td>
                        <td>{{ $transaction->user->name ?? '-' }}</td>
                        <td>Rp{{ number_format($transaction->total ?? 0, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</td>
                        <td><strong>Rp{{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}</strong></td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">View</a>
                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
@endsection
