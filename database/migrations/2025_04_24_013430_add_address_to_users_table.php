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
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable(); // Menambahkan kolom address
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address'); // Menghapus kolom address jika migrasi dibatalkan
        });
    }
};
