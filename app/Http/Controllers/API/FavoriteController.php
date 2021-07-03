<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Offer;
use App\Http\Resources\FOfferResource;
use App\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{


	public function __construct()
	{
		$this->middleware('auth:api');
	}


	public function index(){
		$user = auth('api')->user();
		$offers = $user->offersFavorite()->paginate(5);
		$collection = $offers->getCollection();
		return FOfferResource::collection($collection);
	}



	public function store(Request $request, Offer $offer)
	{
		$user = auth('api')->user();

		$favorite = Favorite::create([
			'user_id'  => $user->id,
			'offer_id'  => $offer->id,
		]);
		return response()->json('This Offer Is Add To Your Favorite');


	}

	public function destroy(Offer $offer)
	{
		$user = auth('api')->user();

		$favorite = Favorite::where('user_id' , $user->id)->where('offer_id', $offer->id)->firstOrFail();
		
		$favorite->delete();
		return response()->json('the Offer Is deleted From Your Favorite');
		
		


	}
}
