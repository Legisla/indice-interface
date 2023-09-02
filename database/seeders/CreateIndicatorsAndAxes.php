<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateIndicatorsAndAxes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $axes = [
            ['id' => 1, 'name' => 'Produção Legislativa', 'description' => ''],
            ['id' => 2, 'name' => 'Fiscalização', 'Description' => ''],
            ['id' => 3, 'name' => 'Mobilização', 'Description' => ''],
            ['id' => 4, 'name' => 'Alinhamento Partidário', 'Description' => ''],
        ];

        foreach ($axes as $axis) {
            DB::table('axes')->updateOrInsert(
                ['id' => $axis['id']], ['name' => $axis['name'], 'description' => $axis['description'],]
            );
        }

        $indicators = [
            ['fk_axis_id' => 1, 'id' => 1, 'name' => 'Projetos', 'Description' => ''],//contar cada projeto de cada um
            ['fk_axis_id' => 1, 'id' => 2, 'name' => 'Protagonismo', 'Description' => ''],
            ['fk_axis_id' => 1, 'id' => 3, 'name' => 'Relevância das Autorias', 'Description' => ''],
            ['fk_axis_id' => 1, 'id' => 4, 'name' => 'Votos em separado apresentados', 'Description' => ''],
            ['fk_axis_id' => 1, 'id' => 5, 'name' => 'Substituitivos apresentados', 'Description' => ''],
            ['fk_axis_id' => 1, 'id' => 6, 'name' => 'Relatorias apresentadas', 'Description' => ''],
            ['fk_axis_id' => 1, 'id' => 7, 'name' => 'Presença em Plenário', 'Description' => ''],
            ['fk_axis_id' => 1, 'id' => 8, 'name' => 'Emendas de Plenário', 'Description' => ''],
            ['fk_axis_id' => 2, 'id' => 9, 'name' => 'Solicitação de informações protocoladas', 'Description' => ''],
            ['fk_axis_id' => 2, 'id' => 10, 'name' => 'Propostas de Fiscalização e Controle protocoladas', 'Description' => ''],
            ['fk_axis_id' => 2, 'id' => 11, 'name' => 'Emendas Parlamentares', 'Description' => ''],
            ['fk_axis_id' => 2, 'id' => 12, 'name' => 'Emendas de Medidas Provisórias', 'Description' => ''],
            ['fk_axis_id' => 2, 'id' => 12, 'name' => 'Emendas de orçamento', 'Description' => ''],
            ['fk_axis_id' => 3, 'id' => 13, 'name' => 'Projetos de autoria com status especial', 'Description' => ''],
            ['fk_axis_id' => 3, 'id' => 14, 'name' => 'Cargos ocupados na legislatura', 'Description' => ''],
            ['fk_axis_id' => 3, 'id' => 15, 'name' => 'Requerimentos de Audiência Pública', 'Description' => ''],
            ['fk_axis_id' => 4, 'id' => 17, 'name' => 'Desvio da posição majoritária do partido em votações', 'Description' => ''],
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
