<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = ['name', 'userName', 'gender', 'dateOfBirth', 'email', 'password'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime' ];

    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function offersCopons()
    {
        return $this->belongsToMany('App\Offer', 'copons', 'user_id', 'offer_id')->withPivot('copon', 'active');
    }

    public function offersFavorite()
    {
        return $this->belongsToMany('App\Offer', 'favorites', 'user_id', 'offer_id');
    }

    public function branchsFollow()
    {
        return $this->belongsToMany('App\Branch', 'follows', 'user_id', 'branch_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
