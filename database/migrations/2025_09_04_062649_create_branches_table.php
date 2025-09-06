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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // FK relation
            $table->string('name');
            $table->string('branch_id')->unique();
            $table->string('email');
            $table->string('mobile_number');
            $table->string('alternate_contact_number')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('landmark')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
