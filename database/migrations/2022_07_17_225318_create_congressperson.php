<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('congresspeople', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id', false, true);
            $table->integer('fk_party_id', false, true)->nullable();
            $table->integer('fk_state_id', false, true)->nullable();
            $table->integer('legislature_id', false, false)->nullable();
            $table->string('uri')->nullable();
            $table->string('uri_photo')->nullable();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('civilName')->nullable();
            $table->string('situation');
            $table->string('document');
            $table->string('sex');
            $table->string('birthdate');
            $table->decimal('expenditure', 12, 2, true)->nullable();
            $table->integer('rate');
            $table->text('old_parties')->nullable();
            $table->text('observation')->nullable();
            $table->date('start_of_mandate')->nullable();
            $table->date('entrance_on_party')->nullable();
            $table->date('end_of_mandate')->nullable();
            $table->date('exit_of_party')->nullable();
            $table->text('preferred_themes')->nullable();
            $table->integer('total_votes')->nullable();
            $table->timestamps();

            $table->foreign('fk_party_id')->references('id')->on('parties');
            $table->foreign('fk_state_id')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('congresspeople');
    }
};
