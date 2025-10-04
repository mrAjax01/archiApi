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
        Schema::create('available_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ws_id');
            $table->text('zones');

            $table->timestamps();

            $table->foreign('ws_id')
                ->references('id')
                ->on('work_stations')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_zones');
    }
};
