<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStarsToCongresspeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('congresspeople', function (Blueprint $table) {
            $table->integer('stars')->default(0);  // Isso adicionará uma coluna de inteiros chamada 'stars' com valor padrão 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('congresspeople', function (Blueprint $table) {
            $table->dropColumn('stars');  // Isso removerá a coluna 'stars' se você decidir reverter a migration
        });
    }

}
