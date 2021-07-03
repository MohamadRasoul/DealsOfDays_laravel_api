<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $guarded = [];
    
    public function branches()
    {
        return $this->hasMany('App\Branch');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
