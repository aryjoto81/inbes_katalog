@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header sambutan -->
    <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::guard('admin')->user()->name }}! 👋</h1>
            <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan performa dan statistik toko Anda bulan ini.</p>
        </div>
        <div class="text-right hidden sm:block">
            <span class="text-xs font-semibold px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full">
                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
            </span>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Produk -->
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Produk</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg text-xl">📦</div>
        </div>

        <!-- Total Kategori -->
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalCategories) }}</p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg text-xl">📁</div>
        </div>

        <!-- Total Administrator -->
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Administrator</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalAdmins) }}</p>
            </div>
            <div class="p-3 bg-purple-50 text-purple-600 rounded-lg text-xl">👥</div>
        </div>

        <!-- Total Carousel Slide -->
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Carousel Slide</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalCarousels) }}</p>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg text-xl">🖼️</div>
        </div>
    </div>

    <!-- Tabel Produk Trending Bulan Ini -->
    <div class="bg-white shadow-xs rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800">🔥 Produk Paling Trending Bulan Ini</h2>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Lihat Semua Produk &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-600 uppercase tracking-wider">Total Klik (Bulan Ini)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($trendingProducts as $item)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold text-indigo-600">
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs">
                                {{ number_format($item->clicks) }} klik
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            Belum ada data klik produk pada bulan ini. Silakan kunjungi beberapa halaman produk di front-end untuk menguji pencatatan klik.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
