<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
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
        'verification_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'phone_verified_at' => 'datetime',
    ];

    //relation
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function hasVerifiedPhone(): bool
    {
        return !is_null($this->phone_verified_at);
    }


    /**
     * Mark the given user's phone as verified.
     *
     * @return void
     */
    public function markPhoneAsVerified(): void
    {
        $this->forceFill([
            'phone_verified_at' => now(),
        ])->save();
    }

     /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendPhoneVerificationNotification(): void
    {
        $this->notify(new \App\Notifications\VerifyPhone);
    }


}
