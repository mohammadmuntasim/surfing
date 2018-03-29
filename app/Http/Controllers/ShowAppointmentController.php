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
use App\Notification;
use Mail;
use App\AppointmentSetting;
use Response;
class ShowAppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');         
    }
    public function index(Request $request){
      $uid= Auth::user()->id;
      $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
       $data['rolename']=new RoleController();
       $data['userfollow']=new UserFollow();
       $data['userMetaObj'] = new UserMetum();
       
       $usercontroller = new UserController();
       $searchcontroller = new SearchViewController();
       $data['getavailablle']=new AppointmentSetting();
       //encrypt id
       $data['encrypt']=new EndecryptController();
       
        $data['userid']='';
             // current user id
        $searchcontroller = new SearchViewController();
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
             $data['usergeneralinfo']  = $searchcontroller->getUserGeneralInfo($data['currentUserid']);
           $data['userAllMetaData']  = $searchcontroller->getUserInformation($data['currentUserid']);
                  /* Cover Image */
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $usercontroller->postCoverPhoto($request);
        }elseif($usercontroller->getPhoto('cover',$data['currentUserid'])){
            $data['cover-image']= $usercontroller->getPhoto('cover',$data['currentUserid']);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }

        /* Profile Image */
        if (!empty($request->profile_photo)) {
            $data['profile-image']= $usercontroller->postProfilePhoto($request);
        }elseif($usercontroller->getPhoto('profile',$data['currentUserid'])){
            $data['profile-image']= $usercontroller->getPhoto('profile',$data['currentUserid']);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   

        $data['countrequests']=0;
        $data['userAllMetaData']  = $usercontroller->getUserInformation();
        $data['allimages']=UserMedia::where('uid','=',Auth::user()->id)->get();
        /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
       $data['sucess']=0;
        if(isset($request->singlebutton) && !empty($request->docid)){
              $decode=$data['encrypt']->decryptIt($request->docid);
              $addpatients=new AppointmentList();      
              $addpatients->doctor_id=$decode;
              $addpatients->patient_id=Auth::user()->id;
              $addpatients->booking_date=$request->booking_date;      
              $addpatients->patient_type=$request->patient_type;
              $addpatients->reason_for_visit=$request->reason_id;
              $addpatients->patient_insurance_provider=$request->insurance_provider;
              $addpatients->patient_insurance_plan=$request->insurance_plan_id;
              $addpatients->patient_full_name=$request->name;
              $addpatients->patient_dob=$request->patientdob;
              $addpatients->patient_gender=$request->patient_gender;
              $addpatients->phone_number=$request->contact_number;
              $addpatients->patient_email=$request->email;
              $addpatients->booking_time=$request->booking_time;
              $addpatients->cancel_msg=0;
              $addpatients->status=0;
              $addpatients->save();
              // add notificantion table
              $last_id = $addpatients->id;
            
         // $data['addNotification']=$data['getNotification']->createNotification($decode,$messagess,3);

         $email='';
          $docname ='';
            //get doctor mail id
            $getemail=User::where('id','=',$decode)->get();
            foreach ($getemail as $getvalue) {
              $email =$getvalue->email;
              $docname =$getvalue->name;
            }
          $datas = array(
                'name' => $request->name,
                'sento' => $email,
                'doctorname' => $docname,
                'email' => $request->email,
                'phone' => $request->contact_number,
                'illness' => $request->reason_id,                
                'patient_type' => $request->patient_type,
                'booking_date' => $request->booking_date.' at '. $request->booking_time
            );

            

          $emailsss=Auth::user()->email;
            //send mail for new appointment to doctor
           $mk=Mail::send('emails.bookingAppointmenteMail', $datas, function($message) use ($emailsss,$datas) { 
            $message->to($datas['sento'],$datas['doctorname'])->subject(' New Appointment ');           
            });

             $datas2 = array(
                'name' => $docname,
                'sento' => $email,
                'doctorname' => $request->name,
                'email' => $request->email,
                'phone' => $request->contact_number,
                'illness' => $request->reason_id,                
                'patient_type' => $request->patient_type,
                'booking_date' => $request->booking_date.' at '. $request->booking_time
            );
            //send mail for new appointment to patinet
           $mk=Mail::send('emails.bookingAppointmenteMail', $datas2, function($message) use ($emailsss,$datas2) { 
            $message->to($datas2['email'],$datas2['doctorname'])->subject(' Your Appointment Confirmation ');           
            });

           $data['sucess']="1";
          $data['addNotification']=$data['getNotification']->createNotification($decode,$last_id,3);
          $data['addNotification']=$data['getNotification']->createNotification(Auth::user()->id,$last_id,3);
          
      }
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

   /****show friend list ***/
        $countrequest2=DB::table('user_connections')->where('status', '=', '1')->where(
        function ($query) use($uid) { 
            $query->where('user_id', '=', $uid)->orWhere('connect_user_id', '=', $uid);
        })->count();
    
        if($countrequest2>0){
            $data['userfriendlist']=DB::table('user_connections')->where('status', '=', '1')->where(
        function ($query) use($uid) { 
            $query->where('user_id', '=', $uid)->orWhere('connect_user_id', '=', $uid);
        })->get();
             $data['userfriendlistcount']=$countrequest2;
        }else{
             $data['userfriendlistcount']=0;
        }

        //show days of total patinets start
        $gh='';
        $valuesss['query']=$data['getavailablle']->getAvailability($data['currentUserid']);
        foreach ($valuesss['query'] as $key => $value) {
               // $gh[$value->opening_day]='{'.$value->opening_day.'}';
               
                $gh.='<div class="'.$value->opening_days.'">'.sizeof(unserialize($value->opening_time)).'</div>';
               
        }
       $data['daysavail']= $gh;
        
       //exit();
       //$data['daysavail']=$daysname2;
        //show days of total patinets end
        $data['showpatients']=AppointmentList::where([['doctor_id','=',Auth::user()->id],['booking_date','=',$data['dates']]])->get();
        $data['showbooking']=AppointmentList::where([['patient_id','=',Auth::user()->id],['booking_date','=',$data['dates']]])->get();
        $data['usergeneralinfo']  = $searchcontroller->getUserGeneralInfo($data['currentUserid']);
        $data['userAllMetaData']  = $searchcontroller->getUserInformation($data['currentUserid']);
        //get insurance provider name by id
     
       $data['userinsurance']= $data['userdatabyid']->getInsuranceProviderByUserid($data['currentUserid']);
       if ($request->isMethod('post')) {
        return redirect()->back();
      }else{
        return view('user.bookings.appointment',compact('data','daysname','searchdropdown'));
      }

      
    }

  /**** show patients record ***/
   public function showpatients(Request $request){
       $data['rolename']=new RoleController();
       $data['userfollow']=new UserFollow();
        $data['userMetaObj'] = new UserMetum();
        $usercontroller = new UserController();
        $data['encrypt']=new EndecryptController();
        $data['userdatabyid']=new User();
       /* Cover Image */
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $usercontroller->postCoverPhoto($request);
        }elseif($usercontroller->getPhoto('cover')){
            $data['cover-image']= $usercontroller->getPhoto('cover');
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if (!empty($request->profile_photo)) {
            $data['profile-image']= $usercontroller->postProfilePhoto($request);
        }elseif($usercontroller->getPhoto('profile')){
            $data['profile-image']= $usercontroller->getPhoto('profile');
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }   
        $data['countrequests']=0;
        $data['userAllMetaData']  = $usercontroller->getUserInformation();

        $data['allimages']=UserMedia::where('uid','=',Auth::user()->id)->get();
                 /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
 
      $data['showpatients']=AppointmentList::where('doctor_id','=',Auth::user()->id)->get();
    

     return view('user.patients',compact('data','searchdropdown'));
    }

    /**** show time by id record ***/
   public function showAvailTimes(Request $request){
    $data['encrypt']=new EndecryptController();
    $data['timeSetting']=new AppointmentSetting();
    $uid=$data['encrypt']->decryptIt($request->docname);
    
    $dayname=$request->dayname;
    $data['getvalue']=$data['timeSetting']->getTimeAvailability($uid,$dayname);
    $showtime='Not Available';
   
   
    if(!empty($data['getvalue']))
    {
      
      foreach ($data['getvalue'] as $key => $valuetime) {
        if(!empty($valuetime->opening_time)){
          $showtime='<ul>';
        $showgettimer=unserialize($valuetime->opening_time);
        for ($i=0; $i <sizeof($showgettimer) ; $i++) {  
        if($showgettimer[$i]!=0) {   
          $data['showpatientss']=AppointmentList::where([['doctor_id','=',$uid],['booking_date','=',$request->bdate],['booking_time','=',$showgettimer[$i]],['status','=',0]])->count();         
          if($data['showpatientss']==0){
             $showtime.='<li><a href="javascript:void(0);" onclick="getTimeText(this)">'.$showgettimer[$i].'</a></li>';
          }else{
            $showtime.='<li class="blocked"><a href="javascript:void(0);" >'.$showgettimer[$i].'</a></li>';
          }
        } 
        }
        $showtime.='</ul>';
      }
       
    }
    
    }else{
        $showtime='Not Available';
    }
  
    return Response::json($showtime);

   }
