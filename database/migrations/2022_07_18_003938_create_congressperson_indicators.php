<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('congressperson_indicators', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_indicator_id',false,true)->nullable();
            $table->integer('fk_congressperson_id',false,true)->nullable();
            $table->integer('value',false,true)->nullable();
            $table->decimal('rate',10,1,true)->nullable();
            $table->foreign('fk_indicator_id')->references('id')->on('indicators');
            $table->foreign('fk_congressperson_id')->references('id')->on('congresspeople');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('congressperson_indicators');
    }
};
