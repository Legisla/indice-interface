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
        Schema::create('votations', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique();
            $table->longText('votes')->nullable();
            $table->longText('orientations')->nullable();
            $table->date('searched_date');
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
        Schema::dropIfExists('votations');
    }
};
