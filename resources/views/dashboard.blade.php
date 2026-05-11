<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-600">Kasir Dashboard</p>
                <h2 class="font-semibold text-2xl text-blue-800 dark:text-blue-800 leading-tight">Selamat datang, {{ $user->name }}</h2>
            </div>
            <p class="text-sm text-gray-500 dark:text-blue-400">Akses cepat untuk transaksi dan laporan harian.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 space-y-6">
            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-600">Quick Access</p>
                        <h3 class="mt-2 text-2xl font-bold text-slate-900 dark:text-gray-100">Pilihan paling sering dipakai</h3>
                        <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-gray-300">Gunakan shortcut berikut untuk masuk ke transaksi, melihat laporan transaksi, atau kembali ke dashboard dengan cepat.</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                            Dashboard
                        </a>
                        <a href="{{ route('kasir.transactions.index') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">
                            Transaksi
                        </a>
                        <a href="{{ route('kasir.reports.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                            Report Transaksi
                        </a>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                <a href="{{ route('kasir.transactions.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">Shortcut</p>
                    <h4 class="mt-2 text-lg font-semibold text-slate-900 dark:text-gray-100">Transaksi</h4>
                    <p class="mt-2 text-sm text-slate-600 dark:text-gray-300">Buka halaman transaksi untuk proses penjualan.</p>
                </a>

                <a href="{{ route('kasir.reports.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">Shortcut</p>
                    <h4 class="mt-2 text-lg font-semibold text-slate-900 dark:text-gray-100">Report Transaksi</h4>
                    <p class="mt-2 text-sm text-slate-600 dark:text-gray-300">Lihat ringkasan transaksi harian, mingguan, atau bulanan.</p>
                </a>

                <a href="{{ route('kasir.dashboard') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">Shortcut</p>
                    <h4 class="mt-2 text-lg font-semibold text-slate-900 dark:text-gray-100">Dashboard</h4>
                    <p class="mt-2 text-sm text-slate-600 dark:text-gray-300">Kembali ke halaman utama kasir kapan saja.</p>
                </a>
            </section>

            <section class="grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="rounded-2xl bg-slate-900 p-6 text-white shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-300">Akun Aktif</p>
                    <h4 class="mt-2 text-2xl font-bold">{{ $user->name }}</h4>
                    <p class="mt-1 text-sm text-slate-300">{{ $user->email }}</p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Edit Profil</a>
                        <a href="{{ route('logout') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </div>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">Panduan Singkat</p>
                    <ul class="mt-4 space-y-3 text-sm text-slate-700 dark:text-gray-300">
                        <li class="rounded-xl bg-slate-50 px-4 py-3 dark:bg-gray-700/60">1. Mulai dari menu Transaksi untuk input penjualan.</li>
                        <li class="rounded-xl bg-slate-50 px-4 py-3 dark:bg-gray-700/60">2. Buka Report Transaksi untuk melihat ringkasan data.</li>
                        <li class="rounded-xl bg-slate-50 px-4 py-3 dark:bg-gray-700/60">3. Gunakan Dashboard jika ingin kembali ke halaman utama.</li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
