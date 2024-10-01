<?php 
namespace App\Services;

use App\Models\Congressperson;
use App\Models\CongresspersonIndicator;
use App\Models\CongresspersonAxis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExternalImportService implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        dump($row);
        $congressperson = Congressperson::firstOrCreate(['external_id' => $row['iddeputado'],'legislature_id'=> $row['legislat']]);
        $congressperson->update(['stars' =>0,'name' => $row['nome'], 'sex'=>$row['siglasexo'], 'civilName' => $row['nomecivil'],'active' => true,'time_in_office' => $row['meses']]);
        //importa scores dos eixos
        for ($i = 1; $i <= 4; $i++) {
            $score_axis = $row["eixo_{$i}"];
            CongresspersonAxis::updateOrCreate(
                [
                    'fk_axis_id' => $i,
                    'fk_congressperson_id' => $congressperson->id,
                ],
                [
                    'score' => str_replace(',', '.', $score_axis),
                ]
            );
        }
        for ($i = 1; $i <= 17; $i++) {
            $score_indicator = $row["variavel_{$i}_score"];

            CongresspersonIndicator::updateOrCreate(
                [
                    'fk_indicator_id' => $i,
                    'fk_congressperson_id' => $congressperson->id,
                ],
                [
                    'value' => '',//valores absolutos não são mais utilizados. 
                    'score' => str_replace(',', '.', $score_indicator), //altera separador de decimais antes de importar
                    'outlier' => 0, #TODO: Consertar depois.
                ]
            );  
        }
    }
}

?>