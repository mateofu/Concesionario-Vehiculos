<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_station_technician', function (Blueprint $table) {
            $table->foreignId('work_station_id')->constrained('work_stations')->cascadeOnDelete();
            $table->foreignId('technician_id')->constrained('technicians')->cascadeOnDelete();
            $table->primary(['work_station_id', 'technician_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_station_technician');
    }
};
