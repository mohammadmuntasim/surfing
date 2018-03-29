<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\UserMetum;
use App\Slider;
use App\Category;
use App\Post;
use App\Reviews;
use Illuminate\Http\Request;

class WelcomeController  extends Controller
{



public function __construct()
    {
        $this->middleware('guest');
    }

     /*****search code start***/
    public function index()
    {
      
        
           $userMetaObj = new UserMetum();  
            $data['rolename']=new RoleController();
            $data['userMetaInformation']=new UserMetum();
            $data['getreviews']=new Reviews();
            //gey user info from user table
            $data['userdatabyid']=new User();
           $myusersdata= User::where('is_feature', '=', 1)->get();

           $sliders = Slider::orderBy('sort_order', 'ASC')->get();
         
          $relatedPosts = Post::where('category_id', '=', 1)->get();
           /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
       
        return view('welcome',compact('data','myusersdata','userMetaObj','sliders','relatedPosts','searchdropdown'));

       //}

    }
    
    
    

   

}
