<?php

namespace App\Http\Controllers;
use DB;
use View;
use Auth;
use Illuminate\Http\Request;
use App\TimelinePost;
use App\UserMetum;
use App\UserConnection;
use App\Notification;
use App\User;
class DiscountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index()
    {  
   
      $uid=0;
      $data['userdatabyid']=new User();
      $request=0;
      if(Auth::check()){
      $header=new HeaderController();
        $data=$header->headerAfterLogin($request);

      }else{
      $uid=0;
      }
 /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
        return view('user.discountpage',compact('data','searchdropdown'));
    }

 

}
