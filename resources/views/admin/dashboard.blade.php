@extends('layouts.depan') {{-- Sesuaikan layout --}}
@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Welcome to the library admin panel.</p>
    </div>

    {{-- Cards Section --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Total Books --}}
        <a href="{{ route('dashboard.books.books1') }}">
            <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-gray-700 font-semibold">Books</h2>
                    <div class="bg-indigo-100 p-2 rounded-md">
                        <i class="fas fa-book text-indigo-600"></i>
                    </div>
                </div>
                <div class="text-4xl font-bold text-indigo-700">{{ $totalBooks }}</div>
                <p class="text-sm text-gray-500 mt-2">Click for see the books</p>
            </div>
        </a>

        {{-- Borrowed Books --}}
        <a href="{{ route('dashboard.admin.borrowed_requests') }}">
            <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-gray-700 font-semibold">Borrowed Books</h2>
                    <div class="bg-yellow-100 p-2 rounded-md">
                        <i class="fas fa-book-reader text-yellow-600"></i>
                    </div>
                </div>
                <div class="text-4xl font-bold text-yellow-600">{{ $borrowedBooks }}</div>
                <p class="text-sm text-gray-500 mt-2">{{ $borrowedPercentage }}% of the book</p>
            </div>
        </a>

        {{-- Available Books --}}
        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-gray-700 font-semibold">Stok Buku Tersedia</h2>
                <div class="bg-green-100 p-2 rounded-md">
                    <i class="fas fa-box-open text-green-600"></i>
                </div>
            </div>
            <div class="text-4xl font-bold text-green-600">{{ $availableStock }}</div>
            <p class="text-sm text-gray-500 mt-2">{{ $availablePercentage }}% dari total stok</p>
        </div>        
    </div>


    {{-- Task Performance Style Section --}}
    <div class="bg-white rounded-2xl shadow p-6 mt-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Statistik Peminjaman Buku</h2>
        <div class="space-y-4">
            {{-- Peminjaman --}}
            <div>
                <p class="text-gray-600 mb-1">Dipinjam ({{ $borrowedBooks }} Buku)</p>
                <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                    <div class="bg-yellow-500 h-full rounded-full transition-all duration-300" style="width: {{ $borrowedPercentage }}%"></div>
                </div>
            </div>

            {{-- Stok --}}
            <div>
                <p class="text-gray-600 mb-1">Tersedia ({{ $availableBooks }} Buku)</p>
                <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                    <div class="bg-green-500 h-full rounded-full transition-all duration-300" style="width: {{ $availablePercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
