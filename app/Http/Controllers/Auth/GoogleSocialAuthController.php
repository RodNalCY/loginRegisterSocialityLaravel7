<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;

use Laravel\Socialite\Facades\Socialite;
use App\User;


class GoogleSocialAuthController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver)
    {

        try {

            $user = Socialite::driver($driver)->user();

            $create = User::firstOrCreate([
                'email' => $user->getEmail()
            ], [
                'provider' => $driver,
                'provider_id' => $user->getId(),
                'name' => $user->getName(),
                'avatar' => $user->getAvatar(),
                'email_verified_at' => now()
            ]);

            auth()->login($create, true);
            return redirect($this->redirectPath());
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }


}
