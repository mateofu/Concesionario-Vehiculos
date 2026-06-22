<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
        });

        Schema::table('owners', function (Blueprint $table) {
            $table->string('last_name')->after('first_name');
            $table->string('document_type')->after('last_name');
            $table->string('document_number')->after('document_type');
            $table->unique(['document_type', 'document_number']);
        });
    }

    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropUnique(['document_type', 'document_number']);
            $table->dropColumn(['last_name', 'document_type', 'document_number']);
        });

        Schema::table('owners', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
        });
    }
};
