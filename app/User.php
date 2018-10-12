<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'avatar', 'channel_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'expires_at'
    ];

    public static function findOrCreate($data)
    {
        $user = User::where('channel_id', '=', $data['channel_id'])->first();

        if (!$user) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->avatar = $data['avatar'];
            $user->channel_id = $data['channel_id'];
            $user->save();
        } 

        if (isset($data['access_token'])) {
            $user->access_token = $data['access_token'];
            $user->expires_at = time() + $data['expires_at'];
            $user->save();
        }

        return $user;
    }

    public function getDateFormat() {
        return 'Y-m-d H:i:s';
    }
}
