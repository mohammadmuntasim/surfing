<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use App\User;
class ClaimController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller 
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function __construct()
    {
        $this->middleware('guest');
    }
    
     public function index()
    {
        
       $showstatus='Your password changed successfully!..';
        return view('auth.login',compact('showstatus',''));

        
    }
     public function update(Request $request)
    {
        // Validate the new password length...

        $update=User::where('id','=',$request->updateuser)->update(
            array(
            'password' => Hash::make($request->password_confirmation),
            'remember_token'=>''
            )
            );
        $showstatus='Your password changed successfully!..';
        return view('auth.login',compact('showstatus','Your password changed successfully!..'));

        
    }
}
