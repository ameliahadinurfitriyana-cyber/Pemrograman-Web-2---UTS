<nav x-data="{ open: false }" class="bg-base-100 shadow">
    <div class="navbar max-w-7xl mx-auto">
        <!-- Logo -->
        <div class="flex-1">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-xl">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <!-- Tambahkan link lain di sini -->
            </ul>
        </div>

        <!-- User Dropdown -->
        <div class="hidden lg:flex lg:items-center">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost">
                    {{ Auth::user()->name }}
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-ghost w-full text-left">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Hamburger (Mobile) -->
        <div class="lg:hidden">
            <button @click="open = !open" class="btn btn-ghost">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="lg:hidden px-4 pb-4">
        <ul class="menu bg-base-100 rounded-box">
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost w-full text-left">Log Out</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
