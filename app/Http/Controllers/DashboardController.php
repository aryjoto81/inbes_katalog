<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Carousel;
use App\Models\ProductAnalytic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total data untuk kartu statistik
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalAdmins     = Admin::count();
        $totalCarousels  = Carousel::count();

        // Ambil data produk trending bulan berjalan
        $currentYear  = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $trendingProducts = Product::with(['category'])
            ->join('product_analytics', 'products.id', '=', 'product_analytics.product_id')
            ->where('product_analytics.year', $currentYear)
            ->where('product_analytics.month', $currentMonth)
            ->orderBy('product_analytics.clicks', 'desc')
            ->select('products.*', 'product_analytics.clicks')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalAdmins',
            'totalCarousels',
            'trendingProducts'
        ));
    }
}
