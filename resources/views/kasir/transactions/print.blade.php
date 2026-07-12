<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #111827; }
        .header { text-align: center; margin-bottom: 16px; }
        .header h1 { margin: 0 0 4px; font-size: 20px; }
        .meta { font-size: 12px; color: #4b5563; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
        .total { font-weight: bold; }
        .footer { margin-top: 16px; font-size: 12px; color: #4b5563; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nota Pembelian</h1>
        <div>{{ $transaction->invoice_number ?? 'Invoice #' . $transaction->id }}</div>
    </div>

    <div class="meta">
        <div>Customer: {{ $transaction->customer->name ?? 'Walk-in' }}</div>
        <div>Tanggal: {{ $transaction->created_at->format('d M Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
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

    <div class="footer">
        <p>Total: Rp{{ number_format($transaction->total ?? 0, 0, ',', '.') }}</p>
        <p>Discount: Rp{{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</p>
        <p class="total">Grand Total: Rp{{ number_format($transaction->grand_total ?? $transaction->total ?? 0, 0, ',', '.') }}</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
