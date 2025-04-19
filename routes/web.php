<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookstoreController;
use App\Http\Controllers\BorrowedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminBorrowController;
use App\Models\BorrowRequest;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/bookstore', [BookstoreController::class, 'index'])->name('bookstore');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
    Route::get('/borrowed', [BorrowedController::class, 'index'])->name('borrowed');
    Route::post('/borrowed', [BorrowedController::class, 'store'])->name('borrowed.store');
    Route::get('/borrowed/create', [BorrowedController::class, 'create'])->name('borrowed.create'); 
    Route::post('/borrowed/{id}/return', [BorrowedController::class, 'return'])->name('borrowed.return');
    Route::get('/return-book/{borrowId}', [BorrowedController::class, 'returnBook'])->name('return.book');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.detail');

// Admin dashboard routes
Route::prefix('dashboard')
    ->middleware(['auth', 'admin'])
    ->name('dashboard.')
    ->group(function () {

        // Dashboard utama (menampilkan statistik)
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Books list dari DashboardController (halaman books1.blade.php)
        Route::get('/books-list', [DashboardController::class, 'getBookList'])->name('books.books1');

        // Shortcut ke Tambah Buku
        Route::get('/books/addbooks', [DashboardController::class, 'addbooks'])->name('books.addbooks');

        // CRUD Buku
        Route::post('/books/store', [DashboardController::class, 'storeBook'])->name('books.store');
        Route::post('/books-list', [DashboardController::class, 'handleSubmit'])->name('books.handleSubmit');

        // Detail, Edit, Update, Delete dari BookController
        Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
        Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

        // Halaman Peminjaman Admin
        Route::get('/admin/borrowed', [AdminBorrowController::class, 'index'])->name('admin.borrowed_requests');

        // Approve / Reject peminjaman
        Route::get('/borrow-requests', [AdminBorrowController::class, 'index'])->name('borrow.index');
        Route::post('/borrow-requests/{id}/approve', [AdminBorrowController::class, 'approve'])->name('borrow.approve');
        Route::post('/borrow-requests/{id}/reject', [AdminBorrowController::class, 'reject'])->name('borrow.reject');
        
        Route::get('/reports', [AdminBorrowController::class, 'report'])->name('dashboard.admin.reports');
        // Route untuk menampilkan laporan peminjaman
        Route::get('/reports', [BorrowedController::class, 'report'])->name('reports');

        // Route untuk export laporan peminjaman ke PDF (opsional)
        Route::get('/reports/export-pdf', [BorrowedController::class, 'exportPdf'])->name('reports.exportPdf');

    });

// Profile routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// User Borrowed routes (auth required)
Route::middleware(['auth'])->group(function () {
    Route::get('/borrowed', [BorrowedController::class, 'index'])->name('borrowed');
    Route::post('/borrowed', [BorrowedController::class, 'store'])->name('borrowed.store');
});

// 🔍 Route Testing untuk cek data status 'Dikembalikan'
use App\Models\BorrowedRequest;

Route::get('/test-dikembalikan', function () {
    $cek = BorrowRequest::where('status', 'Dikembalikan')->get();
    dd($cek);
});

require __DIR__.'/auth.php';
