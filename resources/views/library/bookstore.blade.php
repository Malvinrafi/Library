@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Welcome to the Bookstore</h1>
    <p class="text-gray-600 mb-2">Here you can explore our collection of books, from fiction to non-fiction, bestsellers, and more.</p>
</div>
<div class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach ($books as $book)
        <a href="{{ route('book.detail', ['id' => $book->id]) }}" class="bg-white rounded-md shadow-sm hover:shadow-md transition block overflow-hidden">
            <div class="w-full h-48 bg-gray-100">
                <img src="{{ asset('storage/' . $book->book_cover) }}" alt="{{ $book->title }}" class="w-full h-full object-contain p-2">
            </div>
            <div class="bg-gray-100 px-2 py-1">
                <h3 class="text-sm font-medium text-center text-black truncate">{{ $book->title }}</h3>
            </div>
        </a>
    @endforeach
</div>

@endsection