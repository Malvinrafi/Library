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
    Schema::create('borrow_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('book_id')->constrained()->onDelete('cascade');
    
        $table->date('borrowed_at')->nullable();
        $table->date('due_at')->nullable();
    
        $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak', 'Dikembalikan'])->default('Menunggu');
        $table->dateTime('request_date')->default(now());
    
        $table->dateTime('approved_date')->nullable();
        $table->text('rejection_reason')->nullable();
        $table->timestamp('returned_date')->nullable(); // Jangan lupa ini!
    
        $table->timestamps();
    });
    
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_requests');
    }
};
