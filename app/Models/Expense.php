<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $fk_congressperson_id
 * @property float $value
 * @property int $month
 * @property int $year
 * @property bool $closed
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_congressperson_id',
        'value',
        'month',
        'year',
        'closed',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function congressperson()
    {
        return $this->belongsTo(Congressperson::class);
    }

    public static function getLastOpenByCongresspersonId(Congressperson $congressperson)
    {
        return self::where('fk_congressperson_id', $congressperson->id)
            ->where('closed', false)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->first();
    }

    public static function creatOrUpdateByMonthAndCongressperson(
        Congressperson $congressperson,
        int $year,
        int $month,
        float $value
    )
    {
        $expense = self::where('fk_congressperson_id', $congressperson->id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if (!$expense) {
            $expense = new Expense();
            $expense->fk_congressperson_id = $congressperson->id;
            $expense->year = $year;
            $expense->month = $month;
        }

        $expense->value = $value;
        $expense->closed = false;
        $expense->save();
    }


    public static function getTotalExpenditureByCongressperson(Congressperson $congressperson)
    {
        return self::where('fk_congressperson_id', $congressperson->id)
            ->sum('value');
    }

    public static function purge(): void
    {
        self::query()->delete();
    }
}
