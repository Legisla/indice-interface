<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Indicator extends BaseModel
{
    use HasFactory;

    public static function findByAxesId(int $axisId): array
    {
        $indicator = self::where('fk_axis_id', $axisId)->get();

        $ret = [];
        $indicator->each(function ($item) use (&$ret) {
            $ret[$item->id] = $item->name;
        });

        return $ret;
    }

    public static function shouldRevert(int $indicatorId): bool
    {
        $indicator = self::find($indicatorId);

        return $indicator->invert_score == 1;
    }
}
