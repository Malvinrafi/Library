<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('book_id'); // letakkan di posisi yang kamu mau
        });
    }
    
    public function down()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
    
};

