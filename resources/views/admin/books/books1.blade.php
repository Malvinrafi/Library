@extends('layouts.depan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Daftar Buku</h1>
        <a href="{{ route('dashboard.books.addbooks') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Tambah Buku
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach ($books as $book)
            <a href="{{ route('dashboard.books.show', $book->id) }}" class="block">
                <div class="bg-white rounded-xl shadow-md p-4 w-full hover:shadow-lg transition">
                    <img src="{{ $book->book_cover ? asset('storage/' . $book->book_cover) : 'https://via.placeholder.com/150x220?text=No+Cover' }}"
                         alt="{{ $book->title }}"
                         class="h-48 w-full object-contain mb-2 rounded">
                    
                    <div class="font-bold text-sm truncate" title="{{ $book->title }}">{{ $book->title }}</div>
                    <div class="text-xs text-gray-600 truncate">{{ $book->author }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
