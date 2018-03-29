<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Faq;
use App\Notification;
use Auth;
class HelpFAQController extends Controller
{
    public function index(){
        /**** search drop down ***/
    	$searchdropdowns=new User();
        $searchdropdown=$searchdropdowns->getSearchDropdownList();
        // get FQA	
	$data['faqs']=Faq::orderBy('id', 'desc')->get();
if(Auth::check()){
$uid=Auth::user()->id;
}else{
$uid='0';
}
  $header=new HeaderController();
        $data=$header->headerAfterLogin($request);

        return view('faq.faq',compact('data','searchdropdown'));
    }
}


 