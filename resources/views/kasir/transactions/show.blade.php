@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Transaction Details</h1>

    <div class="card w-full max-w-4xl bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ $transaction->invoice_number ?? 'Invoice #' . $transaction->id }}</h2>
            <div class="divider"></div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p><strong>Customer:</strong> {{ $transaction->customer->name ?? 'Walk-in' }}</p>
                </div>
                <div>
                    <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="overflow-x-auto mb-4">
                <table class="table table-compact w-full">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>Rp{{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>

            <div class="flex justify-end gap-4 mb-4">
                <div>
                    <p class="mb-2"><strong>Total:</strong> Rp{{ number_format($transaction->total ?? 0, 0, ',', '.') }}</p>
                    <p class="mb-2"><strong>Discount:</strong> Rp{{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</p>
                    <p class="text-lg"><strong>Grand Total:</strong> <span class="text-success">Rp{{ number_format($transaction->grand_total ?? $transaction->total ?? 0, 0, ',', '.') }}</span></p>
                </div>
            </div>

            <div class="card-actions justify-end gap-2">
                <a href="{{ route('kasir.transactions.print', $transaction->id) }}" target="_blank" class="btn btn-primary">Print Nota</a>
                <form action="{{ route('kasir.transactions.destroy', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="{{ route('kasir.transactions.index') }}" class="btn btn-ghost">Back</a>
            </div>
        </div>
    </div>
@endsection
