<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function branches()
    {
        return $this->belongsToMany('App\Branch', 'branch_offers', 'offer_id', 'branch_id');
    }


    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review')->orderBy('updated_at');
    }

    public function copon()
    {
        return $this->hasMany('App\Copon');
    }

    public function usersCopons()
    {
        return $this->belongsToMany('App\User', 'copons', 'offer_id', 'user_id');
    }

    public function usersFavorite()
    {
        return $this->belongsToMany('App\User', 'favorites', 'offer_id', 'user_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
