<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int     $id
 * @property int     fk_indicator_id
 * @property int     $fk_congressperson_id
 * @property int     fk_importation_id
 * @property int     $number_of_classes
 * @property float   $value_between_classes
 * @property float   $indicator_value
 * @property boolean $outlier
 * @property int     $indicator_value_class
 * @property float   $adjustment_factor_classes_to_10
 * @property decimal $indicator_class_adjusted_to_10
 * @property float   $indicator_class_adjusted_to_10_formated
 * @property float   $indicator_score
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 */
class ImportationCongresspersonIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_indicator_id',
        'fk_congressperson_id',
        'fk_importation_id',
        'number_of_classes',
        'value_between_classes',
        'indicator_value',
        'outlier',
        'indicator_value_class',
        'adjustment_factor_classes_to_10',
        'indicator_class_adjusted_to_10',
        'indicator_class_adjusted_to_10_formated',
        'indicator_score',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'importations_congresspeople_indicators';

    public function congressperson(): BelongsTo
    {
        return $this->belongsTo(Congressperson::class, 'fk_congressperson_id', 'id');
    }

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(Indicator::class, 'fk_indicator_id', 'id');
    }

    public static function getCurrentLastValidImporationData(): EloquentCollection
    {
        $importation = Importation::getLastCompleted();

        return self::join('importations', 'importations.id', '=', 'importations_congresspeople_indicators.fk_importation_id')
            ->with(['congressperson', 'indicator'])
            ->where('importations.id', $importation->id)
            ->get();
    }
}
