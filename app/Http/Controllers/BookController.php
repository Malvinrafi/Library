<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class BookController extends Controller
{
    // Menampilkan semua buku (untuk homepage atau admin)
    public function index()
    {
        $books = Book::all();
        return view('library.home', compact('books'));
    }

    // Menampilkan detail buku untuk user atau admin
    public function show($id)
    {
        $book = Book::findOrFail($id);

        // Debugging: Periksa apakah user terdeteksi sebagai admin atau user biasa
        if (auth()->check()) {
            Log::info("User ID: " . auth()->user()->id . " | is_admin: " . auth()->user()->is_admin);
        }

        // Jika user adalah admin, tampilkan halaman admin
        if (auth()->check() && auth()->user()->is_admin) {
            return view('admin.books.show', compact('book'));
        }

        // Jika user bukan admin, tampilkan halaman user biasa
        return view('library.book.show-user', compact('book'));
    }

    // Menampilkan form edit buku untuk admin
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    

    // Menyimpan perubahan data buku
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|date',
            'category' => 'nullable|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0', 
        ]);        

    $book = Book::findOrFail($id);

    // Jika user upload cover baru
    if ($request->hasFile('cover')) {
        // Hapus cover lama kalau ada
        if ($book->book_cover && Storage::disk('public')->exists($book->book_cover)) {
            Storage::disk('public')->delete($book->book_cover);
        }

        // Simpan cover baru dengan nama asli + uniqid
        $file = $request->file('cover');
        $originalName = $file->getClientOriginalName();
        $filename = uniqid() . '-' . $originalName;
        $file->storeAs('public/covers', $filename);

        // Update path cover
        $book->book_cover = 'covers/' . $filename;
    }

    // Update data buku lainnya
    $book->update($request->only(['title', 'author', 'publisher', 'tahun_terbit', 'category', 'stock']));

    // Simpan perubahan cover (kalau ada)
    $book->save();

    return redirect()->route('dashboard.books.show', $book->id)->with('success', 'Buku berhasil diperbarui.');
    }



    // Menghapus buku
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->book_cover && Storage::disk('public')->exists($book->book_cover)) {
            Storage::disk('public')->delete($book->book_cover);
            Log::info("Cover deleted: " . $book->book_cover);
        } else {
            Log::warning("Cover NOT deleted. File not found or no cover.");
        }        

        $book->delete();

        return redirect()->route('dashboard.books.books1')->with('success', 'Buku berhasil dihapus');
    }

}