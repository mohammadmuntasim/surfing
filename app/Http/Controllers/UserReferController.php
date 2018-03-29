<?php

namespace App\Http\Controllers;
use DB;
use View;
use Illuminate\Contracts\Validation\Validator;
use App\TimelinePost;
use File;
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
use App\UserFollow;
use App\UserConnection;
use App\Reviews;
use App\UserRefer;
class UserReferController  extends Controller
{



/****refer user ***/
public function referuser(Request $request){
   
    //print_r($receivid);
    $text='';
    $userrefer=new UserRefer();
    $userrefer->sender_user_id=Auth::user()->id;
    $userrefer->receiver_user_id=$request->getdata;
    $userrefer->refer_user_id=$request->docid;
    $userrefer->save();
    $docname=User::where('id','=',$request->docid)->get();
    foreach ($docname as $docnamevalue) {
        $text='You are Refer  '.$docnamevalue->name;
    }
       $lastid= $userrefer->id;
        //Notification
        $data['getNotification']=new Notification();
        $data['addNotification']=$data['getNotification']->createNotification($request->getdata,$lastid,2);
        $data['addNotification']=$data['getNotification']->createNotification($request->docid,$lastid,2);


return response()->json($text);
}
}