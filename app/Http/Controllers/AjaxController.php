<?php

namespace App\Http\Controllers;

use File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;
use Auth;
use DB;
use App\Http\Requests;
use DateTime;
use View;
use Response;
use Input;
use App\UserConnection;
use App\Notification;
use App\User;
use Session;
use Redirect;
use App\UserMetum;
use App\UserInsurance;
class AjaxController extends Controller
{
    

public function mapaddress(Request $request)
  {
    
    // $uid = Auth::user()->id;
    // $userMetaObj = new UserMetum();       
    $mapid= $request->map;   
    /*$paddress= DB::table('user_meta')->where('user_id', $mapid)->where('user_meta_key','user_address')->pluck('user_meta_value');*/
    /*$paddress.= DB::table('user_meta')->where('user_id', $mapid)->where('user_meta_key','user_location')->pluck('user_meta_value');*/
    $paddress.= DB::table('user_meta')->where('user_id', $mapid)->where('user_meta_key','user_address')->pluck('user_meta_value');
    $paddress.= DB::table('user_meta')->where('user_id', $mapid)->where('user_meta_key','user_city')->pluck('user_meta_value');
    $paddress.= DB::table('user_meta')->where('user_id', $mapid)->where('user_meta_key','user_county')->pluck('user_meta_value');
    $paddress.= DB::table('user_meta')->where('user_id', $mapid)->where('user_meta_key','user_state')->pluck('user_meta_value');
    $paddress.= DB::table('user_meta')->where('user_id', $mapid)->where('user_meta_key','user_zipcode')->pluck('user_meta_value');

     return Response::json($paddress);

  }
  //sign logout
public function getSignOut() {

    Auth::logout();
    Session::flush();
    return Redirect::route('welcome');

}
//get county name
public function getCounty(Request $request) {
      $valuess='';
     $searchdropdown = DB::table('state_county_city')->where([['state','=','Florida'],['county','=',$request->name]])->orderBy('city','ASC')->distinct()->pluck('city');
      $valuess.='<option value="">Select City</option>';
     foreach ($searchdropdown as $values) {
       $valuess.='<option value="'.$values.'">'.$values.'</option>';
     }
     return Response::json($valuess);

}

//get get plans  name
public function getPlans(Request $request) {
      $valuess='';
       $userid=Auth::user()->id;
     $searchdropdown = DB::table('insurance_providers')->where('insur_provider','=',$request->name)->orderBy('insur_plan','ASC')->distinct()->get();
     $searchdropdown2 = UserInsurance::where([['insurance_name','=',$request->name],['user_id','=',$userid]])->distinct()->pluck('insurance_plan_name');
    
     
     foreach ($searchdropdown as $values) {
      $noIsuranceOption = $request->name == 'No Insurance' ? 'selected' : '';

      
       $valuessseleted='';
       if(sizeof($searchdropdown2)>0){
         $valuesk=unserialize($searchdropdown2[0]);
       for ($i=0; $i<sizeof($valuesk); $i++) {  

          if($valuesk[$i]== $values->insur_plan){
         $valuessseleted='selected="selected"';
          
          }
        }
      }
       $valuess.='<option value="'.$values->insur_plan.'" '.$valuessseleted.' >'.$values->insur_plan.'</option>';
     }
     print_r($valuess);
     exit();
    // return Response::json($valuess);

    

}
//get county name
public function removeTags(Request $request) {
      $valuess='';
     $searchdropdown = UserMetum::where('id','=',$request->name)->delete();
     
     return Response::json($searchdropdown);

}
/* Check email aleardy used  or not */
  public function checkEmail(Request $request){    
    $searchEmail = DB::table('users')->where('email','=',$request->email)->get();
    /*echo "<pre>";
    print_r($searchEmail);
    echo "<pre>";*/
    foreach ($searchEmail as $key => $emailCheck) {
      if (!empty($emailCheck)) {
        echo "1";
      }else{
        echo "0";
      }
    }
    
  } 

// remove removeCover picture
public function removeCover(Request $request){
     $valuess='';
     $deletedcover =UserMetum::where([['user_id','=',Auth::user()->id],['user_meta_key','=','user_cover_photo']])->delete();
     
     return Response::json($deletedcover);
}
}
