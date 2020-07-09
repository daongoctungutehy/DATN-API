<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillUser extends Model
{
    public $timestamps = true;
    public function product()
    {
        return $this->hasMany('App\Product');
    }  
    public function user()
    {
        return $this->hasOne('App\User1');
    }
}
