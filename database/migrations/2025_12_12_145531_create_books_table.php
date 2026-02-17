<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kos_id')
                ->constrained('kos')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            // ✅ STATUS FINAL & KONSISTEN
            $table->enum('status', [
                'pending',     // user booking
                'confirmed',   // admin approve
                'rejected',    // admin reject
                'cancelled',   // user cancel
                'completed'    // admin confirm selesai
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
