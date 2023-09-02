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
        Schema::table('amendments', function (Blueprint $table) {
            $table->dropColumn('total');
        });

        Schema::table('amendments', function (Blueprint $table) {
            $table->decimal('total', 20, 2)->after('congressperson_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amendments', function (Blueprint $table) {
            $table->dropColumn('total');
        });
        Schema::table('amendments', function (Blueprint $table) {
            $table->integer('total', false, true);
        });
    }
};
