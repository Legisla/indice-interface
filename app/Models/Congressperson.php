<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use  Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;


/**
 * @property int    $id
 * @property int    $external_id
 * @property int    $fk_party_id
 * @property int    $fk_state_id
 * @property int    $legislature_id
 * @property string $uri
 * @property string $uri_photo
 * @property string $email
 * @property string $name
 * @property string $title
 * @property string $civilName
 * @property string $situation
 * @property string $document
 * @property string $sex
 * @property string $birthdate
 * @property float  expenditure
 * @property int    $rate
 * @property float  $rate_non_adjusted
 * @property string $old_parties
 * @property string $observation
 * @property string $preferred_themes
 * @property string $membership_on_bodies
 * @property int    $total_votes
 * @property Carbon $start_of_mandate
 * @property Carbon $entrance_on_party
 * @property Carbon $end_of_mandate
 * @property Carbon $exit_of_party
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Congressperson extends BaseModel
{
    use HasFactory;

    protected $table = 'congresspeople';

    protected $dates = [
        'created_at',
        'updated_at',
        'start_of_mandate',
        'entrance_on_party',
        'end_of_mandate',
        'exit_of_party',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'fk_party_id',
        'fk_state_id',
        'external_id',
        'legislature_id',
        'name',
        'civilName',
        'uri',
        'uri_photo',
        'email',
        'situation',
        'document',
        'sex',
        'birthdate',
        'expenditure',
        'rate',
        'rate_non_adjusted',
    ];

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class, 'fk_party_id', 'id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'fk_state_id', 'id');
    }

    public function proposition(): BelongsToMany
    {
        return $this->belongsToMany(Proposition::class);
    }

    public static function findByExternalId(int $externalId): ?Congressperson
    {
        return self::where('external_id', $externalId)->first();
    }

    public static function findOrCreateByExternalId(int $externalId): ?Congressperson
    {
        $congressperson = self::where('external_id', $externalId)->first();

        if (!$congressperson) {
            return new self();
        }

        return $congressperson;
    }

    public static function getDetails(int $externalId): ?Congressperson
    {
        return self::select(
            'congresspeople.id as id',
            'congresspeople.start_of_mandate',
            'congresspeople.entrance_on_party',
            'congresspeople.end_of_mandate',
            'congresspeople.exit_of_party',
            'congresspeople.title as title',
            'congresspeople.old_parties as old_parties',
            'congresspeople.observation as observation',
            'congresspeople.name as congressperson_name',
            'parties.acronym as party_acronym',
            'congresspeople.uri',
            'states.acronym as state_acronym',
            'states.name as state_name',
            'congresspeople.fk_state_id',
            'situation',
            'sex',
            'rate',
            'expenditure',
            'uri_photo',
            'preferred_themes'
        )
            ->join('parties', 'parties.id', '=', 'congresspeople.fk_party_id')
            ->join('states', 'states.id', '=', 'congresspeople.fk_state_id')
            ->where('congresspeople.external_id', $externalId)->first();
    }

    /**
     * @param float|null $value
     * @return void
     */
    public function setExpenditure(float|null $value): void
    {
        $this->attributes['expenditure'] = $value;
        $this->save();
    }



    /**
     * Prepares a base query for fetching congresspeople with essential details.
     * 
     * This method sets up a base query that selects key details about a congressperson,
     * including their external ID, name, photo URI, state acronym, party acronym, and rate.
     * The method also sets up the necessary joins with the `parties` and `states` tables 
     * to fetch the party and state details respectively.
     * 
     * @return \Illuminate\Database\Eloquent\Builder Prepared query with essential congressperson details.
     */
    private static function mountExplorerQuery()
    {
        return self::select(
            'congresspeople.external_id',
            'congresspeople.name',
            'congresspeople.uri_photo',
            'states.acronym as  state_acronym',
            'parties.acronym as party_acronym',
            'rate')
            ->join('parties', 'parties.id', '=', 'congresspeople.fk_party_id')
            ->join('states', 'states.id', '=', 'congresspeople.fk_state_id')
            ->orderBy('congresspeople.name', 'asc');
    }

    /**
     * Fetch congresspeople by the provided state ID.
     *
     * @param int $fkStateId State ID to filter congresspeople.
     * @return EloquentCollection|null Congresspeople for the specified state, or null if none found.
     */
    public static function getByState(int $fkStateId): ?EloquentCollection
    {
        return self::mountExplorerQuery()
            ->where('fk_state_id', $fkStateId)
            ->get();
    }

    public static function getAll(): ?EloquentCollection
    {
        return self::mountExplorerQuery()
            ->get();
    }
    
    public static function getByParty(string $acronym): ?EloquentCollection
    {
        return self::mountExplorerQuery()
        ->where('parties.acronym', $acronym)
        ->get();
    }

    

    public static function getByRate(int $star): ?EloquentCollection
    {
        return self::mountExplorerQuery()
            ->where('rate', '>', ($star - 1) * 20)
            ->where('rate', '<=', $star * 20)
            ->get();
    }

    public static function getByRateAndState(int $fkStateId, int $star): ?EloquentCollection
    {
        return self::mountExplorerQuery()
            ->where('fk_state_id', $fkStateId)
            ->where('rate', '>', ($star - 1) * 20)
            ->where('rate', '<=', $star * 20)
            ->get();
    }


    public static function getByName(string $name): ?EloquentCollection
    {
        return self::mountExplorerQuery()
            ->where('congresspeople.name', 'like', '%' . $name . '%')
            ->get();
    }

    public static function getByWeight(array $weights): ?EloquentCollection
    {
        return self::mountExplorerQuery()
            ->join('congressperson_indicators', 'congressperson_indicators.fk_congressperson_id', '=', 'congresspeople.id')
            ->whereBetween('score', $weights)
            ->get();
    }

    public static function findByIndicatorScoreRange(int $indicator, int $star, int|null $fkStateId)
    {
        return self::mountExplorerQuery()
            ->addSelect('congressperson_indicators.score as score')
            ->join('congressperson_indicators', 'congressperson_indicators.fk_congressperson_id', '=', 'congresspeople.id')
            ->where('congressperson_indicators.fk_indicator_id', $indicator)
            ->where('congressperson_indicators.score', '>', ($star - 1) * 2)
            ->where('congressperson_indicators.score', '<=', $star * 2)
            ->when($fkStateId, function ($query) use ($fkStateId) {
                return $query->where('congresspeople.fk_state_id', $fkStateId);
            })
            ->get();
    }


    public static function findByAxisScoreRange(int $axis, int $star, int|null $fkStateId)
    {
        return self::mountExplorerQuery()
            ->addSelect('congressperson_axes.score as score')
            ->join('congressperson_axes', 'congressperson_axes.fk_congressperson_id', '=', 'congresspeople.id')
            ->where('congressperson_axes.fk_axis_id', $axis)
            ->where('congressperson_axes.score', '>', ($star - 1) * 2)
            ->where('congressperson_axes.score', '<=', $star * 2)
            ->when($fkStateId, function ($query) use ($fkStateId) {
                return $query->where('congresspeople.fk_state_id', $fkStateId);
            })
            ->get();
    }

    public static function findByAverageScoreInAxis(int $axisId, float $minAverageScore): EloquentCollection
{
    return self::select('congresspeople.*', DB::raw('AVG(congressperson_indicators.score) as average_score'))
        ->join('congressperson_indicators', 'congresspeople.id', '=', 'congressperson_indicators.fk_congressperson_id')
        ->join('indicators', 'indicators.id', '=', 'congressperson_indicators.fk_indicator_id')
        ->where('indicators.fk_axis_id', $axisId)
        ->groupBy('congresspeople.id')
        ->having('average_score', '>=', $minAverageScore)
        ->get();
}

    /**
     * @param int $limit
     * @param int|null $fkStateId
     * @return EloquentCollection|null
     */
    public static function getTopNScores(int $limit, ?int $fkStateId = null): ?EloquentCollection
    {
    $query = self::query()
                ->orderBy('rate', 'desc')
                ->limit($limit);

    if ($fkStateId !== null) {
        $query->where('fk_state_id', $fkStateId);
    }

    return $query->get();
    }


    /**
     * @param array    $indicator
     * @param int      $qtt
     * @param int|null $fkStateId
     * @return EloquentCollection|null
     */
    public static function findByIndicatorWeightedScore(array $indicator, int $qtt, int|null $fkStateId): ?EloquentCollection
    {
        $subquery = '(';
        foreach ($indicator as $key => $value) {
            $subquery .= '
            (select (congressperson_indicators.score * ' . $value . ') from congressperson_indicators
            where congressperson_indicators.fk_indicator_id = ' . $key . ' and congressperson_indicators.fk_congressperson_id = congId) +';
        }
        $subquery = rtrim($subquery, '+');
        $subquery .= ')/' . $qtt . ' as mainScore';

        return self::mountExplorerQuery()
            ->addSelect(
                'congresspeople.id as congId',
                DB::raw($subquery))
            ->when($fkStateId, function ($query) use ($fkStateId) {
                return $query->where('congresspeople.fk_state_id', $fkStateId);
            })
            ->get();
    }

    /**
     * @param string $externalId
     * @return string|null
     */
    public static function getPartyExtIdFromExtId(string $externalId): ?string
    {
        return self::select('parties.external_id')
            ->where('congresspeople.external_id', $externalId)
            ->join('parties', 'parties.id', '=', 'congresspeople.fk_party_id')
            ->first()?->external_id;
    }

    public static function getAllCurrent(): ?EloquentCollection
    {
        return self::where('legislature_id', config('source.legislature_id'))
            ->orderby('name')->get();
    }

    public static function getAllCurrentWithStatesAndParties(): ?EloquentCollection
    {
        return self::where('legislature_id', config('source.legislature_id'))
            ->with(['state', 'party'])
            ->orderby('name')->get();
    }

    public static function resetMemberships(string $legislatureId): void
    {
        self::where('legislature_id', $legislatureId)
            ->update(['membership_on_bodies' => null]);
    }

    public function addMembership(string $bodyId, array $memberships): void
    {
        $this->membership_on_bodies = json_encode(
            array_merge(
                json_decode($this->membership_on_bodies ?: '{}', true),
                ['body' => $bodyId, 'function' => $memberships]
            )
        );
        $this->save();
    }

    public function getPartyColleagues(): ?EloquentCollection
    {
        return self::where('fk_party_id', $this->fk_party_id)
            ->where('legislature_id', $this->legislature_id)
            ->where('id', '!=', $this->id)
            ->get();
    }

    public function getPartyColleaguesExternalId(): Collection
    {
        return $this->getPartyColleagues()->pluck('external_id');
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
