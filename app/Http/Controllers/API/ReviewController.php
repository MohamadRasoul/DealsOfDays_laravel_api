<?php

namespace App\Http\Controllers\API;

use App\Events\OfferHasReview;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Review;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Nullable;

class ReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' =>  ['indexReviewOffer', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexReviewOffer($offerId)
    {
        $reviews = Review::whereOffer_id($offerId)->orderBy('updated_at', 'desc')->paginate(10);
        $collection = $reviews->getCollection();
        return ReviewResource::collection($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $offerId)
    {

        try {
            Review::create($this->dataValidate($offerId));
            Event(new OfferHasReview($offerId));
            return response()->json('Your review Is Add');
        } catch (\Throwable $th) {
            $user = auth('api')->user();
            $myReview = Review::whereOffer_id($offerId)->whereUser_id($user->id)->firstOrFail();
            $this->update($myReview);
        }



        // $user = auth('api')->user();
        // $myReview = Review::where([
        //     ['user_id','=', $user],
        //     ['offer_id','=',$offerId]
        // ])->firstOrFail();
        // dd($myReview);
        // if(is_null($myReview))
        // {
        //     Review::create($this->dataValidate($offerId));
        //     Event(new OfferHasReview($offerId));
        //     return response()->json('Your review Is Add');
        // }
        // else
        // {
        //     $this->update($myReview);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        ReviewResource::withoutWrapping();
        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Review $review)
    {
        $review->update($this->dataValidate());
        Event(new OfferHasReview($review->offer_id));

        return response()->json('Your review Is Edite');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review $review
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Review $review)
    {
        $review->delete();
        Event(new OfferHasReview($review->offer_id));

        return response()->json('Your review Is deleted');
    }






    private function dataValidate($offerId = null)
    {
        $user = auth('api')->user();

        $data =  request()->validate([
            'rating'      =>  '',
            'description' =>  '',
        ]);

        if (!is_null($offerId)) {
            $data['offer_id'] = $offerId;
        }

        $data['user_id'] = $user->id;
        return $data;
    }
}
