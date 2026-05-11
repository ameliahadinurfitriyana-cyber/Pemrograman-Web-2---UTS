<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class KasirReportController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->input('range', 'daily');
        $query = Transaction::query();

        switch ($range) {
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month);
                break;
            default:
                $query->whereDate('created_at', now()->toDateString());
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        return view('kasir.reports.index', compact('transactions', 'range'));
    }
}
