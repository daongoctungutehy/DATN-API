<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackProduct extends Model
{
    public function user()
    {
        return $this->hasOne('App\User1');
    } 
    public function product()
    {
        return $this->hasOne('App\Product');
    } 
}
