<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('customer')->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.transactions.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'grand_total' => 0, // sementara
                'discount' => 0,
            ]);

            $grandTotal = 0;
            foreach ($request->products as $product_id => $quantity) {
                $product = Product::find($product_id);
                if ($quantity > 0) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                    $grandTotal += $quantity * $product->price;

                    // Kurangi stok
                    $product->decrement('stock', $quantity);
                }
            }

            $discount = 0;
            if ($grandTotal >= 200000) {
                $discount = $grandTotal * 0.02;
            }

            $transaction->update([
                'grand_total' => $grandTotal - $discount,
                'discount' => $discount,
            ]);
        });

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction created successfully.');
    }
}
