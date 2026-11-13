@extends('layouts.app')

@section('title', 'Tambah Slide Carousel')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-xs border border-gray-200">
    <h1 class="text-xl font-bold text-gray-800 mb-6">Tambah Slide Carousel Baru</h1>

    <form action="{{ route('admin.carousels.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Gambar Banner <span class="text-red-500">*</span></label>
            <input type="file" name="image" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Judul Slide (Opsional)</label>
            <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Subtitle / Sub-judul (Opsional)</label>
            <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('subtitle') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Link Tujuan (URL)</label>
            <input type="url" name="link_url" value="{{ old('link_url') }}" placeholder="https://..." class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('link_url') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex items-center pt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">Aktifkan Slide</label>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.carousels.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium">Simpan Slide</button>
        </div>
    </form>
</div>
@endsection
