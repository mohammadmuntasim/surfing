<?php

namespace App\Http\Controllers;

use App\User;
use Mail;
use DateTime;
use App\Reviews;
use Response;
use View;
use Auth;
use File;
use Illuminate\Http\Request;
use App\UserMetum;
use App\UserConnection;
use DB;
use App\UserFollow;
use App\Notification;
use App\AppointmentList;
use App\UserRefer;
class NotificationController extends Controller
{

 public function __construct()
    {
        $this->middleware('auth');         
    }

    
   
     /****show records***/
     public function showRecords(Request $request){
        $checkreviews='';
        $rid=Auth::user()->id;
        $data['getNotification']=new Notification();
        $data['userdatabyid']=new User();
        $data['appointment']=new AppointmentList();
         $data['getRefer']=new UserRefer();
        $notifyhtml='';


        if($request->name=='connections'){
            
            //connection
            $notifications=Notification::where([['user_id','=',$rid],['notifiable_type','=',1],['read_at','=',0]])->update(array('read_at' => 1));
            $notifications=Notification::where([['user_id','=',$rid],['notifiable_type','=',1],['read_at','<>',2]])->orderBy('id', 'desc')->get();
            foreach($notifications as $notifys){
            $notifyhtml.=view('user.notifications.connectionNotify',compact('notifys','data'));
           }
        }elseif($request->name=='allnotifications'){
            /****Allnotifications **/
            $notifications=Notification::where([['user_id','=',$rid],['notifiable_type','<>',1],['read_at','=',0]])->update(array('read_at' => 1));
            $notifications =Notification::where([['user_id','=',$rid],['notifiable_type','<>',1],['read_at','<>',2]])->orderBy('id', 'desc')->get();
            //print_r($notifications);
            foreach($notifications as $notifys){
            $notifyhtml.=view('user.notifications.notification',compact('notifys','data'));
           }
    
        }elseif($request->name=='counts'){
            /****Allnotifications connection counts **/
          
            $notifications =Notification::where([['user_id','=',$rid],['notifiable_type','<>',1],['read_at','=',0]])->count();
            $connections=Notification::where([['user_id','=',$rid],['notifiable_type','=',1],['read_at','=',0]])->count();
            $notifyhtml=array('notifications' =>$notifications ,'connections'=>$connections);
        }

   return Response::json($notifyhtml);
    }
}
