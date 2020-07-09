<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public function product()
    {
        return $this->hasOne('App\Product');
    }
}
