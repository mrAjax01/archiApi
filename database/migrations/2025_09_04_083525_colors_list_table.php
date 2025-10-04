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
            $table->string('colorCode')->index();
            $table->string('colorName')->index();
            $table->string('colorHex')->index();
            $table->boolean('glaze');
            $table->text('LABCH_D65');
            $table->smallInteger('LRV');
            $table->boolean('done');
            $table->boolean('updated')->default(false);

            $table->softDeletes();
            $table->timestamps();
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
