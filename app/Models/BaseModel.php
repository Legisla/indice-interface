<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class BaseModel extends Model
{

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::where('id', $id)->first();
    }

    /**
     * @return $this
     * @throws Throwable
     */
    public function saveFluent()
    {
        $this->saveOrFail();

        return $this;
    }

}
