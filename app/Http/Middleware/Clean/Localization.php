<?php

namespace App\Http\Middleware\Clean;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        session()->has('locale') ? $this->setLocale(true) : $this->setLocale(false);

        return $next($request);
    }


    /**
     * @param  bool  $localeInSession
     *
     * @return void
     */
    private function setLocale(bool $localeInSession): void
    {
        $user = auth()->user();
        if ($user && $user->preferences()->exists()) {
            // set language from user preferences
            App::setLocale($user->preferences->locale);
        } elseif ($localeInSession === true) {
            App::setLocale(session('locale'));
        }

        $locale       = App::getLocale();
        $localeString = $locale.'_'.strtoupper($locale).'.UTF-8';
        setlocale(LC_ALL, $localeString);
    }
}
