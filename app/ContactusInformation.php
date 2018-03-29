<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContactusInformation extends Model
{
    	protected $table = 'contactus_information';		
	protected $fillable = [
         'name','email', 'phone','message',
    ];
}
