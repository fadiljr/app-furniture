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
        Schema::create('rabs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();

    $table->string('nomor_rab')->unique();
    $table->date('tanggal');
    $table->date('expired_date')->nullable();

    $table->decimal('subtotal', 15, 2)->default(0);
    $table->decimal('diskon', 15, 2)->default(0);
    $table->decimal('pajak', 15, 2)->default(0);
    $table->decimal('grand_total', 15, 2)->default(0);

    $table->enum('status', ['draft', 'dikirim', 'disetujui', 'ditolak'])
          ->default('draft');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rabs');
    }
};
