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
        Schema::create('colors_in_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cl_id');
            $table->unsignedBigInteger('c_id');

            $table->timestamps();

            $table->foreign('cl_id')
                ->references('id')
                ->on('color_cards_list')
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
        Schema::dropIfExists('colors_in_cards');
    }
};
