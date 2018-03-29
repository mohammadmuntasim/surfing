<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\User;
use Auth;
use File;
use App\UserMetum;
use App\UserMedia;
use DB;
use App\UserFollow;
use App\AppointmentList;
use Mail;
use Response;
use App\Notification;
class ShowCalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');         
    }
    public function getBookings(Request $request)
    {
       $data['userdatabyid']=new User(); 
       $data['getavailablle']=new AppointmentSetting();
       $data['getlist']=new AppointmentList();
       $data['encrypt']=new EndecryptController();
       $userid=Auth::user()->id;
       $showdate=array();
       $days='';
       $bn=array();
      
  
        /**** search drop down ***/

        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
        if(Auth::check()){
                 //Notification
            $uid = Auth::user()->id;
                   $data['getNotification']=new Notification();
                   $data['showNotification']=$data['getNotification']->getAllNotify($uid);
                   $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
            }
            $valuesss['query']=$data['getavailablle']->getAvailability($userid);
            foreach ($valuesss['query'] as $key => $value) {
                $days[$value->opening_days]=sizeof(unserialize($value->opening_time));
            }
            //print_r($days);
            $valuesss['query2']=$data['getlist']->getBookedAppointment($userid);
            foreach ($valuesss['query2'] as $key => $value2) {
               $vnm=array();
                $countdate=sizeof($data['getlist']->countBookingOnDate($userid,$value2->booking_date));
                 $valuess[$key]=$value2->booking_date;
                $datt= date('Y-m-d', strtotime($value2->booking_date)); 
                 $datts= date('m-d-Y', strtotime($value2->booking_date)); 
                $datt2= date('l', strtotime($datts)); 
                $totalpat=0;
                //find which day doctor is available 
                
                if(!empty($days[$datt2])){
                $totalpat=$days[$datt2];
               
                }
                 
                $remain=0;
               //echo $countdate;
                if($countdate>0){
                    $remain=$totalpat-$countdate;
                }/*else{
                  $remain=$totalpat;
                  $countdate=0;
                }*/
                $vnm[]="<ul><li class='bnos bbooked' data-bubble=$countdate title='Booked'>$countdate</li> <li class='bnos bavail' data-bubble=$remain title='Available'>$remain</li></ul>"; 
                $showdate['date']=$datt;
                $showdate['note']=$vnm;
                array_push($bn,$showdate);

            }

            return Response::json($bn);
    }



    /**** show patients record ***/
   public function showpatients(Request $request){
       $data['rolename']=new RoleController();
       $data['userfollow']=new UserFollow();
        $data['userMetaObj'] = new UserMetum();
        $usercontroller = new UserController();
        $data['encrypt']=new EndecryptController();
        $data['userdatabyid']=new User();
      
        $data['countrequests']=0;
        $data['userAllMetaData']  = $usercontroller->getUserInformation();

        $data['allimages']=UserMedia::where('uid','=',Auth::user()->id)->get();
                 /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
      $datahtmls='';
      $data['showpatients']=AppointmentList::where('doctor_id','=',Auth::user()->id)->where('booking_date','=',$request->name)->get();
       $data['showbooking']=AppointmentList::where('patient_id','=',Auth::user()->id)->where('booking_date','=',$request->name)->get();
      if(sizeof($data['showpatients'])>0 || sizeof($data['showbooking'])>0){
       
      $datahtmls.=view('user.patients',compact('data','showappointments','i'));
      
      }

     //return view('user.patients',compact('data','searchdropdown'));

     return Response::json($datahtmls);
    }
}
