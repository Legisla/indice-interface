<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int    $id
 * @property int    $congressperson_id
 * @property int    $total
 * @property string $created_at
 * @property string $updated_at
 */
class Amendment extends Model
{
    use HasFactory;

    protected $fillable = [
        'congressperson_id',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static function updateOrCreate(int $congressperson_id, int $total)
    {
        if ($amendment = self::where('congressperson_id', $congressperson_id)->first()) {
            $amendment->total = $total;
            $amendment->save();
        } else {
            self::create([
                'congressperson_id' => $congressperson_id,
                'total' => $total,
            ]);
        }
    }

    public static function getTotalByCongresspersonId(int $congressperson_id)
    {
        return self::where('congressperson_id', $congressperson_id)->first()->total;
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
