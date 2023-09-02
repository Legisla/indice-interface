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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_congressperson_id')->unsigned();
            $table->decimal('value', 20, 2);
            $table->tinyInteger('month')->unsigned();
            $table->smallInteger('year')->unsigned();
            $table->boolean('closed')->default(false);
            $table->timestamps();

            $table->foreign('fk_congressperson_id')->references('id')->on('congresspeople');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
