<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class KasirCustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $customers = Customer::when($search, function ($q, $s) {
            $q->where('name', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%");
        })->orderBy('created_at', 'desc')->paginate(12);

        return view('kasir.customers.index', compact('customers', 'search'));
    }
}
