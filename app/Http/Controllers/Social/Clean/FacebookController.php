<?php

namespace App\Http\Controllers\Social\Clean;

use App\Http\Controllers\Controller;
use App\Interface\Services\Clean\SocialServiceInterface;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FacebookController extends Controller
{
    /**
     * @var string
     */
    private string $driver = 'facebook';


    /**
     * @var SocialServiceInterface
     */
    private SocialServiceInterface $socialService;


    /**
     * @param  SocialServiceInterface  $socialService
     */
    public function __construct(SocialServiceInterface $socialService)
    {
        $this->socialService = $socialService;
    }


    /**
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function redirectToFacebook(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver($this->driver)->scopes('public_profile')->redirect();
    }


    /**
     * @return Application|Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function handleCallback(): Application|Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $status = $this->socialService->socialCallback($this->driver);
        $callbackPage = Session::pull('callback_page');
        if ($status === true) {
            return redirect()->route('dashboard');
        }
        return redirect()->route($callbackPage ?? 'login');
    }
}
