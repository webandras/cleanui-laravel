<?php

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;


    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  Request  $request
     * @return Factory|View
     */
    public function showResetForm(Request $request): Factory|View
    {
        $token = $request->route()->parameter('token');

        return view('public.pages.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
