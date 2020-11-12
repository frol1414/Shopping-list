<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\API\AuthSuccessResource;
use App\Http\Resources\API\Errors\AuthFailResource;
use App\Http\Resources\API\Errors\RefreshTokenFailResource;
use App\Http\Resources\API\System\LogoutSuccessResource;
use App\Http\Resources\API\UserResource;
use App\Models\Public1\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

//    use AuthenticatesUsers;

    /**
     * @param RegisterRequest $request
     * @return AuthSuccessResource
     */
    public function register(RegisterRequest $request)
    {
//        dd($request->input('state.list.lists'));
//        $request->input('state.list.lists');
        //        $comment = new Lists(['title' => 'pidr', 'slug' => Str::random(15)]);
//        $user->lists()->save($comment);

//        dd($user);
        /*$list = Lists::insert(
            $request->input('state.list.lists')
        );*/

//        dd($request->all());
        (new UserController())->userCreate($request->input('state.list.lists'),
            $request->input('state.product.products'),
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

//        $token = auth()->guard()->login($user);

        return new AuthSuccessResource(['token' => null]);
    }

    /**
     * @param Request $request
     * @return AuthSuccessResource|AuthFailResource
     */
    public function login(Request $request)
    {
        $login = $request->input('email');

        $field_login = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

//        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt([$field_login => $login, 'password' => $request->input('password')])) {
            return new AuthSuccessResource(['token' => $token]);
        }

        return new AuthFailResource(null);
    }

    /**
     * @return LogoutSuccessResource
     */
    public function logout()
    {
        $this->guard()->logout();

        return new LogoutSuccessResource(null);
    }

    /**
     * @return UserResource
     */
    public function user()
    {
        $user = User::find(Auth::id());

        return new UserResource($user);
    }

    /**
     * @return AuthSuccessResource|RefreshTokenFailResource
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {

            return new AuthSuccessResource(['token' => $token]);
        }

        return new RefreshTokenFailResource(null);
    }

    /**
     * @return Guard|StatefulGuard
     */
    private function guard()
    {
        return Auth::guard();
    }

}
