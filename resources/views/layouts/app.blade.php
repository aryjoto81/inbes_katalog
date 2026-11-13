<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Admin Panel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk interaksi dropdown/sidebar mobile -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto flex flex-col border-r border-slate-800">
            <!-- Brand / Logo -->

            <!-- Brand / Logo (Kode Baru dengan Logo & Nama Perusahaan) -->
            <div class="flex items-center justify-between h-16 px-6 bg-slate-950 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <!-- Gambar Logo Perusahaan -->
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan" class="h-8 w-auto object-contain">

                    <!-- Nama Perusahaan -->
                    <span class="font-bold text-base text-white tracking-wide truncate">
                        Cekokom
                    </span>
                </a>

                <!-- Tombol Close Sidebar (Tampilan Mobile) -->
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white focus:outline-none">
                    ✕
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                    📊 Dashboard
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Manajemen Toko</div>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('admin.categories*') ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                    📁 Kategori
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('admin.products*') ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                    📦 Produk
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengaturan</div>

                <a href="{{ route('admin.carousels.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('admin.carousels*') ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                    🖼️ Carousel Banner
                </a>

                <a href="{{ route('admin.admins.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('admin.admins*') ? 'bg-indigo-600 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                    👥 Administrator
                </a>


            </nav>

            <!-- Sidebar Footer / Info User -->
            <div class="p-4 bg-slate-950 border-t border-slate-800 flex items-center justify-between">
                <div class="text-xs truncate">
                    <p class="font-medium text-white truncate">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                    <p class="text-slate-400 truncate">{{ Auth::guard('admin')->user()->email ?? '' }}</p>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- TOP HEADER -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10 shadow-xs">
                <!-- Hamburger Menu for Mobile -->
                <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="hidden md:block text-sm font-bold text-gray-500">
                    Sistem Manajemen Katalog Produk
                </div>

                <!-- Right Profile / Logout -->
                <div class="flex items-center space-x-4">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-200 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition shadow-xs">
                            Keluar
                        </button>
                    </form>
                </div>
            </header>

            <!-- MAIN CONTENT AREA -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

</body>
</html>
