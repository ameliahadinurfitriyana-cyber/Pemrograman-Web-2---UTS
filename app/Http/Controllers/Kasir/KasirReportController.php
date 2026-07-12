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
        $transactions = $this->getTransactions($range);

        return view('kasir.reports.index', compact('transactions', 'range'));
    }

    public function print(Request $request)
    {
        $range = $request->input('range', 'daily');
        $transactions = $this->getTransactions($range);

        return view('kasir.reports.print', compact('transactions', 'range'));
    }

    protected function getTransactions(string $range)
    {
        $query = Transaction::query();

        switch ($range) {
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek()->toDateTimeString(), now()->endOfWeek()->toDateTimeString()]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month);
                break;
            default:
                $query->whereDate('created_at', now()->toDateString());
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
