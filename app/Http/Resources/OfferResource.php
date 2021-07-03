<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{


	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		//	    return parent::toArray($request);
		$offerBranch  =  $this->branches()->first();
		$offerCompany =  $offerBranch->company;
		$branches = $this->branches;
		$branchLocation = BranchLocationResource::collection($branches);
		// if(is_a($branch, 'Illuminate\Database\Eloquent\Collection')) {
		// 	$branchLocation = BranchLocationResource::collection($branch);
		// } else {
		// 	$branchLocation[] = new BranchLocationResource($branch);
		// }
		$images = array();
		if ($this->has('images')) {
			foreach ($this->images as $image) {
				$images[] = $image->offer_image_path;
			}
		}

		$arrayData = [
			'id'              =>  $this->id,
			'offer'           =>  $this->offer,
			'endDate'         =>  $this->endDate,
			'descreption'     =>  $this->descreption,
			'offerPrecentage' =>  $this->offerPrecentage,
			'oldPrice'        =>  $this->oldPrice,
			'startDate'       =>  $this->startDate,
			'allBranches'     =>  $this->allBranches,

			'rating'          =>  $this->rating,
			'coupon'          =>  $this->copon,
			'curency'         =>  $this->curency,
			'isLiked'         =>  $this->isLiked(),
			'isOnline'        =>  $this->isOnline,
			'url'             =>  $this->when(($this->isOnline == true), function () {
				return 'url';
			}),

			'location'        => $this->when(($this->isOnline == false), $branchLocation),


			'category'        =>  new CategoryResource($this->category),

			'images'          =>  $images,
			'companyName'     =>  $offerCompany->name,
			'companyImage'    =>  $offerCompany->image,
			'companyId'       =>  $offerCompany->id,
			'reviews'         =>  ReviewResource::collection($this->reviews->sortByDesc('updated_at')->take(2)),
			'myOffer'         =>  $this->myOffer()
		];


		if ($this->allBranches) {
			$arrayData['branchName'] = 'All Branches';
		} else {
			$arrayData['branchName'] = $offerBranch->name;
		};

		return $arrayData;
	}


	public function isLiked()
	{

		$user = auth('api')->user();

		if (is_null($user)) {
			return false;
		} else {
			if (is_null($user->offersFavorite->find($this->id))) {
				return false;
			} else {
				return true;
			}
		}
	}

	public function myOffer()
	{

		$user = auth('api')->user();
		if (is_null($user)) {
			return false;
		} else {
			if ($user->id == $this->user_id) {
				return true;
			} else {
				return false;
			}
		}
	}
}
