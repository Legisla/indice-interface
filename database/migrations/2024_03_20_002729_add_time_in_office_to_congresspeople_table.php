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
        Schema::table('congresspeople', function (Blueprint $table) {
            $table->float('time_in_office')->nullable(); // Adicionando o novo campo float à tabela 'congresspeople'
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
            $table->dropColumn('time_in_office'); // Revertendo a adição do campo float se necessário
        });
    }
};
