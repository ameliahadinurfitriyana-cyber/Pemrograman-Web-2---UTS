<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('customer')->paginate(10);
        return view('admin.reports.index', compact('transactions'));
    }
}
