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
        Schema::create('formula', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('w_id');
            $table->unsignedInteger('z_id');
            $table->unsignedBigInteger('p_id');
            $table->unsignedBigInteger('c_id');
            $table->string('tintBase');
            $table->longText('formula');
            $table->dateTime('formulaDate');
            $table->string('formulaStatus');

            $table->timestamps();

            $table->foreign('w_id')
                ->references('id')
                ->on('work_stations')
                ->onDelete('CASCADE');

            $table->foreign('z_id')
                ->references('id')
                ->on('available_zones')
                ->onDelete('CASCADE');

            $table->foreign('p_id')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE');

            $table->foreign('c_id')
                ->references('id')
                ->on('colors_list')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula');
    }
};
