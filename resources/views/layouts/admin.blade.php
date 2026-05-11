<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Laravel</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@heroicons/vue@2.0.18/outline/index.js" defer></script>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Navbar -->
<div class="navbar bg-base-200 px-4">
    <div class="flex-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-xl font-bold">
            <!-- Heroicon home icon -->
            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H3a2 2 0 01-2-2V10z" />
            </svg> --}}

                <x-application-logo class="w-14 h-14 fill-current text-gray-500" />

            Toko Laravel
        </a>
    </div>

    <a href="{{ route('kasir.transactions.index') }}" class="btn btn-outline btn-error mr-4">Point of Sale</a>

            <!-- Dropdown for user name -->
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost">
                    {{ Auth::user()->name }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-40">
                    <li><a href="{{ route('profile.edit') }}">Profil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
</div>

    <!-- Main Layout -->
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-64 bg-base-100 p-4 border-r">
            <ul class="menu space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Dashboard icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                @if(Auth::user()?->role === 'admin')
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Users icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 1a4 4 0 100-8 4 4 0 000 8zm6 0a4 4 0 00-3-3.87" />
                        </svg>
                        Users Management
                    </a>
                </li>
                @endif
                @if(Auth::user()?->role === 'admin')
                <li>
                    <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('admin.customers.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Customers icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Customers Management
                    </a>
                </li>
                @elseif(Auth::user()?->role === 'kasir')
                <li>
                    <a href="{{ route('kasir.customers.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('kasir.customers.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Customers icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Customers Management
                    </a>
                </li>
                @endif
                @if(Auth::user()?->role === 'admin')
                <li>
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('categories.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Category icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h4l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                        </svg>
                        Categories Management
                    </a>
                </li>
                @endif
                @if(Auth::user()?->role === 'admin')
                <li>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('admin.products.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Products icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Products Management
                    </a>
                </li>
                @endif
                @if(Auth::user()?->role === 'kasir')
                <li>
                    <a href="{{ route('kasir.transactions.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('kasir.transactions.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Transactions icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Transactions Management
                    </a>
                </li>
                @endif
                @if(Auth::user()?->role === 'admin')
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('admin.reports.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Reports icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Reports
                    </a>
                </li>
                @elseif(Auth::user()?->role === 'kasir')
                <li>
                    <a href="{{ route('kasir.reports.index') }}" class="flex items-center gap-2 text-base font-medium {{ request()->routeIs('kasir.reports.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <!-- Reports icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Reports
                    </a>
                </li>
                @endif
            </ul>
        </aside>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white text-center py-4">
        &copy; {{ date('Y') }} Admin Panel. All rights reserved.
    </footer>

</body>
</html>
