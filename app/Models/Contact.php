<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\Contact
 *
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property bool   $read
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Contact extends BaseModel
{
    use HasFactory;

    protected $table = 'contacts';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
