<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Toko Laravel</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col h-screen overflow-hidden">

    <!-- Top Menu - Sticky -->
    <nav class="navbar bg-base-200 shadow-md px-6 flex-none z-50">
        <div class="flex-1">
            <a href="{{ route('kasir.dashboard') }}" class="text-xl font-bold">Kasir Panel</a>
        </div>
        <div class="flex space-x-4 items-center">
            <a href="{{ route('kasir.dashboard') }}" class="btn btn-ghost">Dashboard</a>

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
    </nav>

    <!-- Main Content - Scrollable -->
    <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
    </main>

    <!-- Footer - Sticky -->
    <footer class="bg-blue-900 text-white text-center py-4 flex-none z-50">
        &copy; {{ date('Y') }} Kasir Panel. All rights reserved.
    </footer>

</body>
</html>
