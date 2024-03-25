<?php 
namespace App\Services;

use App\Models\Congressperson;
use App\Models\CongresspersonIndicator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExternalImportService implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        dump($row);
        $congresspersonName = $row['deputado'];
        $congressperson = Congressperson::firstOrCreate(['external_id' => $row['external_id']], ['external_id' => $row['external_id'], 'name' => $congresspersonName ]);
        $congressperson->update(['active' => true, 'stars' => $row["stars"], 'time_in_office' => $row['time_in_office'] ]);
        #$congressperson->external_id = $row['external_id']; 

        for ($i = 1; $i <= 16; $i++) {
            $value = $row["variavel_{$i}"];
            $score = $row["variavel_{$i}_score"];

            CongresspersonIndicator::updateOrCreate(
                [
                    'fk_indicator_id' => $i,
                    'fk_congressperson_id' => $congressperson->id,
                ],
                [
                    'value' => $value,
                    'score' => $score,
                    'outlier' => 0, #TODO: Consertar depois.
                ]
            );
        }
    }
}

?>