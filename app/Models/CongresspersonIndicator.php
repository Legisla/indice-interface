<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\CongresspersonIndicator
 *
 * @property int    $id
 * @property int    $fk_indicator_id
 * @property int    $fk_congressperson_id
 * @property int    $value
 * @property int    $score
 * @property int    $outlier
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CongresspersonIndicator extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'fk_indicator_id',
        'fk_congressperson_id',
        'value',
        'score',
        'outlier',
    ];

    /**
     * @param int $congressPersonExternalId
     * @param int $indicatorId
     * @param int | null $value
     * @return void
     */
    public static function saveOrUpdate(int $congressPersonExternalId, int $indicatorId, ?int $value): void
    {
        $congressPerson = Congressperson::findByExternalId($congressPersonExternalId);

        $indicator = self::where('fk_indicator_id', $indicatorId)
            ->where('fk_congressperson_id', $congressPerson->id)
            ->first();

        if ($indicator) {
            $indicator->value = $value;
            $indicator->score = 0;
            $indicator->outlier = 0;
            $indicator->save();
        } else {
            self::create([
                'fk_indicator_id' => $indicatorId,
                'fk_congressperson_id' => $congressPerson->id,
                'value' => $value,
                'score' => 0,
                'outlier' => 0,
            ]);
        }
    }


    /**
     * @param int $congressPersonExternalId
     * @param int $indicatorId
     * @return void
     */
    public static function incrementOnly(int $congressPersonExternalId, int $indicatorId): void
    {
        $congressPerson = Congressperson::findByExternalId($congressPersonExternalId);

        $indicator = self::where('fk_indicator_id', $indicatorId)
            ->where('fk_congressperson_id', $congressPerson->id)
            ->first();

        $indicator->value++;
        $indicator->save();
    }

    /**
     * @param int $indicatorId
     * @return EloquentCollection
     */
    public static function findByIndicator(int $indicatorId): EloquentCollection
    {
        return self::where('fk_indicator_id', $indicatorId)->get();
    }

    public static function findByStateIdAndIndicator(int $stateId, int $indicator): EloquentCollection
    {
        return self::where('fk_state_id', $stateId)
            ->where('fk_indicator_id', $indicator)
            ->join('congresspeople', 'congresspeople.id', '=', 'congressperson_indicators.fk_congressperson_id')
            ->get();
    }


    public static function findByIndicatorAndCongressperson(int $indicatorId, int $congresspersonId): ?EloquentCollection
    {
        return self::where('fk_indicator_id', $indicatorId)
            ->where('fk_congressperson_id', $congresspersonId)
            ->get();
    }


    public static function findByAxisIdAndCongressperson(int $axisId, int $congresspersonId): ?array
    {
        $data = self::select('fk_indicator_id', 'score')
            ->where('indicators.fk_axis_id', $axisId)
            ->where('fk_congressperson_id', $congresspersonId)
            ->join('indicators', 'indicators.id', '=', 'congressperson_indicators.fk_indicator_id')
            ->get();

        if ($data->isEmpty()) {
            return null;
        }

        $ret = [];
        $data->each(function ($item) use (&$ret) {
            $ret[$item->fk_indicator_id] = $item->score;
        });

        return $ret;
    }

    public static function findScoreAndValueByAxisIdAndCongressperson(int $axisId, int $congresspersonId): ?array
    {
        $data = self::select('fk_indicator_id', 'score', 'value', 'outlier')
            ->where('indicators.fk_axis_id', $axisId)
            ->where('fk_congressperson_id', $congresspersonId)
            ->join('indicators', 'indicators.id', '=', 'congressperson_indicators.fk_indicator_id')
            ->get();

        if ($data->isEmpty()) {
            return null;
        }

        $ret = [];
        $data->each(function ($item) use (&$ret) {
            $ret[$item->fk_indicator_id] = [
                'score' => $item->score,
                'value' => $item->value,
                'outlier' => $item->outlier,
            ];
        });

        return $ret;
    }

    public function markAsOutlier(): void
    {
        $this->outlier = 1;
        $this->save();
    }

    public static function resetOutliers(): void
    {
        self::where('outlier', 1)->update(['outlier' => 0]);
    }

    public static function resetIndicatorsByCongressPerson(Congressperson $congressPerson): void
    {
        Indicator::all()->each(function ($indicator) use ($congressPerson) {
            CongresspersonIndicator::saveOrUpdate(
                $congressPerson->external_id,
                $indicator->id,
                0
            );
        });
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
