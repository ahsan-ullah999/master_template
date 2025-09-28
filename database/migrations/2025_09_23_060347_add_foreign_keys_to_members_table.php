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
        Schema::table('members', function (Blueprint $table) {
            $table->foreign(['branch_id'])->references(['id'])->on('branches')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['building_id'])->references(['id'])->on('buildings')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['company_id'])->references(['id'])->on('companies')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['flat_id'])->references(['id'])->on('flats')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['floor_id'])->references(['id'])->on('floors')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['room_id'])->references(['id'])->on('rooms')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['seat_id'])->references(['id'])->on('seats')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('members_branch_id_foreign');
            $table->dropForeign('members_building_id_foreign');
            $table->dropForeign('members_company_id_foreign');
            $table->dropForeign('members_flat_id_foreign');
            $table->dropForeign('members_floor_id_foreign');
            $table->dropForeign('members_room_id_foreign');
            $table->dropForeign('members_seat_id_foreign');
            $table->dropForeign('members_user_id_foreign');
        });
    }
};
