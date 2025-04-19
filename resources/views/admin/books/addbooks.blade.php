@extends('layouts.depan') {{-- Pastikan layout ini sesuai dengan struktur proyek Anda --}}

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow-md">
    <h1 class="text-2xl font-semibold mb-4">Tambah Buku</h1>

    <form action="{{ route('dashboard.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block font-medium text-gray-700">Judul Buku</label>
            <input type="text" name="title" id="title" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('title') }}">
            @error('title')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="author" class="block font-medium text-gray-700">Penulis</label>
            <input type="text" name="author" id="author" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('author') }}">
            @error('author')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="publisher" class="block font-medium text-gray-700">Penerbit</label>
            <input type="text" name="publisher" id="publisher"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('publisher') }}">
            @error('publisher')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="tahun_terbit" class="block font-medium text-gray-700">Tahun Terbit</label>
            <input type="date" name="tahun_terbit" id="tahun_terbit"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('tahun_terbit') }}">
            @error('tahun_terbit')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="category" class="block font-medium text-gray-700">Kategori</label>
            <select name="category" id="category"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Kategori --</option>
                <option value="Fiction" {{ old('category') == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                <option value="Non-fiction" {{ old('category') == 'Non-fiction' ? 'selected' : '' }}>Non-fiction</option>
                <option value="History" {{ old('category') == 'History' ? 'selected' : '' }}>History</option>
                <option value="Fantasy" {{ old('category') == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                <option value="Romance" {{ old('category') == 'Romance' ? 'selected' : '' }}>Romance</option>
                <option value="Mystery" {{ old('category') == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                <option value="Horror" {{ old('category') == 'Horror' ? 'selected' : '' }}>Horror</option>
                <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
            </select>
            @error('category')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="stock" class="block font-medium text-gray-700">Stok Buku</label>
            <input type="number" name="stock" id="stock" min="0" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('stock') }}">
            @error('stock')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>        

        <div>
            <label for="cover" class="block font-medium text-gray-700">Cover Buku (opsional)</label>
            <input type="file" name="book_cover" id="cover"
                class="w-full px-3 py-2 border border-gray-300 rounded-md file:bg-blue-500 file:text-white file:border-none file:px-4 file:py-2">
            @error('book_cover')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Simpan
            </button>
            <a href="{{ route('dashboard.books.books1') }}"
                class="ml-3 text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
</div>
@endsection
