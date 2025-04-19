@extends('layouts.depan')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow mt-10">
    <div class="flex justify-between items-start mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Buku</h1>
        <a href="{{ route('dashboard.books.books1') }}" class="text-blue-600 hover:underline">← Kembali ke daftar</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ asset('storage/' . $book->book_cover) }}" alt="{{ $book->title }}" class="w-full h-80 object-contain border rounded">
        </div>
        <div class="space-y-2">
            <div>
                <label class="font-semibold">Judul:</label>
                <p class="text-gray-700">{{ $book->title }}</p>
            </div>
            <div>
                <label class="font-semibold">Penulis:</label>
                <p class="text-gray-700">{{ $book->author }}</p>
            </div>
            <div>
                <label class="font-semibold">Penerbit:</label>
                <p class="text-gray-700">{{ $book->publisher }}</p>
            </div>
            <div>
                <label class="font-semibold">Tahun Terbit:</label>
                <p class="text-gray-700">{{ $book->tahun_terbit }}</p>
            </div>
            <div>
                <label class="font-semibold">Kategori:</label>
                <p class="text-gray-700">{{ $book->category }}</p>
            </div>
        </div>
    </div>

    <div class="mt-8 flex flex-col sm:flex-row gap-4">
        <!-- Tombol Edit -->
        <a href="{{ route('dashboard.books.edit', $book->id) }}" class="flex-1 text-center bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600">
            Edit
        </a>        

        <!-- Tombol Simpan (misalnya untuk update manual, tinggal sesuaikan ke form jika ingin edit langsung) -->
        <a href="{{ route('dashboard.books.books1') }}" class="flex-1 text-center bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Simpan
        </a>
        

        <!-- Tombol Hapus -->
        <form action="{{ route('dashboard.books.destroy', $book->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">
                Hapus
            </button>
        </form>
    </div>
</div>
@endsection
