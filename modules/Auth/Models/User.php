<?php

namespace Modules\Auth\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Database\Factories\UserFactory;
use Modules\Auth\Mail\SendCodeMail;
use Modules\Auth\Traits\HasPreferences;
use Modules\Auth\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions, HasPreferences;

    public const RECORDS_PER_PAGE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'enable_2fa',
        'social_id',
        'social_type',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }


    /**
     * Creates a 2FA code for the user
     * @return void
     */
    public function generateCode(): void
    {
        $code = rand(100000, 999999);

        UserCode::updateOrCreate(
            ['user_id' => auth()->id()],
            ['code' => $code]
        );

        try {
            $details = [
                'title' => __('Login code'),
                'code' => $code,
            ];

            // Send the code in email
            Mail::to(auth()->user()->email)->send(new SendCodeMail($details));


        } catch (\Exception $e) {
            Log::info("Error: ".$e->getMessage());
            exit;
        }
    }


    public function scopeGetPaginatedUsersWithRoles($query)
    {
        return $query->orderBy('created_at', 'DESC')
            ->with('role')
            ->paginate(User::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    /**
     * @param  array  $data
     * @return Model
     */
    public function updatePreferences(array $data): Model
    {
        return $this->preferences()->updateOrCreate(['user_id' => $this->id], $data);
    }

    /**
     * @return bool
     */
    public function hasPreferences(): bool
    {
        return array_key_exists('Modules\Auth\Traits\HasPreferences', class_uses_recursive(User::class));
    }

}
