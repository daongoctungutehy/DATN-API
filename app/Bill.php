<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public $timestamps = true;
    public function product()
    {
        return $this->hasOne('App\Product');
    }  
    public function user()
    {
        return $this->hasOne('App\BillUser');
    }
}
