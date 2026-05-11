<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalProducts = Product::count();
        $totalRevenue = Transaction::sum('total');

        $recentTransactions = Transaction::with(['customer', 'user'])->latest()->take(5)->get();

$monthlyRevenue = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month_num'),
            DB::raw('SUM(total) as revenue')
        )->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
         ->get()
         ->map(function ($item) {
             $item->month = Carbon::createFromDate($item->year, $item->month_num)->monthName;
             return $item;
         })
         ->sortByDesc(function ($item) {
             return $item->year * 100 + $item->month_num;
         })
         ->values();

        $notifications = [
            ['type' => 'info', 'message' => 'Sistem berjalan normal', 'time' => 'Baru saja'],
            ['type' => 'success', 'message' => 'Backup database berhasil', 'time' => '2 jam lalu'],
            ['type' => 'warning', 'message' => 'Stok rendah pada 3 produk', 'time' => '1 hari lalu'],
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransactions',
            'totalProducts',
            'totalRevenue',
            'recentTransactions',
            'monthlyRevenue',
            'notifications'
        ));
    }
}
