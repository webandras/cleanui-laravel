<?php

namespace Modules\Auth\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Actions\SocialCallback;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FacebookController extends Controller
{
    /**
     * @var string
     */
    private string $driver = 'facebook';

    /**
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function redirectToFacebook(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver($this->driver)->scopes('public_profile')->redirect();
    }


    /**
     * @param  SocialCallback  $socialCallback
     * @return Application|Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function handleCallback(SocialCallback $socialCallback): Application|Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $status = $socialCallback($this->driver);
        $callbackPage = Session::pull('callback_page');
        if ($status === true) {
            return redirect()->route('dashboard');
        }
        return redirect()->route($callbackPage ?? 'login');
    }
}
