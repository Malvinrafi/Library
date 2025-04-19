@extends('layouts.depan')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Laporan Buku yang Dipinjam</h2>

    <!-- Tombol Print PDF -->
    <button onclick="printReport()" class="px-4 py-2 bg-blue-600 text-white rounded-md mb-4">
        Print PDF
    </button>

    <table id="reportTable" class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">No</th>
                <th class="border p-2">Judul Buku</th>
                <th class="border p-2">Peminjam</th>
                <th class="border p-2">Tanggal Peminjaman</th>
                <th class="border p-2">Tanggal Pengembalian</th>
                <th class="border p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowedBooks as $index => $borrow)
            <tr>
                <td class="border p-2">{{ $index + 1 }}</td>
                <td class="border p-2">{{ $borrow->book->title }}</td>
                <td class="border p-2">{{ $borrow->user->name }}</td>
                <td class="border p-2">{{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('d-m-Y') }}</td>
                <td class="border p-2">
                    @if ($borrow->returned_at)
                        {{ \Carbon\Carbon::parse($borrow->returned_at)->format('d-m-Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="border p-2">
                    @if ($borrow->status === 'Dikembalikan')
                        ✅ <span class="text-green-700 font-semibold">Sudah Dikembalikan</span>
                    @else
                        ❌ <span class="text-red-600 font-semibold">Sedang Dipinjam</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- JavaScript untuk Print PDF -->
<script>
    function printReport() {
        var originalContents = document.body.innerHTML;
        var printContents = document.getElementById("reportTable").outerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endsection