<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property int    $external_id
 * @property int    $congressperson_external_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Front extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'external_id',
        'congressperson_external_id',
    ];

    public static function setAllInactive()
    {
        self::query()->update(['active' => false]);
    }

    public static function updateOrCreateByExternalId($externalId, $congressperson_external_id)
    {
        $front = self::where('external_id',$externalId)->first();
        if (!$front) {
            $front = self::create([
                'external_id' => $externalId,
                'congressperson_external_id' => $congressperson_external_id,
            ]);
        }
        $front->update([
            'congressperson_external_id'=> $congressperson_external_id,
            'active' => true,
        ]);
    }

    public static function countByCongressperson($congressperson)
    {
        return self::where('congressperson_external_id', $congressperson->external_id)->count();
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
