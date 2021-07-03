<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserInterfaceResource;

use App\User;


class AuthController extends Controller
{



    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:jwt', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'you are not mmeber...please register'], 401);
        }

        return $this->respondWithToken($token);
    }



    public function register()
    {
        request()->validate([

            'name' => 'required|min:2|max:50',
            'userName' => 'required|min:2|max:50',
            'gender' => 'required',
            'dateOfBirth' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $input = request()->except('password', 'image');

        $user = new User($input);
        $user->password = Hash::make(request()->password);

        $this->storeImage($user);

        $user->save();

        return $this->login(request());
    }





    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDetails()
    {

        return new UserResource(auth('api')->user());
    }


    public function userInterface()
    {

        return new UserInterfaceResource(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function update(User $user)
    {

        // $this->authorize('update', $offer);
        $user = auth('api')->user();
        $user->update(request()->validate([

            'name' => '',
            'userName' => '',
            'gender' => '',
            'dateOfBirth' => '',
            'email' => '',
        ]));

        $this->storeImage($user);

        return new UserResource(auth('api')->user());
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => new UserResource(auth('api')->user())
        ]);
    }


    public function storeImage($user = null)
    {
        if (is_null($user)) {
            $user = auth('api')->user();
        }

        // request()->validate([
        // 	'image' => 'required|file|image|max:2048',
        // ]);
        // //delete All image before  update
        // $allImage = Storage::disk('image_upload')->allFiles('user');
        // Storage::disk('image_upload')->delete($allImage);
        if (request()->has('image')) {
            $image = request()->image;

            // Storage::makeDirectory('user');

            // $image_name = time() .'_'. $image->getClientOriginalName() ;
            // $path = '/images/user' ;
            // $image->move( base_path() . '/public/images/user/' , $image_name);
            // Storage::disk('image_upload')->putFileAs(
            //     'user',
            //     $image,
            //     $image_name
            // );

            // $user->image = $path . '/' . $image_name;
            $user->image = $image;
            $user->save();
        }
    }
}
