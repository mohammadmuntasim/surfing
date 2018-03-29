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
class ContactUsController  extends Controller
{

    public function index()
    {
     $data['userdatabyid']=new User(); 
  
        /**** search drop down ***/
        $request=0;
       $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
        if(Auth::check()){
                 //Notification
        $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
        }

        return view('pages.contactus',compact('data','searchdropdown'));
    }


    function store(Request $request)
    {   


     $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
            /**** search drop down ***/
            $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
                $data =  array(
                    'name' => $request->get('fname'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'user_message' => $request->get('message')
                );

         
             $user = ContactusInformation::insert([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],  
                'message' => $data['user_message'],       
            ]);
            $email = $request->get('email');
           //Voyager::setting('email_id')
            Mail::send('emails.contact', $data, function($message) use ($email) {
                $message->to(Voyager::setting('email_id'))->subject('Contact Us');
            });
            //Voyager::setting('email_id')
            Mail::send('emails.contact', $data, function($message) use ($email) {
                $message->to('mark@surfhealth.com')->subject('Contact Us');
            });
            
        if(Auth::check()){
        //Notification
        $uid = Auth::user()->id;
        $data['getNotification']=new Notification();
        $data['showNotification']=$data['getNotification']->getAllNotify($uid);
        $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
        }
            return view('errors.503',compact('data','searchdropdown'));
    }
}