<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int    $id
 * @property int    $external_id
 * @property string $name
 * @property string $acronym
 * @property string $number
 * @property string url_logo
 * @property string url_site
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Party extends Model
{
    use HasFactory;

    protected $table = 'parties';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'external_id',
        'name',
        'acronym',
        'number',
        'url_logo',
        'url_site',
    ];

    /**
     * @param int $externalId
     * @return Party|null
     */
    public static function findByExternalId(int $externalId): ?Party
    {
        $party = self::where('external_id', $externalId)->first();

        if (!$party) {
            return new self();
        }

        return $party;
    }

    public static function getAcronymById(int $id): ?string
    {
        $party = self::where('id', $id)->first();

        if (!$party) {
            return null;
        }

        return $party->acronym;
    }

    /**
     * @param string $acronym
     * @return int|null
     */
    public static function findIdByAcronym(string $acronym): ?int
    {
        $party = self::where('acronym', $acronym)->first();

        if (!$party) {
            return null;
        }

        return $party->id;
    }

    public static function list():array
    {
        $parties = self::all();
        $list = [];
        foreach ($parties as $party) {
            $list[$party->id] = $party->acronym;
        }
        return $list;
    }


    public static function getActiveParties()
    {
        // Obter todos os partidos que têm parlamentares ativos
        $parties = DB::table('parties')
            ->join('congresspeople', 'congresspeople.fk_party_id', '=', 'parties.id')
            ->where('congresspeople.active', 1)
            ->select('parties.id', 'parties.acronym', 'parties.name', 'parties.url_logo') // ou qualquer outro campo que você precise
            ->distinct() // Garante que cada partido seja selecionado apenas uma vez
            ->orderBy('parties.name')
            ->get();

        return $parties;
    }


}
