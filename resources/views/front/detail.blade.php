@extends('layouts.front')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('front.home') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center mb-6">
        &larr; {{ app()->getLocale() == 'en' ? 'Back to Catalog' : 'Kembali ke Katalog' }}
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-8">
        <!-- Gambar Produk -->
        <div class="h-80 w-full bg-gray-100 rounded-xl overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
            @else
                <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
            @endif
        </div>

        <!-- Detail Produk -->
        <div class="flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </span>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-3">{{ $product->name }}</h1>

                <div class="text-2xl font-bold text-indigo-600 mt-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="mt-6 border-t border-gray-100 pt-4">
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        {{ app()->getLocale() == 'en' ? 'Description' : 'Deskripsi Produk' }}
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $product->description ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Tombol Aksi Mengarah ke linkid -->
            <div class="mt-8 pt-4 border-t border-gray-100">
                @if($product->linkid)
                    <a href="{{ $product->linkid }}"
                       target="_blank"
                       class="w-full flex items-center justify-center py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                        🔗 {{ app()->getLocale() == 'en' ? 'Open Product Link' : 'Buka Link Produk' }}
                    </a>
                @else
                    <span class="block text-center text-xs text-gray-400 italic">Link tidak tersedia</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
