<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Carousel;
use App\Models\ProductAnalytic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FrontProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data carousel aktif
        $carousels = Carousel::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        // 2. Ambil data kategori aktif untuk tombol filter
        $categories = Category::where('status', 'active')->get();

        // 3. Logika Produk Trending (berdasarkan klik bulanan)
        $queryTrending = Product::with('category')->where('status', 'active');

        if ($request->has('search') && !empty($request->search)) {
            $queryTrending->where('name', 'like', '%' . $request->search . '%');
        }

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $trendingProducts = $queryTrending->select('products.*')
            ->leftJoin('product_analytics', function ($join) use ($currentYear, $currentMonth) {
                $join->on('products.id', '=', 'product_analytics.product_id')
                     ->where('product_analytics.year', '=', $currentYear)
                     ->where('product_analytics.month', '=', $currentMonth);
            })
            ->orderByRaw('COALESCE(product_analytics.clicks, 0) DESC')
            ->limit(12)
            ->get();

        // 4. Logika Katalog Semua Produk (dengan filter kategori & pencarian)
        $productQuery = Product::with('category')->where('status', 'active');

        // Jika user mengklik filter kategori tertentu
        if ($request->filled('category')) {
            $productQuery->where('category_id', $request->category);
        }

        // Jika ada pencarian
        if ($request->filled('search')) {
            $productQuery->where('name', 'like', '%' . $request->search . '%');
        }

        $allProducts = $productQuery->latest()->paginate(8);
        $totalProductsCount = $allProducts->count();
        $selectedCategory = $request->get('category');

        return view('front.home', compact(
            'carousels',
            'trendingProducts',
            'categories',
            'allProducts',
            'totalProductsCount',
            'selectedCategory'
        ));
    }

    public function trackAndRedirect($id)
    {
        $product = Product::where('id', $id)
            ->where('status', 'active')
            ->firstOrFail();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        ProductAnalytic::updateOrCreate(
            [
                'product_id' => $product->id,
                'year'       => $currentYear,
                'month'      => $currentMonth,
            ],
            [
                'clicks'     => DB::raw('clicks + 1')
            ]
        );

        if ($product->linkid) {
            return redirect()->away($product->linkid);
        }

        return redirect()->back();
    }


}
