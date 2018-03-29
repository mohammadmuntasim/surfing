<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AppointmentList extends Model
{
    protected $table = 'appointment_list';
    public $timestamps = false;


    function getBookedAppointment($userid){
    	$getlist=AppointmentList::where('doctor_id','=',$userid)->where('status','=',0)->get();
    	return $getlist;
    }
    function countBookingOnDate($userid,$bdate){
    	$getlist=AppointmentList::where('doctor_id','=',$userid)->where('booking_date','=',$bdate)->where('status','=',0)->get();
    	return $getlist;
    }

    function getDatabyAppointmentId($postid){
        $getlist=AppointmentList::where('id','=',$postid)->get();
        
        return $getlist;
    }
}
