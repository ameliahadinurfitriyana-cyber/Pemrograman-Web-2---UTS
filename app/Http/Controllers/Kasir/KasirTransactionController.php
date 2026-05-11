<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class KasirTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $transactions = Transaction::with('customer')
            ->when($search, function ($query, $search) {
                return $query->where('invoice_number', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kasir.transactions.index', compact('transactions', 'search'));
    }

    public function create()
    {
        $customers = Customer::all();
        $categories = Category::with(['products' => function ($query) {
            $query->where('stock', '>', 0)->orderBy('name');
        }])->orderBy('name')->get();

        // Format categories with products for JavaScript
        $categoriesData = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'products' => $category->products->map(function ($product) use ($category) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => (float) $product->price,
                        'stock' => $product->stock,
                        'category_name' => $category->name,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();

        return view('kasir.transactions.create', compact('customers', 'categories', 'categoriesData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Customer ID is optional (walk-in customers)
            $customerId = $request->customer_id;

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'customer_id' => $customerId,
                'total' => 0,
                'discount' => 0,
                'grand_total' => 0,
            ]);

            $total = 0;

            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            // Potongan 2% jika total di atas 200.000
            $discount = $total > 200000 ? $total * 0.02 : 0;
            $finalTotal = $total - $discount;

            $transaction->update([
                'total' => $total,
                'discount' => $discount,
                'grand_total' => $finalTotal,
            ]);
        });

        return redirect()->route('kasir.transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('customer', 'details.product');
        return view('kasir.transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('kasir.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
