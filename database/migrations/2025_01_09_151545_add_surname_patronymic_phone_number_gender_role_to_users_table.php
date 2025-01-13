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
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('gender')->default(\App\Enums\GenderEnum::Unspecified);
            $table->string('role')->default(\App\Enums\RoleEnum::User);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('patronymic');
            $table->dropColumn('phone_number');
            $table->dropColumn('gender');
            $table->dropColumn('role');
        });
    }
};
