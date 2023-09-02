<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int    $id
 * @property int    $external_id
 * @property string $uri
 * @property string $acronymType
 * @property string $typeCode
 * @property string $number
 * @property string $year
 * @property string $menu
 * @property string $details
 * @property string $authors
 * @property string $themes
 * @property Carbon $searched_month_start
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Proposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'uri',
        'acronymType',
        'typeCode',
        'typeDescription',
        'number',
        'year',
        'menu',
        'presententationDate',
        'urlContent',
        'details',
        'authors',
        'themes',
        'searched_month_start',
    ];

    protected $dates = [
        'searched_month_start',
        'created_at',
        'updated_at',
    ];

    public static function getLastFromCongressperson(Congressperson $congressperson)
    {
        return self::select('searched_month_start')
            ->join('congressperson_proposition',
                'congressperson_proposition.proposition_id',
                '=',
                'propositions.id')
            ->where('congressperson_proposition.congressperson_id', $congressperson->id)
            ->orderBy('searched_month_start', 'desc')
            ->first();
    }

    public function checkIfIsRelated(Congressperson $congressperson)
    {
        return $this->congressperson()->where('congresspeople.id', $congressperson->id)->exists();
    }

    public static function getByExternalId($externalId)
    {
        return self::where('external_id', $externalId)->first();
    }


    public static function countByCongressperson($congressperson)
    {
        return self::join('congressperson_proposition',
            'congressperson_proposition.proposition_id',
            '=',
            'propositions.id')
            ->where('congressperson_proposition.congressperson_id', $congressperson->id)
            ->count();
    }

    public function congressperson()
    {
        return $this->belongsToMany(Congressperson::class);
    }

    public static function countPropositionsByCongressperson(Congressperson $congressperson)
    {
        return self::join('congressperson_proposition',
            'congressperson_proposition.proposition_id',
            '=',
            'propositions.id')
            ->where('congressperson_proposition.congressperson_id', $congressperson->id)
            ->count();
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
