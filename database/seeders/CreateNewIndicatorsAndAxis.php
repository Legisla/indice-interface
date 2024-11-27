<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateNewIndicatorsAndAxis extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('axes')->delete();
        DB::table('indicators')->delete();
        $axes = [
            ['id' => 1, 'name' => 'Produção Legislativa', 'description' => ''],
            ['id' => 2, 'name' => 'Articulação e mobilização', 'description' => ''],
            ['id' => 3, 'name' => 'Fiscalização', 'description' => ''],
            ['id' => 4, 'name' => 'Alinhamento Partidário', 'description' => ''],
        ];

        foreach ($axes as $axis) {
            DB::table('axes')->updateOrInsert(
                ['id' => $axis['id']], ['name' => $axis['name'], 'description' => $axis['description'],]
            );
        }

        $indicators = [
            ['fk_axis_id' => 1, 'id' =>1, 'name' =>  'Projetos relevantes com protagonismo', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>2, 'name' =>  'Protagonismo em projetos de baixa relevância', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>3, 'name' =>  'Projetos relevantes sem protagonismo', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>4, 'name' =>  'Votos em separado', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>5, 'name' =>  'Substitutivos', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>6, 'name' =>  'Presença em plenário', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>7, 'name' =>  'Emendas de plenário', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>8, 'name' =>  'Emendas de MP', 'description' => ''],
            ['fk_axis_id' => 1, 'id' =>9, 'name' =>  'Emendas LOA/LDO', 'description' => ''],
            ['fk_axis_id' => 2, 'id' =>10, 'name' =>  'Status especial em projetos', 'description' => ''],
            ['fk_axis_id' => 2, 'id' =>11, 'name' =>  'Cargos ocupados na legislatura', 'description' => ''],
            ['fk_axis_id' => 2, 'id' =>12, 'name' =>  'Requerimentos de Audiência Pública', 'description' => ''],
            ['fk_axis_id' => 2, 'id' =>13, 'name' =>  'Reuniões e eventos técnicos', 'description' => ''],
            ['fk_axis_id' => 3, 'id' =>14, 'name' =>  'Requerimento e Fiscalização', 'description' => ''],
            ['fk_axis_id' => 3, 'id' =>15, 'name' =>  'Convocação de Autoridades', 'description' => ''],
            ['fk_axis_id' => 3, 'id' =>16, 'name' =>  'Proposição de CPIs', 'description' => ''],
            ['fk_axis_id' => 4, 'id' =>17, 'name' =>  'Alinhamento partidário', 'description' => '']
        ];


        foreach ($indicators as $indicator) {
            DB::table('indicators')->updateOrInsert(
                ['id' => $indicator['id']],
                [
                    'fk_axis_id' => $indicator['fk_axis_id'],
                    'name' => $indicator['name'],
                    'description' => $indicator['description']
                ]
            );
        }    
    }
}
