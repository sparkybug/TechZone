<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
// use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Notifications\VerifyEmailNotification;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    // override the method to specify my custom primary key name
    public function getKey()
    {
        return 'user_id';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',

        'firstname',
        'lastname',
        'email',
        'password',
        // 'verification_token',
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

    // for email verification
    public function sendEmailVerificationNotification()
    {
        $this->verification_token = Str::random(60);

        $this->notify(new VerifyEmailNotification($this->verification_token));

        $this->save();
    }

    public function savedJobs()
    {
        return $this->belongsToMany(Jobs::class, 'saved_jobs')->withTimestamps();
    }
}
