<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveToCongresspeopleTable extends Migration
{
    public function up()
    {
        Schema::table('congresspeople', function (Blueprint $table) {
            $table->boolean('active')->default(true);  // O padrão será 'true', mas você pode mudar conforme necessário
        });
    }

    public function down()
    {
        Schema::table('congresspeople', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}



