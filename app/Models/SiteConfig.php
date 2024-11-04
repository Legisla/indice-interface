<?php

namespace App\Models;

use App\Enums\Configs;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\SiteConfig
 *
 * @property int    $id
 * @property string $key
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SiteConfig extends Model
{
    use HasFactory;

    protected $table = 'site_configs';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @param Config $key
     * @return string|null
     */
    public static function getByKey(Configs $key): ?string
    {
        return self::where('key', $key->value)->first()->value;
    }

    /**
     * @param Config $key
     * @param string $value
     * @return EloquentCollection|null
     */
    public static function getConfig(Configs $key): ?EloquentCollection
    {
        return self::where('key', $key->value)->first()->value;
    }

    /**
     * @param Config $key
     * @param string $value
     * @return void
     */
    public static function setConfigByKey(Configs $key, string $value): void
    {
        $config = self::where('key', $key->value)->first();
        $config->value = $value;
        $config->save();
    }

    public static function getNationalIndicators(): array
    {
        return [
            1 => [
                 1 => self::getByKey(Configs::NAT_IAVG_1),
                 2 => self::getByKey(Configs::NAT_IAVG_2),
                 3 => self::getByKey(Configs::NAT_IAVG_3),
                 4 => self::getByKey(Configs::NAT_IAVG_4),
                 5 => self::getByKey(Configs::NAT_IAVG_5),
                 6 => self::getByKey(Configs::NAT_IAVG_6),
                 7 => self::getByKey(Configs::NAT_IAVG_7),
                 8 => self::getByKey(Configs::NAT_IAVG_8),
                 9 => self::getByKey(Configs::NAT_IAVG_9) ,
            ],
            2 => [
                10 => self::getByKey(Configs::NAT_IAVG_10),
                11 => self::getByKey(Configs::NAT_IAVG_11),
                12 => self::getByKey(Configs::NAT_IAVG_12),
                13 => self::getByKey(Configs::NAT_IAVG_13),
            ],
            3 => [
                14 => self::getByKey(Configs::NAT_IAVG_14),
                15 => self::getByKey(Configs::NAT_IAVG_15),
                16 => self::getByKey(Configs::NAT_IAVG_16),
            ],
            4 => [
                17 => self::getByKey(Configs::NAT_IAVG_17),
            ],
        ];
    }


}
