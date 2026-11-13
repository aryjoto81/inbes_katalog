@extends('layouts.front')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Judul & Search Bar Halaman Katalog -->
    <div class="mb-8 border-b pb-4 border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                📦 {{ app()->getLocale() == 'en' ? 'All Products Catalog' : 'Katalog Seluruh Produk' }}
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                {{ app()->getLocale() == 'en' ? 'Explore our products grouped by category' : 'Jelajahi produk kami yang dikelompokkan berdasarkan kategori' }}
            </p>
        </div>

        <!-- Form Pencarian Katalog -->
        <form action="{{ route('front.products') }}" method="GET" class="relative w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ app()->getLocale() == 'en' ? 'Search in catalog...' : 'Cari di katalog...' }}"
                   class="w-full sm:w-64 text-xs bg-white border border-gray-300 rounded-full pl-9 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>
    </div>

    <!-- Perulangan Kategori & Produknya -->
    @forelse($categories as $category)
        @if($category->products->count() > 0)
        <div class="mb-12">
            <!-- Label Header Kategori -->
            <div class="flex items-center justify-between mb-6 bg-indigo-50/50 px-4 py-3 rounded-xl border border-indigo-100">
                <h2 class="text-lg sm:text-xl font-bold text-indigo-900 tracking-tight flex items-center gap-2">
                    📂 {{ $category->name }}
                </h2>
                <span class="text-[11px] sm:text-xs font-semibold bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
                    {{ $category->products->count() }} {{ app()->getLocale() == 'en' ? 'Items' : 'Produk' }}
                </span>
            </div>

            <!-- Grid Produk (3 Kolom di HP, 4 Kolom di Desktop) -->
            <div class="grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($category->products as $product)
                <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden hover:shadow-md transition duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Gambar Produk -->
                        <div class="h-32 sm:h-48 w-full bg-gray-100 relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                            @endif
                        </div>

                        <!-- Informasi Teks Produk -->
                        <div class="p-2 sm:p-4">
                            <h3 class="font-bold text-gray-800 text-[11px] sm:text-sm line-clamp-1 group-hover:text-indigo-600 transition">
                                {{ $product->name }}
                            </h3>
                            <p class="text-[10px] sm:text-xs text-gray-500 mt-1 line-clamp-2">
                                {{ $product->description ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Kartu: Harga & Tombol Aksi -->
                    <div class="p-2 sm:p-4 pt-0 border-t border-gray-50 mt-2 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <div class="text-indigo-600 font-extrabold text-[11px] sm:text-sm">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        @if($product->linkid)
                            <a href="{{ route('front.product.visit', $product->id) }}"
                            target="_blank"
                            class="w-full sm:w-auto text-center px-2.5 py-1.5 bg-gray-900 hover:bg-indigo-600 text-white text-[10px] sm:text-xs font-medium rounded-lg transition">
                                {{ app()->getLocale() == 'en' ? 'View' : 'Lihat' }}
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @empty
        <div class="py-16 text-center text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
            <p class="text-base font-medium">{{ app()->getLocale() == 'en' ? 'No products or categories available.' : 'Belum ada produk atau kategori yang tersedia.' }}</p>
        </div>
    @endforelse

</div>
@endsection
