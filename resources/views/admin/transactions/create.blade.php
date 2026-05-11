@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Create New Transaction</h1>

    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2-2l2 2m-2-2l-2-2m0 0l-2 2m2-2l2 2"></path></svg>
            <span>Please fix the errors below:</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.transactions.store') }}" class="max-w-4xl">
        @csrf
        <div class="form-control mb-4">
            <label for="customer_id" class="label">
                <span class="label-text">Customer</span>
            </label>
            <select name="customer_id" id="customer_id" class="select select-bordered w-full @error('customer_id') select-error @enderror">
                <option value="">-- Select Customer --</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('customer_id')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Products</span>
            </label>
            <div class="overflow-x-auto">
                <table class="table table-compact w-full">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" name="products[{{ $product->id }}]" min="0" value="0" class="input input-bordered input-sm w-20" />
                                </td>
                                <td><span class="subtotal">0</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-control mb-4 flex flex-row gap-2">
            <button type="submit" class="btn btn-primary flex-1">Create Transaction</button>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-ghost flex-1">Cancel</a>
        </div>
    </form>
@endsection
