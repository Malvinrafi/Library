<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->string('author', 25);
            $table->string('publisher', 25);
            $table->date('tahun_terbit')->nullable();
            $table->enum('category', [
                'Fiction',
                'Non-fiction',
                'History',
                'Fantasy',
                'Romance',
                'Mystery',
                'Horror',
                'Education'
            ]);
            $table->string('book_cover')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
