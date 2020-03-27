<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\User;

class GitHubSocialAuthController extends Controller
{
    public function redirectToProvider($provider){

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider){


        try {

            $user = Socialite::driver($provider)->user();

            $authUser = User::firstOrNew(['email'=>$user->email]);
            $authUser->name = $user->nickname;
            $authUser->email = $user->email;
            $authUser->provider = $provider;
            $authUser->avatar = $user->avatar;

            auth()->login($authUser, true);
            return redirect($this->redirectPath());
        } catch (\Exception $e) {
            return redirect()->route('login');
        }



    }
}
