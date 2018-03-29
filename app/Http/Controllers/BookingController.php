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
class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');         
    }
    public function index(Request $request){

        $usercontroller = new UserController();
        $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
       $data['currentUserid']=''; 
            if(isset($_GET['ref_app'])){
              if(!empty($_GET['ref_app'])){
                $val=$data['encrypt']->decryptIt($_GET['ref_app']);
                $data['currentUserid']=$val;
                $data['userid']=$val;
                $data['cover-image']='/css/assets/img/default-cover.jpg';
              }else{
                $data['currentUserid']=Auth::user()->id;
              }
              
            }else if(!empty($data['userid'])){
             $data['currentUserid']=$data['userid'];
              }else{
              $data['currentUserid']=Auth::user()->id;
            }
        $uid=Auth::user()->id;
        //Notification
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
       /* Cover Image */
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $usercontroller->postCoverPhoto($request);
        }elseif($usercontroller->getPhoto('cover',$uid)){
            $data['cover-image']= $usercontroller->getPhoto('cover',$uid);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if (!empty($request->profile_photo)) {
            $data['profile-image']= $usercontroller->postProfilePhoto($request);
        }elseif($usercontroller->getPhoto('profile',$uid)){
            $data['profile-image']= $usercontroller->getPhoto('profile',$uid);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   
        $data['countrequests']=0;
        $data['userAllMetaData']  = $usercontroller->getUserInformation();
        $data['allimages']=UserMedia::where('uid','=',Auth::user()->id)->get();
        /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();

      $data['dates']='';
      
        if(isset($request->checkdate))
        {
            $data['dates']=$request->checkdate;
        }else{
          $data['dates']=date('d-m-Y');
        }
      /*Cancel booking*/
      if(isset($request->cancelbydoc))
      {
        $data['cancelbydoc']=$this->cancelBookingByDoctor($request);
      }
      /*Cancel booking by Patioents*/
      if(isset($request->cancelbypat))
      {
        $data['cancelbypat']=$this->cancelBookingByPatients($request);
      }

  
   $data['showbookings']=AppointmentList::where([['doctor_id','=',Auth::user()->id],['booking_date','=',$request->date]])->orwhere([['patient_id','=',Auth::user()->id],['booking_date','=',$request->date]])->get();
  // $data['showbookings']=AppointmentList::where([['patient_id','=',Auth::user()->id],['booking_date','=',$request->date]])->get();
   return view('user.bookings.showBookingBydate',compact('data','searchdropdown'));
    }
  

}
