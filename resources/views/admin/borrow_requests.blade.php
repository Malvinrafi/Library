@extends('layouts.depan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-10">
    <div class="w-full max-w-3xl px-4">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Permintaan Peminjaman Buku</h2>

        @foreach ($requests as $request)
            <div class="bg-white shadow-md rounded-lg p-6 mb-5">
                <p class="text-gray-700 mb-2"><span class="font-semibold">User:</span> {{ $request->user->name }}</p>
                <p class="text-gray-700 mb-2"><span class="font-semibold">Buku:</span> {{ $request->book->title }}</p>
                <p class="mb-3">
                    <span class="font-semibold text-gray-700">Status:</span>
                    <span class="inline-block px-2 py-1 text-sm font-medium rounded-full
                        @if($request->status === 'Menunggu') bg-yellow-100 text-yellow-800 
                        @elseif($request->status === 'Ditolak') bg-red-100 text-red-800 
                        @elseif($request->status === 'Disetujui') bg-green-100 text-green-800 
                        @endif">
                        {{ $request->status }}
                    </span>
                </p>

                @if ($request->status === 'Menunggu')
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4">
                        <form action="{{ route('dashboard.borrow.approve', $request->id) }}" method="POST">
                            @csrf
                            <button class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2 px-4 rounded transition duration-200">
                                Setujui
                            </button>
                        </form>

                        <form action="{{ route('dashboard.borrow.reject', $request->id) }}" method="POST" class="flex items-center gap-2 w-full sm:w-auto">
                            @csrf
                            <input type="text" name="rejection_reason" placeholder="Alasan penolakan" required
                                   class="w-full sm:w-64 px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-300">
                            <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2 px-4 rounded transition duration-200">
                                Tolak
                            </button>
                        </form>
                    </div>
                @elseif($request->status === 'Ditolak')
                    <p class="mt-3 text-red-600"><strong>Alasan Penolakan:</strong> {{ $request->rejection_reason }}</p>
                @elseif($request->status === 'Disetujui')
                    <p class="mt-3 text-green-600"><strong>Tanggal Disetujui:</strong> {{ $request->approved_date }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection

