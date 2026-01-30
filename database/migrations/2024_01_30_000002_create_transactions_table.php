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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('customer_name')->nullable();
            $table->string('service_name');
            $table->decimal('weight', 8, 2);
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('total', 12, 2);
            $table->enum('payment_method', ['cash', 'qr'])->default('cash');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index for faster queries on date-based reports
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
