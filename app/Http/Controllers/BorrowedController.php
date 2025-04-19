<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class BorrowedController extends Controller
{
    public function index()
    {
        // Ambil buku yang stoknya lebih dari 0
        $books = Book::where('stock', '>', 0)->get();

        // Ambil semua permintaan peminjaman buku dari user yang sedang login
        $borrowRequests = BorrowRequest::where('user_id', Auth::id())
            ->with('book') // Mengambil informasi buku terkait permintaan
            ->latest()
            ->get();

        // Ambil book_id dari query string jika ada
        $selectedBookId = request('book_id');

        // Kirim data ke view
        return view('library.borrowed', compact('books', 'borrowRequests', 'selectedBookId'));
    }


    public function create(Request $request)
    {
        // Ambil buku yang stoknya lebih dari 0
        $books = Book::where('stock', '>', 0)->get();

        // Ambil book_id dari query string jika ada
        $selectedBookId = $request->query('book_id');

        // Ambil semua permintaan peminjaman buku dari user yang sedang login
        $borrowRequests = BorrowRequest::where('user_id', Auth::id())
            ->with('book') // Mengambil informasi buku terkait permintaan
            ->latest()
            ->get();

        // Kirim data ke view
        return view('library.borrowed', compact('books', 'borrowRequests', 'selectedBookId'));
    }





    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_duration' => 'nullable|integer|min:1|max:30',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        BorrowRequest::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays($request->borrow_duration ?? 7),
            'status' => 'Menunggu',
            'request_date' => now(),
        ]);

        return redirect()->route('borrowed')->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }


    public function return($id)
    {
        $borrowRequest = BorrowRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Disetujui')
            ->first();

        if (!$borrowRequest) {
            return back()->with('error', 'Permintaan tidak valid atau sudah dikembalikan.');
        }

        // Update status dan waktu pengembalian
        $borrowRequest->status = 'Dikembalikan';
        $borrowRequest->returned_at = now(); // <- Ganti dari 'returned_date'
        $borrowRequest->save();

        // Tambah stok buku
        $book = $borrowRequest->book;
        if ($book && $book->stock !== null) {
            $book->stock += 1; 
            $book->save();
        }

        // Simpan ke tabel laporan (pastikan model Report sudah ada)
        \App\Models\Report::create([
            'borrow_request_id' => $borrowRequest->id, // tambahkan ini
            'book_title' => $book->title,
            'borrower_name' => $borrowRequest->user->name,
            'borrowed_at' => $borrowRequest->borrowed_at,
            'book_id' => $borrowRequest->book_id, // Add this
            'user_id' => $borrowRequest->user_id,
            'returned_at' => $borrowRequest->returned_at,
        ]);        

        return back()->with('success', 'Buku berhasil dikembalikan dan dicatat dalam laporan.');
    }


    public function report()
    {
        // Retrieve all borrow requests, including returned ones
        $borrowedBooks = BorrowRequest::with('book', 'user')
            ->orderBy('borrowed_at', 'desc')
            ->get();
    
        return view('admin.reports', compact('borrowedBooks'));
    }
    
    public function exportPdf()
    {
        $borrowedBooks = BorrowRequest::with('book', 'user')
            ->where('status', '!=', 'Dikembalikan')
            ->orderBy('borrowed_at', 'desc')  // Changed from borrow_date
            ->get();
    
        $pdf = Pdf::loadView('admin.reports', compact('borrowedBooks'));
    
        return $pdf->download('Laporan-Peminjaman.pdf');
    }

}
