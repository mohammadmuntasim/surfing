<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AppointmentSetting extends Model
{
    
    protected $table = 'appointment_setting';
    public $timestamps = false;

    function getAvailability($uid)
    {
    	$myAvailiablity = AppointmentSetting::where('user_id','=',$uid)->get();

    	return $myAvailiablity;
    }

    function getTimeAvailability($uid,$dayname)
    {
    	$myAvailiablity = AppointmentSetting::where('user_id','=',$uid)->where('opening_days','=',$dayname)->get();

    	return $myAvailiablity;
    }
}
