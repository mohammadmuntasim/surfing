<?php

namespace App\Http\Controllers;
use DB;
use User;
use App\UserMetum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\FunctionController;
use Redirect;
use Auth;
use Illuminate\Http\Request;
use App\UserVerification;
class ProviderDisclaimController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }
    
   
    /* Get the user role */
    public function index(){
    
    
            $data = DB::table('pages')->where('slug', '=', 'providers-discalimer')->get();
            $searchdropdown['providers'] = DB::table('insurance_providers')->get();
          $searchdropdown['docspeciality'] = DB::table('doctorspeciality')->get();
          $searchdropdown['denspeciality'] = DB::table('dentist_speciality')->get();
          $searchdropdown['wellnessspeciality'] = DB::table('wellness_speciality')->get();
          $searchdropdown['eldercarespeciality'] = DB::table('eldercare_speciality')->get();
            return view('user.disclaimer',compact('data','searchdropdown'));
    
    }

 
}
