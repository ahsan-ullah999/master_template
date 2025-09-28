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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('members_user_id_foreign');
            $table->unsignedBigInteger('company_id')->nullable()->index('members_company_id_foreign');
            $table->unsignedBigInteger('branch_id')->nullable()->index('members_branch_id_foreign');
            $table->unsignedBigInteger('building_id')->nullable()->index('members_building_id_foreign');
            $table->unsignedBigInteger('floor_id')->nullable()->index('members_floor_id_foreign');
            $table->unsignedBigInteger('flat_id')->nullable()->index('members_flat_id_foreign');
            $table->unsignedBigInteger('room_id')->nullable()->index('members_room_id_foreign');
            $table->unsignedBigInteger('seat_id')->nullable()->index('members_seat_id_foreign');
            $table->string('rental_id')->nullable()->unique();
            $table->date('admission_date')->nullable();
            $table->date('effective_date')->nullable();
            $table->string('photo')->nullable();
            $table->string('name')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('national_id', 100)->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_contact', 30)->nullable();
            $table->string('mother_name')->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('local_guardian_name')->nullable();
            $table->string('local_guardian_relation')->nullable();
            $table->string('local_guardian_contact', 30)->nullable();
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
