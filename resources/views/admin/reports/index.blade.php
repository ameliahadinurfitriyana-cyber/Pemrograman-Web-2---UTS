@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Reports</h1>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
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
                        <td>{{ $transaction->customer->name ?? 'Walk-in' }}</td>
                        <td>Rp{{ number_format($transaction->total ?? 0, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</td>
                        <td><strong>Rp{{ number_format($transaction->grand_total, 0, ',', '.') }}</strong></td>
                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No reports found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
@endsection
