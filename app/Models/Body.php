<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int    $id
 * @property int    $external_id
 * @property string $members
 * @property bool   $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Body extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'external_id',
        'name',
        'members',
        'active',
    ];


    public static function setAllInactive()
    {
        self::query()->update(['active' => false]);
    }

    public static function updateOrCreateByExternalId($externalId, $name, $members): void
    {
        $body = self::where('external_id', $externalId)->first();

        if (!$body) {
            $body = self::create([
                'external_id' => $externalId,
                'members' => $members,
                'name' => $name,
            ]);
        }
        $body->update([
            'name' => $name,
            'members' => $members,
            'active' => true,
        ]);
    }

    public static function getNotEmptyMembers()
    {
        return self::where('members', '!=', '[]')->get();
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
