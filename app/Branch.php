<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $guarded = [];


    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function offers()
    {
        return $this->belongsToMany('App\Offer', 'branch_offers', 'branch_id', 'offer_id');

    }

    public function usersFollow()
    {
        return $this->belongsToMany('App\User', 'follows', 'branch_id', 'user_id');
    }
	public function user()
	{
		return $this->belongsTo('App\User');
	}

}
