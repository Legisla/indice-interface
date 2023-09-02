<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Collection as EloquentCollection;
use  Illuminate\Support\Carbon;

/**
 * @property int    $id
 * @property int    $external_id
 * @property string $votes
 * @property string $orientations
 * @property Carbon $searched_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Votation extends Model
{
    use HasFactory;

    protected $dates = [
        'searched_date',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'external_id',
        'votes',
        'orientations',
        'searched_date',
    ];

    public static function getLastDate(): ?Carbon
    {
        return Votation::orderBy('searched_date', 'desc')->first()?->searched_date;
    }

    public static function findByExternalId($externalId): ?Votation
    {
        return Votation::where('external_id', $externalId)->first();
    }

    public static function getAllWithVotes(): ?EloquentCollection
    {
        return Votation::where('votes','<>','[]')->get();
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
