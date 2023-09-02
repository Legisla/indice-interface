<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\Page
 *
 * @property int                             $id
 * @property string                          $uri
 * @property string                          $title
 * @property string                          $description
 * @property string                          $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $guarded = ['id'];

    protected $fillable = [
        'uri',
        'title',
        'description',
        'content',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getbyUri($uri)
    {
        return $this->where('uri', $uri)->first();
    }
}
