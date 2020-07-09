<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public function product()
    {
        return $this->hasOne('App\Product');
    }  
}
