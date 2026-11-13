@extends('layouts.app') {{-- Sesuaikan dengan nama layout admin Anda, misal: layouts.app atau admin.layouts.app --}}

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Edit Slide Carousel</h1>

        <form action="{{ route('admin.carousels.update', $carousel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Gambar Banner --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Banner <span class="text-red-500">*</span></label>
                @if($carousel->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $carousel->image) }}" alt="Banner Preview" class="w-40 h-24 object-cover rounded-lg border">
                    </div>
                @endif
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
            </div>

            {{-- Judul Slide --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Slide (Opsional)</label>
                <input type="text" name="title" value="{{ old('title', $carousel->title) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Subtitle --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle / Sub-judul (Opsional)</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $carousel->subtitle) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Link URL --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Link Tujuan (URL)</label>
                <input type="url" name="link_url" value="{{ old('link_url', $carousel->link_url) }}" placeholder="https://..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Urutan Tampil --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                <input type="number" name="order" value="{{ old('order', $carousel->order) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Status Aktif --}}
            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $carousel->is_active) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktifkan Slide</label>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.carousels.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
