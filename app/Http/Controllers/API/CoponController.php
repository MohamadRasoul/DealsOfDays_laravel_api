<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Copon;
use App\Offer;
use App\Http\Resources\CoponResource;
use App\Http\Resources\CoponOfferResource;


class CoponController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOffer()
    {
        $user = auth('api')->user();
        $offers = $user->offersCopons()->paginate(10);
		$collection = $offers->getCollection();

		return CoponOfferResource::collection($collection);
    }

    /**
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$offerId)
    {
        $user = auth('api')->user();
        $copon = new Copon();
        
        $offer = Offer::where('id', $offerId)->firstOrFail();

        if(is_null($offer->copon) )
        {
            $copon->copon = null;
            
        }else if($offer->copon == -1 || $offer->copon < 0)
        {
            $copon->copon = $this->generateCopon();
            
        }else
        {
            $copon->copon = $offer->copon;
        }
        
        $copon->offer_id = $offer->id;
        $copon->active = 1;

        $copon->user_id = $user->id;

        try {
            $copon->save();
            return $this->show($copon);

        } catch (\Throwable $th) {

            $copon = Copon::whereOffer_id($offerId)->whereUser_id($user->id)->firstOrFail();
            return $this->show($copon);
        }
    }

    /**
     * Display the specified resource.nn
     *
     * @param  \App\Copon  $copon
     * @return \Illuminate\Http\Response
     */
    public function show(Copon $copon)
    {
        return new CoponResource($copon);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Copon  $copon
     * @return \Illuminate\Http\Response
     */
    public function updateActive(Request $request, Copon $copon)
    {

        if($copon->active)
        {
            $copon->active = false;
            $copon->save();
            return response()->json('the copon ('. $copon->copon . ') has been not active');
            
        } else 
        {
            return response()->json('the copon ('. $copon->copon . ') already has been not active');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Copon  $copon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Copon $copon)
    {
        $copon->delete();
    }

    private function generateCopon()
	{
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 6; $i++) 
		{
			$res .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		return $res;
	} 


}
