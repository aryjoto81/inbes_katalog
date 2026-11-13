<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      x-data="{
          darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          toggleDarkMode() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('darkMode', this.darkMode);
          }
      }"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cekokom - Katalog Produk Resmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-gray-100 font-sans flex flex-col min-h-screen transition-colors duration-300" x-data="{ mobileMenuOpen: false }">

    <!-- A. HEADER / NAVIGATION BAR -->
    <header class="bg-gray-900 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo & Nama Perusahaan -->
                <a href="{{ route('front.home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Cekokom Logo" class="h-10 w-auto object-contain">
                    <span class="text-xl font-bold text-white tracking-tight">Cekokom</span>
                </a>



                <!-- Right Elements: Search & Language Switcher -->
                <div class="flex items-center space-x-4">

                    <button @click="toggleDarkMode()"
                            class="w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 text-yellow-400 flex items-center justify-center transition shadow-sm focus:outline-none"
                            :aria-label="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                        <!-- Ikon Matahari (Muncul saat mode gelap) -->
                        <i x-show="darkMode" class="fa-solid fa-sun text-base" style="display: none;"></i>
                        <!-- Ikon Bulan (Muncul saat mode terang) -->
                        <i x-show="!darkMode" class="fa-solid fa-moon text-base"></i>
                    </button>

                </div>

            </div>
        </div>

    </header>

    <!-- CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER SECTION (ABU-ABU GELAP) -->
    <footer class="bg-gray-900 border-t border-gray-800 py-10 mt-16 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">

            <!-- Logo & Nama Perusahaan di Footer -->
            <div class="flex items-center justify-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Cekokom Logo" class="h-10 w-auto object-contain">
                <span class="text-lg sm:text-xl font-extrabold tracking-wider text-white uppercase">
                    CEKOKOM
                </span>
            </div>

            <!-- Teks Hak Cipta & Keterangan Deploy -->
            <p class="text-xs sm:text-sm text-gray-400 max-w-md mx-auto leading-relaxed">
                &copy; 2026 Cekokom. Siap di-deploy ke Shared Hosting.
            </p>

            <!-- Ikon Media Sosial -->
            <div class="flex items-center justify-center space-x-4 pt-2">
                <!-- Instagram -->
                <a href="#" class="w-9 h-9 rounded-full bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:bg-blue-600 hover:border-blue-600 flex items-center justify-center transition" aria-label="Instagram">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <!-- Facebook -->
                <a href="#" class="w-9 h-9 rounded-full bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:bg-blue-600 hover:border-blue-600 flex items-center justify-center transition" aria-label="Facebook">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                    </svg>
                </a>
                <!-- TikTok -->
                <a href="#" class="w-9 h-9 rounded-full bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:bg-blue-600 hover:border-blue-600 flex items-center justify-center transition" aria-label="TikTok">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.589 6.686a4.793 4.793 0 01-3.77-4.242V2h-3.445v13.672a2.896 2.896 0 01-5.201 1.743l-.002-.003a2.895 2.895 0 012.316-4.646c.338 0 .66.057.962.16V9.272a6.314 6.314 0 00-1.018-.088 6.345 6.345 0 00-6.345 6.345 6.344 6.344 0 006.345 6.345 6.348 6.348 0 006.345-6.345V9.382a8.169 8.169 0 004.773 1.523V7.472a4.793 4.793 0 01-1.003-.786z"/>
                    </svg>
                </a>
            </div>

        </div>
    </footer>

</body>
</html>
