<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Report</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; margin: 24px; }
        .title { font-size: 20px; font-weight: bold; margin-bottom: 8px; }
        .meta { margin-bottom: 16px; color: #4b5563; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
        .total { font-weight: bold; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body>
    <div class="title">Laporan Transaksi Kasir</div>
    <div class="meta">Periode: {{ ucfirst($range) }} • Dicetak: {{ now()->format('d M Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Grand Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->invoice_number ?? '#' . $transaction->id }}</td>
                    <td>{{ $transaction->customer->name ?? 'Walk-in' }}</td>
                    <td>Rp{{ number_format($transaction->total ?? 0, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</td>
                    <td class="total">Rp{{ number_format($transaction->grand_total ?? $transaction->total ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>
</html>
