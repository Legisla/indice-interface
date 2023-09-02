<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\State
 *
 * @property int    $id
 * @property string $name
 * @property string $acronym
 * @property float  $average_expenditure
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class State extends Model
{
    use HasFactory;

    /**
     * @param string $acronym
     * @return int|null
     */
    public static function findIdByAcronym(string $acronym): ?int
    {
        return self::where('acronym', $acronym)->first()?->id;
    }

    /**
     * @param string $acronym
     * @return \App\Models\State|null
     */
    public static function findByAcronym(string $acronym): ?State
    {
        return self::where('acronym', $acronym)->first();
    }

    public static function setAverageExpenditure(int $stateId, float $averageExpenditure): void
    {
        $state = self::find($stateId);
        $state->average_expenditure = $averageExpenditure;
        $state->save();
    }

    public static function getExpenditure(int $stateId): ?float
    {
        return self::find($stateId)->average_expenditure;
    }


    public static function findAxisById(int $stateId): ?array
    {
        $data = self::select('avg_1', 'avg_2', 'avg_3', 'avg_4')
            ->where('id', $stateId)
            ->first()
            ->toArray();

        return [
            1 => $data['avg_1'],
            2 => $data['avg_2'],
            3 => $data['avg_3'],
            4 => $data['avg_4'],
        ];
    }


    public static function findIndicatorsById(int $stateId): ?array
    {
        $data = self::select(
            'iavg_1',
            'iavg_2',
            'iavg_3',
            'iavg_4',
            'iavg_5',
            'iavg_6',
            'iavg_7',
            'iavg_8',
            'iavg_9',
            'iavg_10',
            'iavg_11',
            'iavg_12',
            'iavg_13',
            'iavg_14',
            'iavg_15',
            'iavg_16',
        )->where('id', $stateId)
            ->first()
            ->toArray();

        return [
            1 => [
                1 => $data['iavg_1'],
                2 => $data['iavg_2'],
                3 => $data['iavg_3'],
                4 => $data['iavg_4'],
                5 => $data['iavg_5'],
                6 => $data['iavg_6'],
                7 => $data['iavg_7'],
                8 => $data['iavg_8'],
            ],
            2 => [
                9 => $data['iavg_9'],
                10 => $data['iavg_10'],
                11 => $data['iavg_11'],
                12 => $data['iavg_12'],
            ],
            3 => [
                13 => $data['iavg_13'],
                14 => $data['iavg_14'],
                15 => $data['iavg_15']
            ],
            4 => [
                16 => $data['iavg_16']
            ],
        ];
    }

    public static function getAcronymById(int $id): ?string
    {
        $party = self::where('id', $id)->first();

        if (!$party) {
            return null;
        }

        return $party->acronym;
    }
}
