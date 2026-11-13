@extends('layouts.front')

@section('content')
<div class="space-y-12 pb-16">

    <!-- 1. CAROUSEL BANNER SECTION -->
    @if(isset($carousels) && $carousels->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
        <section class="relative w-full overflow-hidden bg-gray-900 dark:bg-gray-900 dark:border dark:border-gray-800 rounded-2xl sm:rounded-3xl shadow-md" x-data="{ activeSlide: 0, slides: {{ $carousels->count() }}, timer: null }" x-init="timer = setInterval(() => { activeSlide = (activeSlide + 1) % slides }, 5000)">
            <div class="relative h-[350px] sm:h-[450px] md:h-[500px] w-full">
                @foreach($carousels as $index => $carousel)
                <div x-show="activeSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform scale-105"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="absolute inset-0 w-full h-full">

                    <!-- Gambar Banner -->
                    @if($carousel->image)
                        <img src="{{ asset('storage/' . $carousel->image) }}" alt="{{ $carousel->title ?? 'Banner' }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-indigo-900 flex items-center justify-center text-white">No Banner Image</div>
                    @endif

                    <!-- Overlay Gelap & Teks Banner -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex items-end p-6 sm:p-12">
                        <div class="max-w-3xl text-white">
                            @if($carousel->title)
                                <h2 class="text-xl sm:text-3xl font-extrabold tracking-tight mb-2">{{ $carousel->title }}</h2>
                            @endif
                            @if($carousel->description)
                                <p class="text-xs sm:text-sm text-gray-200 line-clamp-2">{{ $carousel->description }}</p>
                            @endif
                            @if($carousel->link)
                                <a href="{{ $carousel->link }}" target="_blank" class="mt-4 inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition shadow-md">
                                    {{ app()->getLocale() == 'en' ? 'Learn More' : 'Selengkapnya' }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Navigasi Titik (Dots) di Bawah Carousel -->
            <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 z-10">
                @foreach($carousels as $index => $carousel)
                <button @click="activeSlide = {{ $index }}"
                        :class="{ 'bg-white w-6': activeSlide === {{ $index }}, 'bg-white/50 w-2.5': activeSlide !== {{ $index }} }"
                        class="h-2.5 rounded-full transition-all duration-300 focus:outline-none"></button>
                @endforeach
            </div>
        </section>
    </div>
    @endif

    <!-- Alpine.js Root untuk State Modal, Kategori, dan Pencarian di Semua Produk -->
    <div x-data="{ activeCategory: 'all', searchQuery: '', selectedProduct: null }">

        <!-- 2. TRENDING PRODUCTS SECTION (Tidak terpengaruh pencarian) -->
        <section id="trending" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-950 text-orange-600 dark:text-orange-400 flex items-center justify-center">
                        <i class="fa-solid fa-fire text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                            Produk Trending
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium mt-0.5">
                            Produk yang paling sering dilihat bulan ini
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grid Produk Trending -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @forelse($trendingProducts ?? [] as $product)
                    <div @click="selectedProduct = {
                            name: '{{ addslashes($product->name) }}',
                            slug: '{{ $product->slug }}',
                            category: '{{ addslashes($product->category->name ?? 'Umum') }}',
                            price: 'Rp {{ number_format($product->price, 0, ',', '.') }}',
                            description: '{{ addslashes($product->description ?? '-') }}',
                            image: '{{ $product->image ? asset('storage/' . $product->image) : '' }}',
                            link: '{{ $product->linkid ?? '#' }}',
                            hasLink: {{ $product->linkid ? 'true' : 'false' }}
                         }"
                         class="bg-white dark:bg-gray-900  dark:border-gray-800 rounded-xl shadow-xs border border-gray-100 overflow-hidden flex flex-col justify-between group cursor-pointer transition hover:shadow-md">

                        <div>
                            <div class="h-32 sm:h-48 w-full bg-gray-100 relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                                @endif

                                <span class="absolute top-2 left-2 bg-amber-400 text-gray-900 text-[10px] font-extrabold px-2 py-0.5 rounded shadow-xs">
                                    Laris
                                </span>
                            </div>
                            <div class="p-2 sm:p-4">
                                <span class="text-[9px] uppercase tracking-wider font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                                <h3 class="font-bold text-gray-800 dark:text-gray-100 text-[11px] sm:text-sm line-clamp-1 mt-1 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                                <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="p-2 sm:p-4 pt-0 border-t border-gray-50 mt-2 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                            <div class="text-indigo-600 font-extrabold text-[11px] sm:text-sm">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            @if($product->linkid)
                                <span class="w-full sm:w-auto text-center px-2.5 py-1.5 bg-gray-900 group-hover:bg-indigo-600 text-white text-[10px] sm:text-xs font-medium rounded-lg transition">
                                    Lihat
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-gray-500 bg-white dark:bg-gray-900 rounded-xl border border-dashed border-gray-300">
                        <p class="text-sm font-medium">Belum ada produk trending bulan ini.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 3. SECTION SEMUA PRODUK & SEARCH BOX -->
        <section id="semua-produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 border-t border-gray-200 mt-10">

            <!-- Baris Judul & Textbox Search Pengganti "Pilih Kategori" -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Katalog Produk
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        Menampilkan seluruh katalog produk berbagai kategori.
                    </p>
                </div>

                <!-- Textbox Search -->
                <div class="w-full sm:w-80 relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text"
                        x-model="searchQuery"
                        placeholder="Cari produk..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl text-xs sm:text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition shadow-xs">
                </div>
            </div>

            <!-- Baris Tombol Filter Kategori (Horizontal Scroll di Mobile) -->
            <div class="flex items-center gap-2.5 overflow-x-auto pb-4 mb-6 scrollbar-none">
                <button type="button"
                        @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white dark:bg-gray-900 dark:text-gray-300 dark:border-gray-800 text-gray-700 border-gray-200 hover:border-gray-300'"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border text-xs sm:text-sm font-semibold whitespace-nowrap transition">
                    <i class="fa-solid fa-grip"></i>
                    <span>Semua Kategori</span>
                </button>

                @foreach($categories as $category)
                    <button type="button"
                            @click="activeCategory = '{{ $category->id }}'"
                            :class="activeCategory === '{{ $category->id }}' ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white  text-gray-700 border-gray-200 hover:border-gray-300'"
                            class="inline-flex items-center px-4 py-2 rounded-xl border text-xs sm:text-sm font-semibold whitespace-nowrap transition">
                        <span>{{ $category->name }}</span>
                    </button>
                @endforeach
            </div>

            <!-- Grid Semua Produk dengan Filter Kategori & Search Query -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @forelse($allProducts as $product)
                    <div @click="selectedProduct = {
                            name: '{{ addslashes($product->name) }}',
                            slug: '{{ $product->slug }}',
                            category: '{{ addslashes($product->category->name ?? 'Umum') }}',
                            price: 'Rp {{ number_format($product->price, 0, ',', '.') }}',
                            description: '{{ addslashes($product->description ?? '-') }}',
                            image: '{{ $product->image ? asset('storage/' . $product->image) : '' }}',
                            link: '{{ $product->linkid ?? '#' }}',
                            hasLink: {{ $product->linkid ? 'true' : 'false' }}
                         }"
                         x-show="(activeCategory === 'all' || activeCategory === '{{ $product->category_id }}') && (searchQuery === '' || '{{ strtolower($product->name) }}'.includes(searchQuery.toLowerCase()))"
                         class="bg-white dark:bg-gray-900 rounded-xl shadow-xs border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col justify-between group cursor-pointer transition hover:shadow-md"
                         style="display: none;"
                         x-transition>

                        <div>
                            <div class="h-32 sm:h-48 w-full bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>
                            <div class="p-2 sm:p-4">
                                <span class="text-[9px] uppercase tracking-wider font-bold text-indigo-600 bg-indigo-50 dark:bg-indigo-950 dark:text-indigo-400 px-2 py-0.5 rounded">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                                <h3 class="font-bold text-gray-800 dark:text-gray-100 text-[11px] sm:text-sm line-clamp-1 mt-1 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                                <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="p-2 sm:p-4 pt-0 border-t border-gray-50 dark:border-gray-800 mt-2 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                            <div class="text-indigo-600 dark:text-indigo-400 font-extrabold text-[11px] sm:text-sm">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            @if($product->linkid)
                                <span class="w-full sm:w-auto text-center px-2.5 py-1.5 bg-gray-900 dark:bg-indigo-600 group-hover:bg-indigo-600 text-white text-[10px] sm:text-xs font-medium rounded-lg transition">
                                    Lihat
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                        <p class="text-sm font-medium">Tidak ada produk ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $allProducts->links() }}
            </div>

            <!-- ================================================= -->
            <!-- KOTAK DIALOG / MODAL POPUP DETAIL PRODUK -->
            <!-- ================================================= -->
            <div x-show="selectedProduct"
                 x-transition.opacity
                 class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4 overflow-y-auto"
                 style="display: none;">

                <div @click.away="selectedProduct = null"
                     class="bg-white dark:bg-gray-900 w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl relative my-8 flex flex-col max-h-[90vh]">

                    <!-- Tombol Close (X) -->
                    <button @click="selectedProduct = null"
                            class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-white/80 hover:bg-white text-gray-700 flex items-center justify-center shadow-md transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>

                    <!-- Konten Modal -->
                    <div class="overflow-y-auto p-5 sm:p-6 space-y-5">
                        <div class="relative rounded-2xl overflow-hidden bg-gray-900 aspect-[4/3] w-full">
                            <template x-if="selectedProduct?.image">
                                <img :src="selectedProduct.image" :alt="selectedProduct.name" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedProduct?.image">
                                <div class="w-full h-full flex items-center justify-center text-white font-bold">Tidak Ada Gambar</div>
                            </template>
                            <span class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] sm:text-xs font-bold px-3 py-1 rounded-lg uppercase tracking-wider shadow" x-text="selectedProduct?.category"></span>
                        </div>

                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white leading-snug" x-text="selectedProduct?.name"></h2>
                            <p class="text-lg sm:text-xl font-extrabold text-indigo-600 mt-2" x-text="selectedProduct?.price"></p>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Deskripsi Produk</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line" x-text="selectedProduct?.description"></p>
                        </div>
                    </div>

                    <!-- Tombol Aksi di Bawah Modal -->
                    <div class="p-4 sm:p-6 bg-white border-t border-gray-100 space-y-3">
                        <template x-if="selectedProduct?.hasLink">
                            <a :href="selectedProduct?.link"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-full flex items-center justify-center gap-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm sm:text-base py-3.5 px-6 rounded-2xl shadow-lg transition">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span>Beli Sekarang</span>
                            </a>
                        </template>

                        <button @click="selectedProduct = null"
                                class="w-full flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-semibold text-sm py-3 px-6 rounded-2xl transition">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            <span>Kembali / Home</span>
                        </button>
                    </div>

                </div>
            </div>

        </section>
    </div>

    <!-- 4. TENTANG KAMI & KONTAK SECTION -->
    <section id="tentang-kami" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-10 md:p-12 transition-colors duration-300">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

            <!-- Kolom Kiri -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <!-- Perubahan ada di sini (ditambah dark:text-blue-400) -->
                    <span class="text-xs sm:text-sm font-bold tracking-wider text-blue-600 dark:text-blue-400 uppercase">
                        TENTANG KAMI
                    </span>
                    <h2 class="mt-2 text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        Pusat Solusi Produk Digital, Material & Pembangunan Terpercaya
                    </h2>
                    <p class="mt-4 text-sm sm:text-base text-gray-600 dark:text-gray-300 leading-relaxed">
                        Kami menghadirkan aneka kebutuhan produk digital siap pakai, material konstruksi berkualitas tinggi, layanan desain arsitektural studio, hingga pemborong bangun kost terpadu dengan standar pengerjaan profesional dan transparan.
                    </p>
                </div>
            </div>

            <!-- Kolom Kanan (Card WhatsApp Hijau sudah aman dan kontras di mode gelap) -->
            <div class="lg:col-span-5">
                <div class="rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-700 p-7 sm:p-8 text-white shadow-lg">
                    <h3 class="text-2xl sm:text-3xl font-bold leading-snug">
                        Punya Pertanyaan Khusus?
                    </h3>
                    <p class="mt-3 text-sm text-emerald-50/90 leading-relaxed">
                        Konsultasikan kebutuhan produk, penawaran harga grosir, atau survei bangun kos langsung dengan tim ahli kami.
                    </p>
                    <hr class="my-6 border-white/20">
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer"
                       class="w-full flex items-center justify-center gap-2.5 bg-white hover:bg-gray-50 text-emerald-700 font-bold text-sm sm:text-base py-3.5 px-6 rounded-2xl shadow-md transition duration-200">
                        <span>Hubungi via WhatsApp</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

</div>
@endsection
