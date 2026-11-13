@extends('layouts.app')

@section('title', 'Manajemen Carousel Slide')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Slide Carousel</h1>
    <a href="{{ route('admin.carousels.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
        + Tambah Slide Baru
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow-xs rounded-lg overflow-hidden border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Judul / Subtitle</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Link URL</th>
                <th class="px-6 py-3 text-center font-semibold text-gray-600 uppercase tracking-wider">Urutan</th>
                <th class="px-6 py-3 text-center font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($carousels as $carousel)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="{{ asset('storage/' . $carousel->image) }}" alt="Slide" class="h-16 w-32 object-cover rounded-md border border-gray-200">
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $carousel->title ?? '-' }}</div>
                    <div class="text-xs text-gray-500">{{ $carousel->subtitle ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 text-xs text-blue-600 truncate max-w-xs">
                    @if($carousel->link_url)
                        <a href="{{ $carousel->link_url }}" target="_blank" class="hover:underline">{{ $carousel->link_url }}</a>
                    @else
                        -
                    @endif
                </td>
                <td class="px-6 py-4 text-center font-medium text-gray-700">
                    {{ $carousel->order }}
                </td>
                <td class="px-6 py-4 text-center">
                    @if($carousel->is_active)
                        <span class="px-2.5 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Aktif</span>
                    @else
                        <span class="px-2.5 py-1 text-xs font-semibold bg-gray-100 text-gray-600 rounded-full">Non-Aktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.carousels.edit', $carousel->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Edit</a>
                    <form action="{{ route('admin.carousels.destroy', $carousel->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada slide carousel yang ditambahkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
