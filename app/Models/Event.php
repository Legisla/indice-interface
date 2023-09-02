<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int    $id
 * @property int    $external_id
 * @property string $presence
 * @property Carbon $searched_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Event extends Model
{
    use HasFactory;

    protected $dates = [
        'searched_date',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'external_id',
        'presence',
        'searched_date',
    ];


    public static function getLastDate()
    {
        return Event::orderBy('searched_date', 'desc')->first()?->searched_date;
    }

    public static function findByExternalId($externalId)
    {
        return Event::where('external_id', $externalId)->first();
    }

    public static function getTotalEvents()
    {
        return Event::count();
    }

    public static function getTotalPresence(int $congressPersonExternalId)
    {
        $total = 0;
        self::all()->each(function ($event) use ($congressPersonExternalId, &$total) {
            $presence = json_decode($event->presence);

            if(in_array($congressPersonExternalId, $presence)) {
                $total++;
            }

        });

        return $total;
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
