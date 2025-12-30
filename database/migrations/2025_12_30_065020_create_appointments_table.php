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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->string('name');
            $table->string('phone');
            $table->text('message')->nullable();
            $table->date('preferred_date');
            $table->time('preferred_time')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
