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
        Schema::create('colors_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cl_id');
            $table->string('colorCode');
            $table->string('colorName');
            $table->string('colorHex');
            $table->boolean('glaze');
            $table->text('LABCH_D65');
            $table->smallInteger('LRV');

            $table->timestamps();

            $table->foreign('cl_id')
                ->references('id')
                ->on('color_cards_list')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors_list');
    }
};
