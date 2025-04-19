<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

class DashboardController extends Controller
{
    // Menampilkan dashboard utama
    public function index()
    {
        // Ambil semua buku
        $books = Book::all();

        // Total semua stok (akumulasi dari setiap buku)
        $totalStock = $books->sum('stock');

        // Total unit buku yang dipinjam (jumlah quantity dari peminjaman yang disetujui)
        $borrowedBooks = BorrowRequest::where('status', 'Disetujui')->sum('quantity');

        // Total buku
        $totalBooks = $books->count(); // Menghitung jumlah total buku

        // Stok tersedia = total stok - yang sedang dipinjam
        $availableStock = $totalStock - $borrowedBooks;

        // Hitung jumlah buku yang masih tersedia (buku yang stoknya lebih besar dari jumlah yang dipinjam)
        $availableBooks = $books->filter(function($book) use ($borrowedBooks) {
            return $book->stock > $borrowedBooks; // Buku yang stoknya lebih banyak daripada yang dipinjam
        })->count();

        // Hitung persentase
        $borrowedPercentage = $totalStock > 0 ? round(($borrowedBooks / $totalStock) * 100) : 0;
        $availablePercentage = 100 - $borrowedPercentage;

        // Kirim ke dashboard view
        return view('admin.dashboard', compact(
            'totalBooks', // Kirimkan total buku ke view
            'totalStock',
            'availableStock',
            'availableBooks', // Pastikan variabel ini ada di sini
            'borrowedBooks',
            'borrowedPercentage',
            'availablePercentage'
        ));
    }

    // Menampilkan daftar buku
    public function getBookList(Request $request)
    {
        $query = Book::query();

        // Filter berdasarkan kategori (jika ada)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $books = $query->orderBy('id', 'desc')->get();
        $categories = Category::all();

        return view('admin.books.books1', compact('books', 'categories'));
    }

    // Menampilkan form tambah buku
    public function addbooks()
    {
        return view('admin.books.addbooks');
    }

    public function createBook()
    {
        return view('dashboard.books.addbooks');
    }

    // Menyimpan buku ke database
    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'author' => 'required|string|max:25',
            'publisher' => 'nullable|string|max:25',
            'tahun_terbit' => 'nullable|date',
            'category' => 'nullable|string|in:Fiction,Non-fiction,History,Fantasy,Romance,Mystery,Horror,Education',
            'stock' => 'required|integer|min:0',
            'book_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('book_cover')) {
            $validated['book_cover'] = $request->file('book_cover')->store('covers', 'public');
        }

        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'publisher' => $validated['publisher'] ?? null,
            'tahun_terbit' => $validated['tahun_terbit'] ?? null,
            'category' => $validated['category'] ?? null,
            'stock' => $validated['stock'],
            'book_cover' => $validated['book_cover'] ?? null,
        ]);

        return redirect()->route('dashboard.books.books1')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Handle form submit (contoh update status buku)
    public function handleSubmit(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Contoh update status
        $book->status = 'tersedia'; // Sesuaikan dengan kolom yang tersedia
        $book->save();

        Log::info('Book updated successfully.', ['id' => $book->id]);

        return redirect()->route('dashboard.books.books1')->with('success', 'Buku berhasil diperbarui!');
    }
    
}
