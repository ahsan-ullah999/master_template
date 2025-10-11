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
        Schema::create('notices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('building_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('floor_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('flat_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
        $table->string('title');
        $table->text('details')->nullable();
        $table->string('priority')->default('medium');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
