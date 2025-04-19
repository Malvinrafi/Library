<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category');

        // Ambil semua kategori
        $categories = Category::all();

        // Ambil buku, filter jika ada category
        $books = Book::when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })->orderByDesc('id')->take(6)->get();
        

        return view('library.home', compact('books', 'categories'));
    }
}

