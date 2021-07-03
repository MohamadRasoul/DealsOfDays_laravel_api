<?php

namespace App\Http\Controllers\API;

use App\Events\ShowOffer;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProirityOfferResource;
use App\Http\Resources\HomeOfferResource;
use App\Image;
use App\Offer;
use App\Company;
use App\Branch;
use App\BranchOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OfferController extends Controller
{
	/*
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */



	public function __construct()
	{
		$this->middleware(
			'auth:api',
			[
				'except' =>
				['index', 'show', 'indexProirityOffer', 'indexBranchOffer', 'indexTrendingNowOffer', 'indexCompanyOffer', 'indexEndingSoonOffer', 'indexLatestOffer', '']
			]
		);
	}

	/*
	 * Display a listing of the resource.
	 *['except' => ['index', 'show']]
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$offers = Offer::orderBy('startDate')->paginate(5);
		$collection = $offers->getCollection();
		return HomeOfferResource::collection($collection)->additional(['lastPage' => $offers->lastPage()]);
	}


	public function indexProirityOffer()
	{
		$offers =
			Offer::whereProirity('1')
			->whereDate('endDate', '>=', Carbon::today()->toDateString())
			->whereDate('startDate', '<=', Carbon::today()->toDateString())
			->inRandomOrder()
			->paginate(4);
		$collection = $offers->getCollection();
		return ProirityOfferResource::collection($collection);
	}


	public function indexTrendingNowOffer()
	{
		$offers =
			Offer::whereDate('endDate', '>=', Carbon::today()->toDateString())
			->whereDate('startDate', '<=', Carbon::today()->toDateString())
			->OrderBy('views', 'DESC')
			->Paginate(5);
		$collection = $offers->getCollection();
		return HomeOfferResource::collection($collection);
	}


	public function indexEndingSoonOffer()
	{
		$offers =
			Offer::whereDate('endDate', '>=', Carbon::today()->toDateString())
			->OrderBy('endDate')
			->whereDate('startDate', '<=', Carbon::today()->toDateString())
			->OrderBy('startDate')
			->Paginate(5);
		$collection = $offers->getCollection();
		return HomeOfferResource::collection($collection);
	}


	public function indexLatestOffer()
	{
		$offers = Offer::whereDate('endDate', '>=', Carbon::today()->toDateString())
			->whereDate('startDate', '<=', Carbon::today()->toDateString())
			->OrderBy('endDate')
			->Paginate(5);
		$collection = $offers->getCollection();
		return HomeOfferResource::collection($collection);
	}


	public function indexCompanyOffer(Company $company)
	{
		$offers = collect();
		foreach ($company->branches as $branch) {
			$offers = $offers->merge($branch->offers)->unique('id');
		}
		$offers = $offers->where('endDate', '>=', Carbon::today()->toDateString())
			->where('startDate', '<=', Carbon::today()->toDateString())
			->sortBy('startDate');

		$paginated = $this->paginate($offers, $perPage = 5, $page = null, $options = [])->each(function ($item, $key) {
			if ($key == 'data')
				return  $item;
		});
		return HomeOfferResource::collection($paginated);
	}

	public function indexBranchOffer(Branch $branch)
	{
		$offers = $branch->offers
			// ->where('endDate', '>=' ,Carbon::today()->toDateString())
			// ->where('startDate', '<=' ,Carbon::today()->toDateString())
			->sortBy('updated_at');
		$paginated = $this->paginate($offers, $perPage = 5, $page = null, $options = [])->each(function ($item, $key) {
			if ($key == 'data')
				return  $item;
		});

		return HomeOfferResource::collection($paginated);
	}


	public function indexNearestOffer()
	{
		// dd(request()->late);
		$latitude = request()->late;
		$longitude = request()->long;
		$Branches = Branch::selectRaw('*, ( 6367 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) AS distance')
			->having('distance', '<', 2)
			->orderBy('distance')
			->get();
		$offers = collect();

		foreach ($Branches as $branch) {
			$offers = $offers->merge($branch->offers)->unique('id');
		}
		$paginated = $this->paginate($offers, $perPage = 5, $page = null, $options = [])->each(function ($item, $key) {
			if ($key == 'data')
				return  $item;
		});
		return HomeOfferResource::collection($paginated);
	}

	public function indexOfferForFollowCompany()
	{
		$user = auth('api')->user();

		$branchesFollow = $user->branchsFollow;

		$offers = collect();
		foreach ($branchesFollow as $branch) {
			$offers = $offers->merge($branch->offers)->unique('id');
		}
		$paginated = $this->paginate($offers, $perPage = 5, $page = null, $options = [])->each(function ($item, $key) {
			if ($key == 'data')
				return  $item;
		});
		return HomeOfferResource::collection($paginated);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param $branchId
	 * @return void
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function store(Request $request, Branch $branch)
	{
		$user = auth('api')->user();
		$this->authorize('create', [Offer::class, $branch->id]);

		$data = $this->dataValidate($branch->id);

		$offer = Offer::create($data);
		if ($data['allBranches']) {
			foreach ($branch->company->branches as $branch) {
				BranchOffer::create([
					'branch_id' => $branch->id,
					'offer_id'  => $offer->id,
				]);
			}
		} else {
			BranchOffer::create([
				'branch_id' => $branch->id,
				'offer_id'  => $offer->id,
			]);
		}
		$this->storeImage($offer);
		return new OfferResource($offer);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Offer $offer
	 * @return OfferResource
	 */
	public function show(Offer $offer)
	{
		event(new ShowOffer($offer));
		return new OfferResource($offer);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Offer $offer
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function update(Request $request, Offer $offer)
	{

		$this->authorize('update', $offer);

		$offer->update($this->dataValidate());

		$this->storeImage($offer);

		return;
	}

	/**
	 * @param  \App\Offer $offer
	 * Remove the specified resource from storage.
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function destroy(Offer $offer)
	{
		$images = array();
		foreach ($offer->images as $image) {
			$images[] = $image->offer_image_path;
		}
		$this->authorize('delete', $offer);
		Storage::disk('image_upload')->deleteDirectory('offer/' . $offer->id);

		$offer->delete();
		return $images;
	}

	private function dataValidate($branchId = null)
	{
		$user = auth('api')->user();

		$data = request()->validate([
			'offer'           => '',
			'descreption'     => '',
			'offerPrecentage' => '',
			'oldPrice'        => '',
			'startDate'       => '',
			'endDate'         => '',
			'url'            =>  '',
			'isOnline'        => '',
			'copon'           => '',
			'curency'          => '',
			'allBranches'     => '',
			'proirity'        => '',
			'category_id'     => ''
		]);

		if (!is_null($branchId)) {
			$data['user_id'] = $user->id;
		}
		return $data;
	}



	private function storeImage($offer)
	{
		// 	request()->validate([
		// 		'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		// 	]);
		// 	//delete All image before  update
		// 	$allImage = Storage::disk('image_upload')->allFiles('offer/' . $offer->id);
		// 	Storage::disk('image_upload')->delete($allImage);
		if (request()->has('images')) {

			foreach (request()->images as $image) {

				// 			Storage::disk('image_upload')->makeDirectory('offer/' . $offer->id);

				// 			$image_name = time() .'_'. $image->getClientOriginalName() ;
				// 			$path = '/images/offer/' . $offer->id ;

				// 			Storage::disk('image_upload')->putFileAs(
				// 				'offer/' . $offer->id,
				// 				$image,
				// 				$image_name
				// 			);

				Image::create([
					'offer_image_path' => $image,
					'offer_id' => $offer->id
				]);
			}
		}
	}


	public function paginate($items, $perPage = 15, $page = null, $options = [])
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

		$items = $items instanceof Collection ? $items : Collection::make($items);

		return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}
}
