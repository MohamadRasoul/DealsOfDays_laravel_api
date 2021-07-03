<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'API'], function ($router) {

    //User
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::POST('login', 'AuthController@login');
        Route::POST('storeImage', 'AuthController@storeImage');
        Route::POST('register', 'AuthController@register');
        Route::POST('logout', 'AuthController@logout');
        Route::POST('refresh', 'AuthController@refresh');
        Route::POST('update', 'AuthController@update');
        Route::Get('userDetails', 'AuthController@userDetails');
        Route::Get('userInterface', 'AuthController@userInterface');
    });

    //Category
    Route::apiResource('category', 'CategoryController');
    Route::GET('paginate/category', 'CategoryController@indexWithPaginate')->name('category.indexWithPaginate');
    Route::GET('category/{category}/offer', 'CategoryController@indexOfferToThisCategory')->name('category.indexOfferToThisCategory');

    //Company
    Route::apiResource('company', 'CompanyController')->except('destroy', 'update');
    Route::GET('paginate/company', 'CompanyController@indexWithPaginate')->name('company.indexWithPaginate');
    Route::GET('user/company', 'CompanyController@indexUserCompany')->name('company.indexUserCompany');
    Route::POST('edite/company/{company}', 'CompanyController@update')->name('company.edite');
    Route::POST('delete/company/{company}', 'CompanyController@destroy')->name('company.delete');


    //Branch
    Route::apiResource('branch', 'BranchController')->except('store', 'destroy', 'update');
    Route::POST('{companyId}/branch', 'BranchController@store')->name('branch.store');
    Route::POST('edite/branch/{branch}', 'BranchController@update')->name('branch.edite');
    Route::POST('delete/branch/{branch}', 'BranchController@destroy')->name('branch.delete');

    //Offer
    Route::apiResource('offer', 'OfferController')->except('store', 'destroy', 'update');
    Route::POST('{branch}/offer', 'OfferController@store')->name('offer.store');
    Route::POST('edite/offer/{offer}', 'OfferController@update')->name('offer.edite');
    Route::POST('delete/offer/{offer}', 'OfferController@destroy')->name('offer.delete');

    Route::GET('{company}/company/offer', 'OfferController@indexCompanyOffer')->name('CompanyOffer.index');
    Route::GET('userFollow/offer', 'OfferController@indexOfferForFollowCompany')->name('indexOfferForFollowCompany.index');
    Route::GET('{branch}/branch/offer', 'OfferController@indexBranchOffer')->name('BranchOffer.index');
    Route::GET('proirity/offer', 'OfferController@indexProirityOffer')->name('proirityOffer.index');
    Route::GET('trendingNow/offer', 'OfferController@indexTrendingNowOffer')->name('trendingNowOffer.index');
    Route::GET('endingSoon/offer', 'OfferController@indexEndingSoonOffer')->name('endingSoonOffer.index');
    Route::GET('latest/offer', 'OfferController@indexLatestOffer')->name('latestOffer.index');
    Route::GET('nearest/offer', 'OfferController@indexNearestOffer')->name('nearestOffer.index');


    //Copon
    Route::apiResource('copon', 'CoponController')->except('store', 'index', 'destroy', 'update');
    Route::GET('copon', 'CoponController@indexOffer')->name('favorite.indexOffer');
    Route::POST('{offerId}/copon', 'CoponController@store')->name('copon.store');
    Route::PUT('copon-active/{copon}', 'CoponController@updateActive')->name('copon.updateActive');



    //Review
    Route::apiResource('review', 'ReviewController')->except('store', 'destroy', 'update');
    Route::GET('{offerId}/review', 'ReviewController@indexReviewOffer')->name('review.indexReviewOffer');
    Route::POST('{offerId}/review', 'ReviewController@store')->name('review.store');
    Route::POST('edite/review/{review}', 'ReviewController@update')->name('review.edite');
    Route::POST('delete/review/{review}', 'ReviewController@destroy')->name('review.delete');


    //Favorite
    Route::GET('favorite', 'FavoriteController@index')->name('favorite.index');
    Route::POST('favorite/{offer}', 'FavoriteController@store')->name('favorite.store');
    Route::POST('delete/favorite/{offer}', 'FavoriteController@destroy')->name('favorite.destroy');

    //Follow
    Route::GET('follow', 'FollowController@index')->name('follow.index');
    Route::POST('follow/{branch}', 'FollowController@store')->name('follow.store');
    Route::POST('delete/follow/{branch}', 'FollowController@destroy')->name('follow.destroy');
});
