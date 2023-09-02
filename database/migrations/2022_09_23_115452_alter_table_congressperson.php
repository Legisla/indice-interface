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
            $table->decimal('rate_non_adjusted',10,3)->nullable()->after('rate');
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
            $table->dropColumn('rate_non_adjusted');
        });
    }
};