/****cancel by doctor ***/
   public function cancelBookingByDoctor($request){
    $cancelid=$request->cancelbydoc;
    $data['userdata']= new User();
    foreach($cancelid as  $key => $value)
     {

        $data['sets']=AppointmentList::where('id','=',$value)->update(array('status' => 2,'cancel_msg'=>$request->cancelmsg));
        $revmail='';
        $revname='';
        $booking_date='';
        $vb=$value;
        $ptid='';
         $docid='';
        $receiversdata=AppointmentList::where('id', '=', $value)->get();
          foreach ($receiversdata as $receiversvalue) {
            $revmail=$receiversvalue->patient_email;
            $revname=$receiversvalue->patient_full_name;
            $booking_date=$receiversvalue->booking_date;
            $pid=$receiversvalue->patient_id;
            $docid=$receiversvalue->doctor_id;
          }
           $docvalue= $data['userdata']->getUserData(['id'=> $docid]);
         
          $comment=$request->cancelmsg;

            $data = array(
                'name' => $docvalue[0]->name,
                'emails' => $revmail,
                'user_message' => $comment,
                'booking_date' => $booking_date,
                 'docmail' => $docvalue[0]->email,
                'docname' => $docvalue[0]->name
            );
       
            $email = Auth::user()->email;

            Mail::send('emails.cancelAppointmentMail', $data, function($message) use ($email,$data) { 
            $message->to($data['emails'],$data['name'])->subject(' Appointment Cancel By Doctor');
            });
            $data['getNotification']=new Notification();
           //delete booking notification
            $datass['addNotification']=$data['getNotification']->deleteNotification($pid,$value,3);
            $datass['addNotification']=$data['getNotification']->deleteNotification($docid,$value,3);
            //add cancellation  notification
           
            $datass['addNotification']=$data['getNotification']->createNotification($pid,$value,3);
             
             
     }
     $datass['sets']='tested';
     return $datass['sets'];
   }


   /****cancel by doctor ***/
   public function cancelBookingByPatients($request){
    $cancelid=$request->cancelbypat;
    $data['userdata']=new User();
    foreach($cancelid as  $key => $value)
     {

        $data['sets']=AppointmentList::where('id','=',$value)->update(array('status' => 1,'cancel_msg'=>$request->cancelmsg));
        $revmail='';
        $revname='';
        $booking_date='';
        $vb=$value;
        $ptid='';
        $docid='';
        $receiversdata=AppointmentList::where('id', '=', $value)->get();
          foreach ($receiversdata as $receiversvalue) {
            $revmail=$receiversvalue->patient_email;
            $revname=$receiversvalue->patient_full_name;
            $booking_date=$receiversvalue->booking_date;
            $pid=$receiversvalue->patient_id;
            $docid=$receiversvalue->doctor_id;
          }
         
          $comment=$request->cancelmsg;
           $docvalue= $data['userdata']->getUserData(['id'=> $docid]);
            $data = array(
                'name' => $revname,
                'emails' => $revmail,
                'user_message' => $comment,
                'booking_date' => $booking_date,
                'docmail' => $docvalue[0]->email,
                'docname' => $docvalue[0]->name
            );
       
            $email = Auth::user()->email;
          
            Mail::send('emails.cancelAppointmentMail', $data, function($message) use ($email,$data) { 
            $message->to($data['docmail'],$data['docname'])->subject(' Appointment Cancel By Patient ');
            });
            $data['getNotification']=new Notification();
           //delete booking notification
            $datass['addNotification']=$data['getNotification']->deleteNotification($pid,$value,3);
            $datass['addNotification']=$data['getNotification']->deleteNotification($docid,$value,3);
            //add cancellation  notification
           
            $datass['addNotification']=$data['getNotification']->createNotification($docid,$value,3);
             
             
     }
     $datass['sets']='tested';
     return $datass['sets'];
   }
}
