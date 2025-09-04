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
    Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // required
            $table->string('email')->unique(); // required
            $table->string('business_code')->nullable();
            $table->date('start_date'); // required
            $table->string('financial_year_start_month')->nullable();
            $table->string('date_format')->nullable();
            $table->string('currency_precision')->nullable();
            $table->string('quantity_precision')->nullable();
            $table->string('currency')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_number'); // required
            $table->string('alternate_contact_number')->nullable();
            $table->string('country')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('branch')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('landmark')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('off_days')->nullable();
            $table->string('leave_approval_structure')->nullable();
            $table->string('attendance_approval')->nullable();
            $table->string('probation_period')->nullable();
            $table->string('service_age')->nullable();
            $table->text('address');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
