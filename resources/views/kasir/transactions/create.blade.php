@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold">Create New Transaction</h1>
        <p class="text-sm text-gray-500">Pilih kategori, pilih item, lalu tambahkan ke daftar transaksi.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l2 2m2-2l2 2m-2-2l-2-2m0 0l2-2m-2 2l2 2"></path></svg>
            <span>Please fix the errors below:</span>
        </div>
    @endif

    <form method="POST" action="{{ route('kasir.transactions.store') }}" class="space-y-6">
        @csrf

        <div class="grid gap-4 lg:grid-cols-2">
            <div class="form-control">
                <label for="customer_id" class="label">
                    <span class="label-text">Customer (Optional)</span>
                </label>
                <select name="customer_id" id="customer_id" class="select select-bordered w-full">
                    <option value="">-- Walk-in Customer --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="rounded-xl border bg-white p-4 shadow-sm">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="form-control">
                        <label for="category_id" class="label">
                            <span class="label-text">Category</span>
                        </label>
                        <select id="category_id" class="select select-bordered w-full">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control sm:col-span-2 lg:col-span-1">
                        <label for="product_id" class="label">
                            <span class="label-text">Item / Product</span>
                        </label>
                        <select id="product_id" class="select select-bordered w-full" disabled>
                            <option value="">-- Select Category First --</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label for="quantity" class="label">
                            <span class="label-text">Qty</span>
                        </label>
                        <input type="number" id="quantity" min="1" value="1" class="input input-bordered w-full" />
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button type="button" id="add-item-btn" class="btn btn-primary">Tambah Item</button>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-white p-4 shadow-sm">
            <div class="mb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Daftar Item</h2>
                    <p class="text-sm text-gray-500">Item yang ditambahkan akan muncul di sini.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Sementara</p>
                    <p id="grand-total-display" class="text-xl font-bold">Rp 0</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full" id="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="items-tbody">
                        <tr id="empty-row">
                            <td colspan="7" class="text-center text-gray-500">Belum ada item yang ditambahkan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-control flex flex-row gap-2">
            <button type="submit" class="btn btn-primary flex-1">Complete Transaction</button>
            <a href="{{ route('kasir.transactions.index') }}" class="btn btn-ghost flex-1">Cancel</a>
        </div>
    </form>

    <script>
        const categorySelect = document.getElementById('category_id');
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const addItemButton = document.getElementById('add-item-btn');
        const itemsTbody = document.getElementById('items-tbody');
        const emptyRow = document.getElementById('empty-row');
        const grandTotalDisplay = document.getElementById('grand-total-display');

        const categories = @json($categoriesData);

        let itemIndex = 0;
        let grandTotal = 0;

        function formatCurrency(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function renderProducts(categoryId) {
            productSelect.innerHTML = '';

            if (!categoryId) {
                productSelect.disabled = true;
                productSelect.innerHTML = '<option value="">-- Select Category First --</option>';
                return;
            }

            const selectedCategory = categories.find(category => String(category.id) === String(categoryId));
            const products = selectedCategory ? selectedCategory.products : [];

            productSelect.disabled = products.length === 0;

            if (!products.length) {
                productSelect.innerHTML = '<option value="">-- No items in this category --</option>';
                return;
            }

            productSelect.innerHTML = '<option value="">-- Select Item --</option>';

            products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = `${product.name} - ${formatCurrency(product.price)} (Stock: ${product.stock})`;
                option.dataset.price = product.price;
                option.dataset.stock = product.stock;
                option.dataset.categoryName = product.category_name;
                option.dataset.productName = product.name;
                productSelect.appendChild(option);
            });
        }

        function updateGrandTotal() {
            grandTotalDisplay.textContent = formatCurrency(grandTotal);
        }

        function toggleEmptyRow() {
            const hasRows = itemsTbody.querySelectorAll('tr[data-item-row="true"]').length > 0;
            emptyRow.style.display = hasRows ? 'none' : '';
        }

        categorySelect.addEventListener('change', function () {
            renderProducts(this.value);
        });

        addItemButton.addEventListener('click', function () {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productId = productSelect.value;
            const quantity = parseInt(quantityInput.value, 10);

            if (!productId) {
                alert('Silakan pilih item terlebih dahulu.');
                return;
            }

            if (!quantity || quantity < 1) {
                alert('Quantity minimal 1.');
                return;
            }

            const stock = parseInt(selectedOption.dataset.stock, 10);
            if (quantity > stock) {
                alert('Quantity melebihi stock yang tersedia.');
                return;
            }

            const price = parseFloat(selectedOption.dataset.price);
            const subtotal = price * quantity;
            const categoryName = selectedOption.dataset.categoryName;
            const productName = selectedOption.dataset.productName;

            if (emptyRow) {
                emptyRow.remove();
            }

            const row = document.createElement('tr');
            row.dataset.itemRow = 'true';
            row.dataset.subtotal = subtotal;
            row.innerHTML = `
                <td>
                    <div class="font-medium">${productName}</div>
                    <input type="hidden" name="products[${itemIndex}][product_id]" value="${productId}" />
                </td>
                <td>${categoryName}</td>
                <td>${formatCurrency(price)}</td>
                <td>${stock}</td>
                <td>
                    <input type="number" name="products[${itemIndex}][quantity]" value="${quantity}" min="1" max="${stock}" class="input input-bordered input-sm w-20" />
                </td>
                <td class="subtotal-cell">${formatCurrency(subtotal)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-error remove-item-btn">Hapus</button>
                </td>
            `;

            const quantityField = row.querySelector('input[name$="[quantity]"]');
            quantityField.addEventListener('input', function () {
                let qty = parseInt(this.value, 10);
                if (!qty || qty < 1) {
                    qty = 1;
                    this.value = 1;
                }
                if (qty > stock) {
                    qty = stock;
                    this.value = stock;
                }
                const newSubtotal = price * qty;
                row.dataset.subtotal = newSubtotal;
                row.querySelector('.subtotal-cell').textContent = formatCurrency(newSubtotal);
                recalculateTotal();
            });

            row.querySelector('.remove-item-btn').addEventListener('click', function () {
                row.remove();
                recalculateTotal();
                toggleEmptyRow();
            });

            itemsTbody.appendChild(row);
            itemIndex += 1;
            grandTotal += subtotal;
            updateGrandTotal();
            toggleEmptyRow();
        });

        function recalculateTotal() {
            grandTotal = 0;
            itemsTbody.querySelectorAll('tr[data-item-row="true"]').forEach(row => {
                grandTotal += parseFloat(row.dataset.subtotal || 0);
            });
            updateGrandTotal();
        }

        toggleEmptyRow();
    </script>
@endsection
