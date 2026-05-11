@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Reports</h1>
        <form method="GET" action="{{ route('kasir.reports.index') }}" class="flex gap-2">
            <select name="range" class="select select-bordered select-sm" onchange="this.form.submit()">
                <option value="daily" {{ $range == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ $range == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ $range == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Invoice</th>
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
                        <td>{{ $transaction->invoice_number ?? '#' . $transaction->id }}</td>
                        <td>{{ $transaction->customer->name ?? 'Walk-in' }}</td>
                        <td>Rp{{ number_format($transaction->total ?? 0, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</td>
                        <td><strong>Rp{{ number_format($transaction->grand_total ?? $transaction->total ?? 0, 0, ',', '.') }}</strong></td>
                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('kasir.transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
