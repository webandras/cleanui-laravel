<?php

namespace Modules\Social\Servives;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Models\User;
use Modules\Social\Interfaces\Services\SocialServiceInterface;

class SocialService implements SocialServiceInterface
{
    /**
     * @param string $driver
     * @return bool
     */
    public function socialCallback(string $driver): bool
    {
        try {
            $user = Socialite::driver($driver)->user();
            $isUser = User::where('social_id', $user->id)->first();

            if (isset($isUser)) {
                Auth::login($isUser);
                return true;
            } else {
                // If the user with the same email exists in the table
                $userToLogin = User::whereNull('social_id')->where('email', $user->email)->first();
                if ($userToLogin) {
                    $userToLogin->update([
                        'social_id' => $user->id,
                        'social_type' => $driver,
                    ]);

                } else {
                    $userToLogin = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'social_id' => $user->id,
                        'social_type' => $driver,
                        'password' => bcrypt($user->getName() . '@' . $user->getId()),
                        'role_id' => 2,
                    ]);
                }


                Auth::login($userToLogin);
                return true;
            }
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            Session::flash('login_error', __('There was an error during authentication. Please try again.'));
            return false;
        }
    }

}
