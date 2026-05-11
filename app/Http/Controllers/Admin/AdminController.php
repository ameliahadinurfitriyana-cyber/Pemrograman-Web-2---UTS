<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Sisa stock
        $lowStockItems = Product::where('stock', '<=', 20)->get();

        // Barang paling laku
        $topProduct = Product::withCount('transactionDetails')
            ->orderBy('transaction_details_count', 'desc')
            ->first();

        // Barang tidak laku (belum pernah terjual)
        $unsoldProducts = Product::doesntHave('transactionDetails')->get();

        // Penjualan total
        $todaySales = Transaction::whereDate('created_at', today())->sum('total');
        $weeklySales = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total');
        $monthlySales = Transaction::whereMonth('created_at', now()->month)->sum('total');

        // Penjualan per tanggal untuk grafik (7 hari terakhir)
        $chartData = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'lowStockItems',
            'topProduct',
            'unsoldProducts',
            'todaySales',
            'weeklySales',
            'monthlySales',
            'chartData'
        ));
    }
}
