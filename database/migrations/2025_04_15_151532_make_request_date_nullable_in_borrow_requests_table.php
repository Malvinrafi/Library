<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Log::info('Starting migration to update borrow_requests table');
        
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->date('request_date')->nullable()->change();
        });

        Log::info('Migration to update borrow_requests table completed successfully');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Log::info('Starting migration to revert borrow_requests table changes');

        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->date('request_date')->nullable(false)->change();
        });

        Log::info('Migration to revert borrow_requests table changes completed successfully');
    }
};

