<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller ;
use Illuminate\Http\Request;
use App\Http\Resources\BranchResource;
use App\Follow;
use App\Branch;


class FollowController extends Controller
{
	
	public function __construct()
	{
		$this->middleware('auth:api');
	}


	public function index(){
		$user = auth('api')->user();
		$branches = $user->branchsFollow()->paginate(10);
		$collection = $branches->getCollection();
		return BranchResource::collection($collection);
	}




	public function store(Request $request, Branch $branch)
	{
		$user = auth('api')->user();

		$follow = Follow::create([
			'user_id'  => $user->id,
			'branch_id'  => $branch->id,
		]);
		return response()->json('This branch Is Add To Your Follow');


	}

	public function destroy( Branch $branch)
	{
		$user = auth('api')->user();

		$follow = Follow::where('user_id' , $user->id)->where('branch_id', $branch->id)->firstOrFail();
		$follow->delete();

		return response()->json('Your branch Is deleted From Your Follow');


	}
}
