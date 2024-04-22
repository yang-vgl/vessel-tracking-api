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
        Schema::create('vessel_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mmsi');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('station_id');
            $table->unsignedSmallInteger('speed');
            $table->point('coordinates');
            $table->unsignedSmallInteger('course');
            $table->unsignedSmallInteger('heading');
            $table->string('rot')->nullable();
            $table->bigInteger('timestamp')->nullable();

            $table->index('mmsi');
            $table->index('station_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessel_positions');
    }
};
