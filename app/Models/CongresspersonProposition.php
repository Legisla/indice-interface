<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class CongresspersonProposition extends Model
{

    protected $table = 'congressperson_proposition';
    public static function purge(): void
    {
        self::query()->delete();
    }
}
