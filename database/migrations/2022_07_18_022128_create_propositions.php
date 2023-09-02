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
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id',false,true);
            $table->string('uri',false,true);
            $table->string('acronymType')->nullable();
            $table->string('typeCode')->nullable();
            $table->string('number')->nullable();
            $table->string('year')->nullable();
            $table->text('menu')->nullable();
            $table->longText('details')->nullable();
            $table->longText('authors')->nullable();
            $table->longText('themes')->nullable();
            $table->date('searched_month_start');
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
        Schema::dropIfExists('propositions');
    }
};
