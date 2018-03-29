<?php

namespace App\Http\Controllers;
use DB;
use View;
use Illuminate\Contracts\Validation\Validator;

use Exception;
use Illuminate\Http\Request;
use DateTime;
use Auth;
use App\UserMetum;
use Mail;
use Voyager;
use App\ContactusInformation;
use App\User;
use App\Notification;
use Response;
use App\AppointmentSetting;
use App\AppointmentList;
use App\UserInsurance;
class AppointmentController  extends Controller
{

    public function getTimeSchedule(Request $request)
    {
       $data['userdatabyid']=new User(); 
       $data['getavailablle']=new AppointmentSetting();
       $data['getlist']=new AppointmentList();
       $data['encrypt']=new EndecryptController();
       if(isset($_GET['name'])){
        if($_GET['name']==''){
        $userid=Auth::user()->id;
       }else{
       $userid=$data['encrypt']->decryptIt($request->name);
       }
     }
       $showdate=array();
       $days=array();
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
           // print_r($valuesss['query']);
            //exit();
            foreach ($valuesss['query'] as $key => $value) {

                $days[$value->opening_days]=sizeof(unserialize($value->opening_time));
               
            }
            $data['showbooking']=AppointmentList::where('patient_id','=',Auth::user()->id)->get();
        
            $valuesss['query2']=$data['getlist']->getBookedAppointment($userid);
           
            if(sizeof($valuesss['query2'])>0){
            foreach ($valuesss['query2'] as $key => $value2) {
               $vnm=array();
                $countdate=sizeof($data['getlist']->countBookingOnDate($userid,$value2->booking_date));
                //echo $countdate;
                $valuess[$key]=$value2->booking_date;
                $mybook='';
               
                $datts= date('m-d-Y', strtotime($value2->booking_date)); 
                $datt= $value2->booking_date; 
                
                $datt2= date('l', strtotime($value2->booking_date)); 
                $totalpat=0;
               
                if(!empty($days[$datt2])){
                 
                $totalpat=$days[$datt2];
               
               
                }
                 
                $remain=0;
               //echo $countdate;
                if($countdate>0){
                    $remain=$totalpat-$countdate;
                }else{
                  $remain=$totalpat;
                  $countdate=0;
                }
                $data['showbookingscount']= $data['showbookings']=AppointmentList::where([['patient_id','=',Auth::user()->id],['booking_date','=',$value2->booking_date],['status','=',0]])->count();
                 if($data['showbookingscount']>0){
                      $countdates=$data['showbookingscount'];
                        $mybook="<li class='bnos mybbooked' data-bubble=$countdates title='My Booked'>$countdates</li>";                  
                    

                } 
                $vnm[]="<ul>$mybook<li class='bnos bbooked' data-bubble=$countdate title='Booked'>$countdate</li> <li class='bnos bavail' data-bubble=$remain title='Available'>$remain</li></ul>"; 
                $showdate['date']=$datt;
                $showdate['note']=$vnm;
                array_push($bn,$showdate);

            }
           }
            if(sizeof($data['showbooking'])>0){
               foreach ($data['showbooking'] as $key => $value2) {
               $vnm=array();
                $countdate=sizeof($data['getlist']->countBookingOnDate($userid,$value2->booking_date));
                //echo $countdate;
                $valuess[$key]=$value2->booking_date;
                $mybook='';
               
                $datts= date('m-d-Y', strtotime($value2->booking_date)); 
                $datt= $value2->booking_date; 
                
                $datt2= date('l', strtotime($value2->booking_date)); 
                $totalpat=0;
                //find which day doctor is available 
                //echo $datt2;
                //echo $datt;
               
                if(!empty($days[$datt2])){
                 
                $totalpat=$days[$datt2];
               
               
                }
                 
                $remain=0;
               //echo $countdate;
                if($countdate>0){
                    $remain=$totalpat-$countdate;
                }else{
                  $remain=$totalpat;
                  $countdate=0;
                }
                 $data['showbookingscount']= $data['showbookings']=AppointmentList::where([['patient_id','=',Auth::user()->id],['booking_date','=',$value2->booking_date],['status','=',0]])->count();
                 if($data['showbookingscount']>0){
        
                        $countdates=$data['showbookingscount'];
                       // print_r( $countdate);
                        $mybook="<li class='bnos mybbooked' data-bubble=$countdates title='My Booked'>$countdates</li>";                
                    

                } 
               $vnm[]="<ul>$mybook<li class='bnos bbooked' data-bubble=$countdate title='Booked'>$countdate</li> <li class='bnos bavail' data-bubble=$remain title='Available'>$remain</li></ul>"; 
                $showdate['date']=$datt;
                $showdate['note']=$vnm;
                array_push($bn,$showdate);

            }
          }
           //}
          //print_r($bn);
            return Response::json($bn);
    }

    //get insurance plans name by doctor id
   public function makeAppointmentInsuPlans(Request $request)
    {   

   $valuess='';
   $userid=0;
   $data['encrypt']=new EndecryptController();
       if(isset($_GET['docid'])){
        if($_GET['docid']==''){
        $userid=Auth::user()->id;
       }else{
       $userid=$data['encrypt']->decryptIt($request->docid);
       }
     }
     $searchdropdown = UserInsurance::where([['insurance_name','=',$request->name],['user_id','=',$userid]])->distinct()->pluck('insurance_plan_name');
     if(sizeof($searchdropdown)>0){
     $valuesk=unserialize($searchdropdown[0]);
      $valuess.='<option value="" selected="">Select Insurance Plan</option>';
     for ($i=0; $i<sizeof($valuesk); $i++) {
      $noIsuranceOption = $request->name == 'No Insurance' ? 'selected' : '';
        if($noIsuranceOption==''){
         $valuess.='<option value="'.$valuesk[$i].'" '.$noIsuranceOption.' >'.$valuesk[$i].'</option>';
        }else{
          $valuess.='<option value="No Insurance Plan" '.$noIsuranceOption.' >No Insurance Plan</option>';
        }
      }
     }else{
      $noIsuranceOption = $request->name == 'No Insurance' ? 'selected' : '';
      $valuess.='<option value="No Insurance Plan" '.$noIsuranceOption.' >No Insurance Plan</option>';
     }
    
     return Response::json($valuess);
    }
}