<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
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
        // Apaga todos os indicadores da tabela
        DB::table('axes')->truncate();
        DB::table('indicators')->truncate();
        Schema::table('states', function ($table) {
            $table->decimal('iavg_17', 10, 1)->nullable(); // Adiciona a coluna iavg_17 como decimal(10,1)
        });
        
        Artisan::call('db:seed', [
            '--class' => 'CreateNewIndicatorsAndAxis',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Apaga todos os indicadores novamente
        DB::table('axes')->truncate();
        DB::table('indicators')->truncate();
        Schema::table('states', function ($table) {
            $table->dropColumn('iavg_17');
        });

        // Roda o seeder CreateIndicatorsAndAxes
        Artisan::call('db:seed', [
            '--class' => 'CreateIndicatorsAndAxes',
        ]);
    }
};
