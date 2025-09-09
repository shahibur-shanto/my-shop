<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'provider',
        'provider_id',
        'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
