<?php

namespace App\Http\Controllers;


use App\Models\BorrowRequest;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminBorrowController extends Controller
{
    public function index()
    {
        $requests = BorrowRequest::with('user', 'book')->latest()->get();
        return view('admin.borrow_requests', compact('requests'));
    }

    public function approve($id)
    {
        $request = BorrowRequest::findOrFail($id);
        $book = $request->book;

        if ($book->stock > 0 && $request->status === 'Menunggu') {
            $request->status = 'Disetujui';
            $request->approved_date = now();
            $request->save();

            $book->stock -= 1; // Kurangi stok
            $book->save();
        }

        return redirect()->back()->with('success', 'Permintaan disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        if ($borrowRequest->status === 'Menunggu') {
            $borrowRequest->status = 'Ditolak';
            $borrowRequest->rejection_reason = $request->input('rejection_reason');
            $borrowRequest->save();

            // Tambah stok kembali hanya jika sebelumnya disetujui
            $book = $borrowRequest->book;
            if ($book && $book->stock !== null) {
                $book->stock += 1;
                $book->save();
            }
        }

        return redirect()->back()->with('success', 'Permintaan ditolak.');
    }

    public function report()
    {
        $borrowedBooks = BorrowRequest::with('user', 'book')
            ->whereIn('status', ['Disetujui', 'Dikembalikan'])
            ->orderBy('approved_date', 'desc')
            ->get();

        return view('admin.reports', compact('borrowedBooks'));
    }

    public function returnBook($id)
    {
        $request = BorrowRequest::findOrFail($id);

        // Update status dan tanggal pengembalian
        $request->status = 'Dikembalikan';
        $request->returned_at = now();
        $request->save();

        // Simpan ke laporan (jika kamu punya tabel reports)
        Report::create([
            'borrow_request_id' => $request->id,
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'returned_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
