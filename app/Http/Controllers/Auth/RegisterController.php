<?php

namespace App\Http\Controllers\Auth;
use DB;
use App\User;
use App\UserMetum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\FunctionController;
use Redirect;
use Mail;
use Illuminate\Http\Request;
use App\UserVerification;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6', 
            'role' => 'required|max:255',   
            'day' => 'required|max:255',   
            'month' => 'required|max:255',   
            'year' => 'required|max:255',   
            'gender' => 'required|max:255'            

                        
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $userMetaObj = new UserMetum();
        $fname=trim($data['fname']);
        $lname=trim($data['lname']);
      //  $name = ($data['role'] == 2) ? 'Dr. '.$data['fname'].' '.$data['lname'] : $data['fname'].' '.$data['lname'];
        $name='';
        if($data['role'] == 2 || $data['role'] == 7 || $data['role'] == 5 || $data['role'] == 6){
            $name='Dr. '.$fname.' '.$lname;

        }else{
            $name=$fname.' '.$lname;
        }
        $user = User::create([
            'role_id' => $data['role'],
            'name' => $name,
            'email' => $data['email'],
            'password' => bcrypt($data['password'])            
        ]);
        $lastUserId = $user->id;
        $dob = $data['day'].'-'.$data['month'].'-'.$data['year'];
        $gender = $data['gender'];
        $setUserMeta = array(
                array(
                    'user_id'           => $lastUserId,
                    'user_meta_key'     => 'user_dob',
                    'user_meta_value'   => $dob
                ),
                array(
                    'user_id'           => $lastUserId,
                    'user_meta_key'     => 'user_gender',
                    'user_meta_value'   => $gender
                ),
            );
        $userMetaObj->setUserMeta($setUserMeta);
        return $user;
    }

    /* Get the user role */
    protected function showregistrationform(){
        $roles  = DB::table('roles')->where('id','<>', 1)->orderBy('id', 'ASC')->get();
        $sliders = DB::table('sliders')->orderBy('sort_order', 'ASC')->get();
        $data = DB::table('pages')->where('slug', '=', 'register')->orWhere('slug', '=', 'terms-of-use')->orWhere('slug', '=', 'privacy-policy')->get();
       $myusersdata= DB::table("users")->join('user_meta', 'users.id', '=', 'user_meta.user_id')->where('role_id', '=', 2)->get();
       $data['userdatabyid']=new User();
       /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
        return view('auth.register', ['roles' => $roles, 'sliders'=>$sliders, 'data'=> $data,'myusersdata'=> $myusersdata,'searchdropdown'=>$searchdropdown]);
    }

    protected function register( Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);

            if($validator->passes())
            {
                $data = $this->create($input)->toArray();


                $data['token'] = str_random(25) ;


                $user = User::find($data['id']);
              
                $Userverification = UserVerification::create([
                    'user_id' => $user['id'],
                    'token' => $data['token'],
                    'status' => 0
                ]);
                
                 
                

                Mail::send('emails.confirmation', $data, function($message) use($data)
                {
                    $message->to($data['email']);
                    $message->subject('Surf Health Account Activation');
                });
                return redirect()->route('login')->with('showstatus', 'Confirmation Email has been sent. Please Check Your Email');

            }

            return redirect()->route('register')->with('errors', $validator->errors());          
    }

    public function confirmation(Request $request,$token)
    {
        $user = UserVerification::where('token', $token)->first();
        
        if(!is_null($user)){

                $user->status = 1;
                $user->token = $token;
                $user->save();  

                 if($request->claim=='true'){
                    $userid=$user->user_id;
                    $showstatus = User::where('remember_token','=', $token)->count();
                    if($showstatus>0){
                        $showstatus=$showstatus;
                    }else{
                        $showstatus="This claim token is invalid.";
                    }
                
                return view('auth.passwords.claim',compact('token','showstatus','Your Email has been verified. Thank You !!','userid'));
             
                }else{
                return redirect()->route('login')->with('showstatus', 'Your Email has been verified. Thank You !!');
                }
        }
    
        return redirect()->route('login')->with('showstatus', 'Sorry!! Something went Wrong. Try Again. Thank You.');
     
    }

}
