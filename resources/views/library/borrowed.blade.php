@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">📚 Form Peminjaman Buku</h2>

        @php
            $success = session()->pull('success');
            $error = session()->pull('error');
        @endphp

        @if($success)
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
                {{ $success }}
            </div>
        @endif

        @if($error)
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4">
                {{ $error }}
            </div>
        @endif

        <form action="{{ route('borrowed.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Buku</label>
                <select name="book_id" id="book_id" required class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 px-3 py-2">
                    @foreach($books as $book)
                        <option value="{{ $book->id }}"
                            {{ (isset($selectedBookId) && $selectedBookId == $book->id) ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="borrowed_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                <input type="date" id="borrowed_at" name="borrowed_at" class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label for="due_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                <input type="date" id="due_at" name="due_at" class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-md shadow-md transition duration-300">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">📖 Riwayat Permintaan</h2>

        @forelse ($borrowRequests as $request)
            <div class="border border-gray-200 p-4 rounded-lg mb-4 bg-gray-50">
                <p><strong>Buku:</strong> {{ $request->book->title }}</p>
                <p><strong>Status:</strong> 
                    <span class="{{ $request->status === 'Disetujui' ? 'text-green-600' : ($request->status === 'Ditolak' ? 'text-red-600' : 'text-yellow-600') }} font-semibold">
                        {{ $request->status }}
                    </span>
                </p>
                @if ($request->status === 'Ditolak')
                    <p><strong>Alasan Penolakan:</strong> {{ $request->rejection_reason }}</p>

                @elseif ($request->status === 'Disetujui')
                    <p><strong>Disetujui pada:</strong> {{ \Carbon\Carbon::parse($request->approved_date)->format('d M Y') }}</p>

                    <form action="{{ route('borrowed.return', $request->id) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-semibold shadow-sm transition">
                            Kembalikan Buku
                        </button>
                    </form>
                @endif

                @if ($request->returned_at)
                    <p><strong>Dikembalikan pada:</strong> {{ \Carbon\Carbon::parse($request->returned_at)->format('d M Y') }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Belum ada permintaan peminjaman.</p>
        @endforelse

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const borrowedAtInput = document.getElementById('borrowed_at');
        const dueAtInput = document.getElementById('due_at');

        borrowedAtInput.addEventListener('change', function () {
            const borrowedDate = new Date(borrowedAtInput.value);
            if (!isNaN(borrowedDate)) {
                const minDueDate = new Date(borrowedDate);
                minDueDate.setDate(minDueDate.getDate() + 1);

                const maxDueDate = new Date(borrowedDate);
                maxDueDate.setDate(maxDueDate.getDate() + 5);

                dueAtInput.min = minDueDate.toISOString().split('T')[0];
                dueAtInput.max = maxDueDate.toISOString().split('T')[0];
                dueAtInput.value = ''; // reset jika sebelumnya salah
            }
        });
    });
</script>
@endsection
