<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('year');
            $table->unsignedTinyInteger('month'); // 1 sampai 12
            $table->unsignedBigInteger('clicks')->default(0);
            $table->timestamps();

            // Memastikan kombinasi product_id, year, dan month unik
            $table->unique(['product_id', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_analytics');
    }
};
