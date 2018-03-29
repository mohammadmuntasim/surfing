<?php

namespace App\Http\Controllers;

use View;
use Auth;
use File;
use Illuminate\Http\Request;
use App\UserMetum;
use DB;
use Mail;
use App\UserVerification;
use App\User;
class EmailVerificationController extends Controller
{
  /* Verification form */
  public function index()
  {
    if (!isset(Auth::user()->id)) {
      $alertMessage = '';
      $alertErrmessage = '';
      $email = '';
      return view('auth.email-verification',compact('alertMessage','alertErrmessage','email'));
    }else{
      return redirect('/home');
    }
  }

  /* Send Activation link*/
  public function send(Request $request)
  { 
    $alertMessage = '';
    $alertErrmessage = '';
    $email = $request->email;    
    $data['email'] = $email;
    $userData = $this->getUserDataByEmail($email);
    if (!empty($userData)) {
      $data['name'] = $userData['name'];
     $data['token'] = $this->getVerificationToken($userData['id']);

      if($request->claim=='true'){
        $onlytoken=$data['token'];
      $data['token'] = $data['token'].'?claim=true';
      //update token to user table for claim profile only
      $updateuser=User::where('id','=',$userData['id'])->update(array(
        'remember_token'=>$onlytoken
        ));


      }
    
      if ($data['token'] != 1) {
        Mail::send('emails.reconfirmation', $data, function($message) use($data)
        {
            $message->to($data['email']);
            $message->subject('Surf Health Account Activation');
        });
        $alertMessage = 'Email send Successfully, please check and click on verification link.';
      }else{
        $alertErrmessage = 'This email ID is already activated, please try to login.';
      }
    }else{
      $alertErrmessage = 'This email ID is not register with the system.';
    }
    
    return view('auth.email-verification',compact('alertMessage','alertErrmessage','email'));
  }

  /* Get user data */
  public function getUserDataByEmail($email)
  {
    $userObj = DB::table('users')->where('email', '=', $email)->get();
    $data = array();
    foreach ($userObj as $key => $user) {
        $data = array(
            'id' => $user->id,            
            'name' => $user->name,            
          );
    }
    return $data;
  }

  /* Get verification token */
  public function getVerificationToken($id)
  {
    $userObj = DB::table('user_verification')->where('user_id', '=', $id)->get();
    $data = '';
    if (sizeof($userObj)>0) {
    foreach ($userObj as $key => $user) {
      if ($user->status == 0) {
        $data = str_random(25);
       
        //$data = $user->token; 
        $update=UserVerification::where('user_id', '=', $id)->update(array('token' => $data));

      }else{
        $data = 1; 
      }
      }
        
    }
    if (sizeof($userObj)==0) {
      $data = str_random(25);
      UserVerification::create([
          'user_id' => $id,
          'token' => $data,
          'status' => 0
      ]);
    }    
    return $data;
  }
  
   
}