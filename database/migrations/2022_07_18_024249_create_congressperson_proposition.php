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
        Schema::create('congressperson_proposition', function (Blueprint $table) {
            $table->id();
            $table->integer('congressperson_id',false,true);
            $table->integer('proposition_id',false,true);
            $table->timestamps();

            $table->foreign('congressperson_id')->references('id')->on('congresspeople');
            $table->foreign('proposition_id')->references('id')->on('propositions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('congressperson_proposition');
    }
};
