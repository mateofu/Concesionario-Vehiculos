<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedSmallInteger('duration_minutes')->after('scheduled_at');
            $table->string('status')->default('programada')->change();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('duration_minutes');
            $table->string('status')->default('pending')->change();
        });
    }
};
