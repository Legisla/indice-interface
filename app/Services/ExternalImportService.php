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
        $congressperson = Congressperson::firstOrCreate(['name' => $congresspersonName]);

        for ($i = 1; $i <= 16; $i++) {
            $value = $row["variavel_{$i}"];
            $score = $row["variavel_{$i}_score"];
            $stars = $row["variavel_{$i}_stars"];

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