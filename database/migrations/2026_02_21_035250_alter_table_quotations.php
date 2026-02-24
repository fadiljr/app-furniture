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
        Schema::table('quotations', function (Blueprint $table) {
            //
            // $table->string('quotation_number')->unique();
            // $table->date('quotation_date');
            // $table->date('valid_until')->nullable();
            // $table->decimal('total_amount', 15, 2)->default(0);
            // $table->decimal('discount', 15, 2)->default(0);
            // $table->decimal('tax', 15, 2)->default(0);
            // $table->decimal('grand_total', 15, 2)->default(0);
            // $table->enum('status', ['draft', 'sent', 'approved', 'rejected'])->default('draft');
            // $table->text('notes')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            //
            $table->string('client_name');
            $table->string('client_address');
            $table->dropColumn('client_id');
        });
    }
};
