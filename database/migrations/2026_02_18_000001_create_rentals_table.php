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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technology_id')->constrained('technologies')->onDelete('cascade');
            $table->string('renter_name');
            $table->string('renter_email');
            $table->string('renter_phone');
            $table->string('renter_address');
            $table->integer('rental_hours')->default(0);
            $table->integer('rental_days')->default(0);
            $table->decimal('payment_amount', 10, 2)->default(0);
            $table->boolean('fully_paid')->default(false);
            $table->enum('status', ['pending', 'approved', 'fixing', 'returned'])->default('pending');
            $table->date('rental_date');
            $table->date('return_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
