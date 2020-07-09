<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User1 extends Model
{
    public function feedbackproduct()
    {
        return $this->hasMany('App\FeedbackProduct');
    } 
    public function bill()
    {
        return $this->hasMany('App\BillUser');
    } 
}
