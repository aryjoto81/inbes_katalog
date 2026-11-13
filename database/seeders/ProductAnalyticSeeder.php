<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductAnalytic;
use Carbon\Carbon;

class ProductAnalyticSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('Belum ada produk di database. Silakan buat produk terlebih dahulu.');
            return;
        }

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        foreach ($products as $product) {
            ProductAnalytic::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'year'       => $currentYear,
                    'month'      => $currentMonth,
                ],
                [
                    'clicks'     => rand(10, 250) // Berikan angka klik acak antara 10 sampai 250
                ]
            );
        }

        $this->command->info('Data dummy analitik klik produk berhasil diisi!');
    }
}
