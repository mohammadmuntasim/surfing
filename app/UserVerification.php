<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserVerification extends Model
{
    protected $table = 'user_verification';		
	protected $fillable = [
        'user_id','token', 'status',
    ];
}
