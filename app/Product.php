<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function ProductType()
    {
        return $this->hasOne('App\ProductType');
    } 
    public function image()
    {
        return $this->hasMany('App\ImageProduct');
    } 
}
