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
        Schema::table('congressperson_indicators', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('congressperson_indicators', function (Blueprint $table) {
            $table->bigInteger('value', false)->after('fk_congressperson_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('congressperson_indicators', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('congressperson_indicators', function (Blueprint $table) {
            $table->integer('value',false,true)->after('fk_congressperson_id')->nullable();
        });
    }
};
