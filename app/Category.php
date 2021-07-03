<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $guarded = [];

    public function Offers()
    {
        return $this->hasMany('App\Offer');
    }
}
