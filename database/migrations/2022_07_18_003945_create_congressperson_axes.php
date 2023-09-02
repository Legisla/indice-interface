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
        Schema::create('congressperson_axes', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_congressperson_id',false,true);
            $table->integer('fk_axis_id',false,true);
            $table->integer('value',false,true)->nullable();
            $table->decimal('rate',10,1,true)->nullable();
            $table->timestamps();

            $table->foreign('fk_congressperson_id')->references('id')->on('congresspeople');
            $table->foreign('fk_axis_id')->references('id')->on('axes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('congressperson_axes');
    }
};
