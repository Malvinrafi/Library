<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookstoreController extends Controller
{
    public function index()
    {
    $books = Book::all(); // ambil semua buku dari database
    return view('library.bookstore', compact('books')); // kirim ke view
    }

}

