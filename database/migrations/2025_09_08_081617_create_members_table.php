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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // Relations (all nullable)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('building_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('floor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('flat_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('seat_id')->nullable()->constrained()->nullOnDelete();

            // Login helper
            $table->string('rental_id')->nullable()->unique(); // optional identifier used for login

            // Dates
            $table->date('admission_date')->nullable();
            $table->date('effective_date')->nullable();

            // Profile / personal
            $table->string('photo')->nullable(); // storage path to passport-size photo
            $table->string('name')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('national_id', 100)->nullable();

            // Family
            $table->string('father_name')->nullable();
            $table->string('father_contact', 30)->nullable();
            $table->string('mother_name')->nullable();

            // Health / address
            $table->string('blood_group', 10)->nullable();
            $table->text('permanent_address')->nullable();

            // Local guardian
            $table->string('local_guardian_name')->nullable();
            $table->string('local_guardian_relation')->nullable();
            $table->string('local_guardian_contact', 30)->nullable();

            // Status
            $table->enum('status', ['active', 'suspended'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
