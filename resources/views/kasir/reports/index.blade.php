@extends('layouts.admin')

@section('content')
    @php
        $totalSales = $transactions->sum(fn ($transaction) => (float) ($transaction->grand_total ?? $transaction->total ?? 0));
        $totalDiscount = $transactions->sum(fn ($transaction) => (float) ($transaction->discount ?? 0));
    @endphp

    <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Reports</h1>
            <p class="text-sm text-slate-500">Ringkasan transaksi kasir berdasarkan periode yang dipilih.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('kasir.reports.print', ['range' => $range]) }}" target="_blank" class="btn btn-outline btn-sm">Print Report</a>
            <form method="GET" action="{{ route('kasir.reports.index') }}" class="flex gap-2">
                <select name="range" class="select select-bordered select-sm" onchange="this.form.submit()">
                    <option value="daily" {{ $range == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ $range == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ $range == 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
            </form>
        </div>
    </div>

    <div class="mb-4 grid gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total Penjualan</p>
            <p class="text-xl font-semibold">Rp{{ number_format($totalSales, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Total Diskon</p>
            <p class="text-xl font-semibold">Rp{{ number_format($totalDiscount, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-sm text-slate-500">Jumlah Transaksi</p>
            <p class="text-xl font-semibold">{{ $transactions->count() }}</p>
        </div>
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
