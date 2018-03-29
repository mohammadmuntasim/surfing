<?php

namespace App\Http\Controllers;
use DB;
use View;
use App\TimelinePost;
use App\TimelinePostLike;
use App\Http\Requests;
use File;
use Exception;
use Illuminate\Http\Request;
use DateTime;
use Auth;
use App\UserMetum;
use Response;
use Image;
use App\AppointmentList;
use App\Notification;
use App\User;
class HeaderController extends Controller
{

   
    /*Header function */
    public function headerAfterLogin($request)
    {
        
        $data['userdatabyid']=new User();
        $data['rolename']=new RoleController();
        if(Auth::check()){
        $userid=Auth::user()->id;
        //Notification
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($userid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($userid);
       //reminder start
        $data['appointmentReminder']=AppointmentList::where([['booking_date','>=', date('Y-m-d')],['doctor_id','=',$userid],['status','=',0]])->orwhere([['booking_date','>=', date('Y-m-d')],['patient_id','=',$userid],['status','=',0]])->orderBy('booking_date','ASC')->paginate(2);
        //reminder end
        
    }
        //search section start
        /**** search drop down ***/
        $data['searchdropdown']=$data['userdatabyid']->getSearchDropdownList();
        //search section end
        //If user login 
       
       
        

        
        return $data;
    }

}