<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use App\Models\TransactionDetail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function index(): View
    {
        // Statistics
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalKasirs = User::where('role', 'kasir')->count();
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total');

        // Monthly revenue for chart (last 12 months)
        $monthlyRevenue = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as revenue')
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'month' => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT),
                'revenue' => $item->revenue
            ];
        });

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'customer'])
            ->latest()
            ->take(5)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        // Notifications
        $notifications = collect([
            [
                'type' => 'warning',
                'message' => 'Produk dengan stok rendah: ' . $lowStockProducts->count() . ' item',
                'time' => now()->format('H:i')
            ],
            [
                'type' => 'info',
                'message' => 'Transaksi hari ini: ' . Transaction::whereDate('created_at', today())->count(),
                'time' => now()->format('H:i')
            ],
            [
                'type' => 'success',
                'message' => 'Pendapatan bulan ini: Rp ' . number_format(Transaction::whereMonth('created_at', now()->month)->sum('total')),
                'time' => now()->format('H:i')
            ]
        ]);

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalKasirs',
            'totalCustomers',
            'totalProducts',
            'totalTransactions',
            'totalRevenue',
            'monthlyRevenue',
            'recentTransactions',
            'lowStockProducts',
            'notifications'
        ));
    }

    // User Management
    public function usersIndex(): View
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate(): View
    {
        return view('admin.users.create');
    }

    public function usersShow(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function usersStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kasir',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function usersEdit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,kasir',
            'phone' => 'nullable|string|max:20',
        ]);

        $data = $request->only(['name', 'email', 'role', 'phone']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function usersDestroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    // Customer Management
    public function customersIndex(): View
    {
        $customers = Customer::paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function customersCreate(): View
    {
        return view('admin.customers.create');
    }

    public function customersStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function customersEdit(Customer $customer): View
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function customersUpdate(Request $request, Customer $customer): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function customersDestroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer berhasil dihapus.');
    }

    // Product Management
    public function productsIndex(): View
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function productsCreate(): View
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function productsStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil ditambahkan.');
    }

    public function productsEdit(Product $product): View
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function productsUpdate(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil diperbarui.');
    }

    public function productsDestroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product berhasil dihapus.');
    }

    // Transaction Management
    public function transactionsIndex(): View
    {
        $transactions = Transaction::with(['user', 'customer'])->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function transactionsCreate(): View
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();

        return view('admin.transactions.create', compact('customers', 'products'));
    }

    public function transactionsStore(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'products' => 'required|array',
        ]);

        $items = collect($request->input('products', []))
            ->mapWithKeys(function ($qty, $productId) {
                return [(int) $productId => (int) $qty];
            })
            ->filter(function ($qty) {
                return $qty > 0;
            });

        if ($items->isEmpty()) {
            return back()->withErrors(['products' => 'Pilih minimal satu produk dengan quantity lebih dari 0.'])->withInput();
        }

        DB::transaction(function () use ($request, $items) {
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'total' => 0,
                'discount' => 0,
                'grand_total' => 0,
            ]);

            $total = 0;

            foreach ($items as $productId => $quantity) {
                $product = Product::lockForUpdate()->findOrFail($productId);

                if ($quantity > $product->stock) {
                    abort(422, "Stok produk {$product->name} tidak mencukupi.");
                }

                $subtotal = $product->price * $quantity;
                $total += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $quantity);
            }

            $discount = $total > 200000 ? $total * 0.02 : 0;

            $transaction->update([
                'total' => $total,
                'discount' => $discount,
                'grand_total' => $total - $discount,
            ]);
        });

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function transactionsShow(Transaction $transaction): View
    {
        $transaction->load(['user', 'customer', 'details.product']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function transactionsDestroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    // Reports
    public function reportsIndex(): View
    {
        $transactions = Transaction::with('customer')->paginate(10);
        return view('admin.reports.index', compact('transactions'));
    }
}
