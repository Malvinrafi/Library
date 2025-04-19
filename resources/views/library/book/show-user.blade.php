@extends('layouts.app')

@section('content')
<main class="container mx-auto py-10 px-4">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md text-center">
        <!-- Cover Buku Potrait -->
        <div class="w-48 mx-auto aspect-[9/16] rounded-md overflow-hidden shadow-md mb-4">
            <img src="{{ asset('storage/' . $book->book_cover) }}" 
                 alt="{{ $book->title }}" 
                 class="w-full h-full object-cover">
        </div>

        <!-- Informasi Buku -->
        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $book->title }}</h1>
        <p class="text-gray-600 mb-1"><span class="font-semibold">Penulis:</span> {{ $book->author }}</p>
        <p class="text-gray-600 mb-2"><span class="font-semibold">Stok Tersedia:</span> {{ $book->stock }}</p>
        <p class="text-gray-700 mb-4">{{ $book->description }}</p>

        <!-- Tombol Pinjam -->
        @auth
            <form action="{{ route('borrowed.create') }}" method="GET">
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300 text-center"
                    id="borrowButton"
                    data-stock="{{ $book->stock }}">
                    Pinjam Sekarang
                </button>
            </form>
        

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const borrowForm = document.getElementById('borrowForm');
                    const borrowButton = document.getElementById('borrowButton');
                    
                    borrowForm.addEventListener('submit', function (e) {
                        const stock = parseInt(borrowButton.dataset.stock);

                        if (stock <= 0) {
                            e.preventDefault(); // Mencegah form submit
                            alert('Stok buku habis, tidak bisa dipinjam.');
                        }
                    });
                });
            </script>
        @else
            <p class="text-sm text-gray-500">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> untuk meminjam buku ini.
            </p>
        @endauth
    </div>
</main>
@endsection
