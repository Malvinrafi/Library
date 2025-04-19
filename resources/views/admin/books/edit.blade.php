@extends('layouts.depan')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow mt-10">
    <h1 class="text-2xl font-bold mb-4">Edit Buku</h1>

    <form action="{{ route('dashboard.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block font-semibold">Judul</label>
            <input type="text" name="title" id="title" value="{{ $book->title }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="author" class="block font-semibold">Penulis</label>
            <input type="text" name="author" id="author" value="{{ $book->author }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="publisher" class="block font-semibold">Penerbit</label>
            <input type="text" name="publisher" id="publisher" value="{{ $book->publisher }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="stock" class="block font-semibold">Stok Buku</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" class="w-full border p-2 rounded">
            @error('stock')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>        

        <div class="mb-4">
            <label for="tahun_terbit" class="block font-medium text-gray-700">Tahun Terbit</label>
            <input type="date" name="tahun_terbit" id="tahun_terbit"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('tahun_terbit', $book->tahun_terbit) }}">
            @error('tahun_terbit')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>        
        
        <div class="mb-4">
            <label for="category" class="block font-semibold">Kategori</label>
            <select name="category" id="category"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Kategori --</option>
                <option value="Fiction" {{ old('category', $book->category) == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                <option value="Non-fiction" {{ old('category', $book->category) == 'Non-fiction' ? 'selected' : '' }}>Non-fiction</option>
                <option value="History" {{ old('category', $book->category) == 'History' ? 'selected' : '' }}>History</option>
                <option value="Fantasy" {{ old('category', $book->category) == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                <option value="Romance" {{ old('category', $book->category) == 'Romance' ? 'selected' : '' }}>Romance</option>
                <option value="Mystery" {{ old('category', $book->category) == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                <option value="Horror" {{ old('category', $book->category) == 'Horror' ? 'selected' : '' }}>Horror</option>
                <option value="Education" {{ old('category', $book->category) == 'Education' ? 'selected' : '' }}>Education</option>
            </select>
            @error('category')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Upload cover -->
        <div class="mb-4">
            <label for="cover" class="block font-semibold">Cover Buku</label>
            <input type="file" name="cover" id="cover" class="w-full border p-2 rounded">

            @if($book->cover)
                <p class="mt-2 text-sm text-gray-600">Cover saat ini:</p>
                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Buku" class="w-32 mt-2 rounded shadow">
            @endif

            @error('cover')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('dashboard.books.books1') }}" class="text-gray-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
