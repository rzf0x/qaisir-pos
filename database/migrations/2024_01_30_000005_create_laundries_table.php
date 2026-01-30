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
        Schema::create('laundries', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama laundry
            $table->string('slug')->unique(); // URL slug: qaisir.com/{slug}
            $table->string('owner_name'); // Nama pemilik
            $table->string('phone')->nullable(); // Nomor telepon
            $table->string('address')->nullable(); // Alamat
            $table->string('logo')->nullable(); // Logo path
            $table->text('description')->nullable(); // Deskripsi
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add laundry_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('laundry_id')->nullable()->after('id')->constrained('laundries')->onDelete('cascade');
            $table->enum('role', ['admin', 'owner'])->default('owner')->after('email');
        });

        // Update laundry_services to use laundry_id instead of user_id
        Schema::table('laundry_services', function (Blueprint $table) {
            $table->foreignId('laundry_id')->nullable()->after('id')->constrained('laundries')->onDelete('cascade');
        });

        // Update transactions to use laundry_id
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('laundry_id')->nullable()->after('id')->constrained('laundries')->onDelete('cascade');
        });

        // Update daily_summaries to use laundry_id
        Schema::table('daily_summaries', function (Blueprint $table) {
            $table->foreignId('laundry_id')->nullable()->after('id')->constrained('laundries')->onDelete('cascade');
        });

        // Update subscriptions to use laundry_id
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('laundry_id')->nullable()->after('id')->constrained('laundries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['laundry_id']);
            $table->dropColumn('laundry_id');
        });

        Schema::table('daily_summaries', function (Blueprint $table) {
            $table->dropForeign(['laundry_id']);
            $table->dropColumn('laundry_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['laundry_id']);
            $table->dropColumn('laundry_id');
        });

        Schema::table('laundry_services', function (Blueprint $table) {
            $table->dropForeign(['laundry_id']);
            $table->dropColumn('laundry_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['laundry_id']);
            $table->dropColumn(['laundry_id', 'role']);
        });

        Schema::dropIfExists('laundries');
    }
};
