<?php

namespace Modules\Auth\Controllers\Social;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Actions\SocialCallback;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GoogleController extends Controller
{
    /**
     * @var string
     */
    private string $driver = 'google';


    /**
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        // redirect user to "login with Google account" page
        return Socialite::driver($this->driver)->redirect();
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
