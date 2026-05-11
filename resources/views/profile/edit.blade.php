<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-600">Profil Kasir</p>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Kelola akun {{ $user->name }}
                </h2>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Perbarui identitas, keamanan, dan detail akun yang digunakan saat bekerja.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-6 text-white shadow-sm lg:col-span-1">
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-100">Ringkasan Akun</p>
                    <div class="mt-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-white/10 text-2xl font-bold uppercase">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="mt-5 text-2xl font-semibold">{{ $user->name }}</h3>
                    <p class="mt-1 text-sm text-blue-100">{{ $user->email }}</p>
                    <div class="mt-4 space-y-2 text-sm text-blue-50">
                        <p>Role: {{ ucfirst($user->role ?? 'kasir') }}</p>
                        <p>No. HP: {{ $user->phone ?? '-' }}</p>
                        <p>Status email: {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum terverifikasi' }}</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Cepat</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Data ini dipakai saat transaksi dan notifikasi akun.</p>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-700/50">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-700/50">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-700/50">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nomor HP</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-700/50">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Peran</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst($user->role ?? 'kasir') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="grid gap-6">
                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:p-8">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:p-8">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:p-8">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
