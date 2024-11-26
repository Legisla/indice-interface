<?php 
namespace App\Services;

use App\Models\Congressperson;
use App\Models\CongresspersonIndicator;
use App\Models\CongresspersonAxis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Party;
use App\Models\State;

class ExternalImportService implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        dump($row);
        $congressperson = Congressperson::firstOrCreate(['external_id' => $row['iddeputado']]);
        $party_acronym = $row['siglapartido'];
        $uf_acronym = $row['siglauf'];
        $party_id = Party::findIdByAcronym($party_acronym);
        $uf_id = State::findIdByAcronym($uf_acronym);
        $rate_non_ajusted=(float)str_replace(',', '.', $row['score_final']);
        $congressperson->update([
            'legislature_id' => $row['legislat'],
            'fk_party_id' => $party_id,
            'fk_state_id' => $uf_id,
            'stars' => $row['estrelas'],
            'name' => $row['nome'],
            'sex' => $row['siglasexo'],
            'civilName' => $row['nomecivil'],
            'active' => true,
            'time_in_office' => $row['meses'],
            'uri' => $row['uri'],
            'uri_photo' => $row['urlfoto'],
            'situation' => $row['situacao'],
            'document' => $row['documento'],
            'email' => $row['email'],
            'birthdate' => $row['datanascimento'],
            'rate_non_adjusted' => $rate_non_ajusted,
            'rate' => round($rate_non_ajusted)

        ]);
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
                    'value' => '0.0',//valores absolutos não são mais utilizados. 
                    'score' => str_replace(',', '.', $score_indicator), //altera separador de decimais antes de importar
                    'outlier' => 0, #TODO: Consertar depois.
                ]
            );  
        }
    }
}

?>