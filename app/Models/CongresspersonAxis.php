<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class CongresspersonAxis extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'fk_axis_id',
        'fk_congressperson_id',
        'value',
        'score',
    ];


    /**
     * @param $stateId
     * @param $axisId
     * @return mixed
     */
    public static function findByStateId($stateId, $axisId)
    {
        return self::where('fk_state_id', $stateId)
            ->where('fk_axis_id', $axisId)
            ->join('congresspeople', 'fk_congressperson_id', '=', 'congresspeople.id')->get();
    }

    public static function findByAxisId($axisId)
    {
        return self::where('fk_axis_id', $axisId)->get();
    }

    public static function findByAxisIdAndCongressperson($axisId, $congresspersonId)
    {
        $data = self::where('fk_axis_id', $axisId)
            ->where('fk_congressperson_id', $congresspersonId)
            ->first();

        if($data){
            return $data->score;
        }

        return 0;
    }

    public static function saveOrCreate($congressPersonId, $axisId, $score)
    {
        $congresspersonAxis = self::where('fk_congressperson_id', $congressPersonId)
            ->where('fk_axis_id', $axisId)
            ->first();
        if ($congresspersonAxis) {
            $congresspersonAxis->score = $score;
            $congresspersonAxis->save();
        } else {
            self::create([
                'fk_congressperson_id' => $congressPersonId,
                'fk_axis_id' => $axisId,
                'score' => $score,
            ]);
        }
    }

    public static function findByCongrespersonId(int $congresspersonId)
    {
        return self::where('fk_congressperson_id', $congresspersonId)->get();
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
