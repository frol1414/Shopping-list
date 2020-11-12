<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocialRegisterRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Image;
use Socialite;

class LoginController extends Controller
{

    /**
     * @param SocialRegisterRequest $request
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider(SocialRegisterRequest $request, $provider)
    {
        //save request in session
//        dd($request->session());
        if ($request->input('state')) {
            session(['states' => $request->input('state')]);
//            cookie('state', serialize($request->input('state')), 5);
//            dd($request->cookie());
//            Cache::store('file')->put('state', serialize($request->input('state')), 300);
        }


//        return Socialite::with($provider)->stateless()->redirect()->getTargetUrl();
        return Socialite::with($provider)->redirect()->getTargetUrl();
    }

    /**
     * @param Request $request
     * @param $provider
     * @return Application|Factory|View|string
     */
    public function handleProviderCallback(Request $request, $provider)
    {
//        dd(1);
//        dd($request->session());
//        if($request->session()->has('state')) {
//        $state = unserialize(Cookie::get('state'));
//        $state = unserialize(Cache::get('state'));
//        dd($state);
        if ($request->session()->has('states')) {
//            dd(1);
//            if ($provider == 'vkontakte') {
//                $getInfo = Socialite::driver($provider)->fields(['email', 'first_name', 'last_name', 'photo_max_orig'])->user();
//            } elseif ($provider == 'facebook') {
//                $getInfo = Socialite::driver($provider)->fields(['email', 'first_name', 'last_name'])->user();
//            } else {
                $getInfo = Socialite::driver($provider)->user();
//                dd($getInfo);
//                $getInfo = Socialite::driver($provider)->stateless()->user();
//            }

//            File::append('logs/social_new.txt', "--------" . now() . "---------\r\n" . $provider . ' - ' . json_encode($getInfo) . "\r\n");
//            $social_id = $getInfo->getId();
            $fullName = explode(" ", $getInfo->getName());
//            dd($fullName[0]);
            $user = (new UserController())->getUserSocial($getInfo->getId(), $provider);
            $state = $request->session()->pull('states');
            if (!$user) {
                $user = (new UserController())->userCreate(
                    $state['list']['lists'],
                    $state['product']['products'],
                    $fullName[0],
                    Str::random(10) . '@test.test',
                    null,
                    true,
                    $getInfo,
                    $provider
                );
            }

            $token = auth()->login($user);
//            dd(env('MIX_APP_URL'));
            return view('callback', [
                'token' => $token,
            ]);
        } else {
            return 'error';
        }
    }


}
