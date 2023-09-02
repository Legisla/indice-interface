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
            $table->tinyInteger('outlier')->default(0)->nullable()->after('score');
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
            $table->dropColumn('outlier');
        });
    }
};
