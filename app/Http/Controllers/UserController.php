<?php
namespace App\Http\Controllers;
use View;
use Auth;
use File;
use DB;
use Illuminate\Http\Request;
use App\UserMetum;
use App\UserConnection;
use App\Reviews;
use App\User;
use App\UserMedia;
use DateTime;
use Response;
use App\UserFollow;
use App\AppointmentSetting;
use App\Notification;
use App\TimelineSharePost;
use App\TimelinePostLike;
use App\TimelinePost;
use Carbon;
use App\UserInsurance;
use App\ConnectionTimelinePost;
use App\UserComment;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');         
    }
    public function index(Request $request)
    {
            $header=new HeaderController();
            $data=$header->headerAfterLogin($request);
            $data['userfollow']=new UserFollow();
            $data['rolename']=new RoleController();
            $data['encrypt']=new EndecryptController();
            $myappoint = New AppointmentSetting();
            $data['myphotos'] = New UserMedia();
            $data['userConnections']=new UserConnection();
            $data['userComment']=new UserComment();
            $uid='';
            $data['userid']='';
            $data['userMetaObj'] = new UserMetum();
            $data['otherUserTimelinePosted']=new ConnectionTimelinePost();
            if(!empty($request->ref_app)){

            $uid =  $data['encrypt']->decryptIt($request->ref_app);
            $data['userid']=$uid;
            $data['usergeneralinfo']=$data['userdatabyid']->getUserData(['id'=>$uid]);
            }else{
            $uid = Auth::user()->id;
            $data['userid']='';
            }
             // current user id
            $data['currentUserid']=''; 
            if(isset($_GET['ref_app'])){
              if(!empty($_GET['ref_app'])){
                $val=$data['encrypt']->decryptIt($_GET['ref_app']);
                $data['currentUserid']=$val;
              }else{
                $data['currentUserid']=Auth::user()->id;
              }
              
            }else if(!empty($data['userid'])){
             $data['currentUserid']=$data['userid'];
              }else{
              $data['currentUserid']=Auth::user()->id;
            }
          //Notification
           $data['getNotification']=new Notification();
           $data['showNotification']=$data['getNotification']->getAllNotify($uid);
           $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
         $hk='';
         $userController = new UserController(); 
         /* Profile Image */
         //if(isset($request->profilepic)){
           // $data['profile-image']= $this->myProfileImage($request);
        //}

        /* Cover Image */
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $this->postCoverPhoto($request);
        }elseif($this->getPhoto('cover',$data['currentUserid'])){
            $data['cover-image']= $this->getPhoto('cover',$data['currentUserid']);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }

        /* Profile Image */
      if (!empty($request->profilepic)) {
            $data['profile-image']= $this->postProfilePhoto($request);
        }elseif($this->getPhoto('profile',$data['currentUserid'])){
            $data['profile-image']= $this->getPhoto('profile',$data['currentUserid']);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }  
        
        $data['userAllMetaData']  = $this->getUserInformation();

        /****check friend request exist or not ***/
       /****show get connection list ***/
        $data['userfriendlist']=$data['userConnections']->getUserConnectionList($uid);

       $data['reviewss']='no';
       if(Auth::check()){
       $uid = Auth::user()->id;
         $data['reviewscount']=Reviews::where('user_id', '=', $uid)->count();
        if($data['reviewscount']>0){
            $data['reviewss']=Reviews::where('user_id', '=', $uid)->orderBy('id', 'desc')->get();
             foreach ($data['reviewss'] as $key => $reviews) {
                if ($reviews->is_reply) {
                   $data['review_comments'][$reviews->id] = $userController->getReviewComments($reviews->id);
                }
            }
        }else{
            $data['reviewss']='no';
        }
       }
        /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
       
         $patientname =  User::where('id',$uid)->pluck('name');
          $name = $patientname[0];
           $timelinePostController = new TimelinePostController();
        // $postblog = $timelinePostController->getAllMyPost($uid); 
         $userController = new UserController();    
        
        $data['sharedpost']=new TimelineSharePost();
         //$comments =  $timelinePostController->getComment($postblog);
        $data['countlike']=new TimelinePostLike();
        $data['timlinepost']=new TimelinePost();
        $ajaxpost=new AjaxPostController();
        $newpost='';
        if(empty($request->shareid)){
            if (!empty($request->content) || !empty($request->post_image)) {
        $newpost = $timelinePostController->createNewPost($request); 
        }
        }
        
        $userpic=new User();
  
        $postblog = $timelinePostController->getPostByUid($uid); 
        $comments =  $timelinePostController->getComment($postblog);
        $html='';
        $data['checkconnection']=new UserConnection();
        if(!empty($postblog['timeline_post'])){
          foreach($postblog['timeline_post'] as $key => $postvalues){
           // if($uid==$postvalues->user_id){
               // echo $postvalues->user_id;
             $totallikes = $userController->getUserPostLikeById(['content_id'=>$postvalues->id]);
             $totallikesme = $userController->getPostLikeByMe(['user_id'=>$uid,'content_id'=>$postvalues->id]);                             
             $sharepost=$data['sharedpost']->getPostShareData(['post_id'=>$postvalues->id]);
             $parentPostCreatedTime = $this->getParentPostCreatedTime($postvalues->id,$uid);                                
            $html.=view('user.timeline.timeline-ajax-post',compact('data','postvalues','sharepost','uid','userController','userpic','comments','timelinePostController','parentPostCreatedTime'));
           // }
          }
        }


       /****check status 0 means request pending ***/
        $countrequest1=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->count();
        $data['userMetaObj2']  =  $data['userdatabyid'];
        if($countrequest1>0){
            $data['friendrequest']=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->orderBy('id', 'DESC')->get();
             $data['countrequests']=$countrequest1;
        }else{
             $data['countrequests']=0;
        }
       
       
         if ($request->ajax()) {
            return $html;
        }elseif ($newpost!='') {
        return redirect()->back();
        } else{
        return view('user.dashboard',compact('myphotos','myappoint','countlike','comments','timelinePostController','userController','data','searchdropdown','name','postblog'));
        }


    }
  
    public function edit(Request $request)
    {

        $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
        $data['userMetaObj'] = new UserMetum();
        $uid = Auth::user()->id;
        $data['userfollow']=new UserFollow();
        $data['rolename']=new RoleController();
        
        $data['myappoint'] = New AppointmentSetting();
         $timestamps = new DateTime();
         $data['success']='';
 // current user id
            $data['currentUserid']=''; 
            if(isset($_GET['ref_app'])){
              if(!empty($_GET['ref_app'])){
                $val=$data['encrypt']->decryptIt($_GET['ref_app']);
                $data['currentUserid']=$val;
              }else{
                $data['currentUserid']=Auth::user()->id;
              }
              
            }else if(!empty($data['userid'])){
             $data['currentUserid']=$data['userid'];
              }else{
              $data['currentUserid']=Auth::user()->id;
            }

        /****check friend request exist or not ***/
        $data['friendrequest']="";
        $data['countrequests']=0;
        /****check status 0 means request pending ***/
        $countrequest1=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->count();
        if($countrequest1>0){
            $data['friendrequest']=UserConnection::where([['status', '=', 0],['connect_user_id','=',$uid]])->get();
             $data['countrequests']=$countrequest1;
        }else{
             $data['countrequests']=0;
        }
        /* Cover Image */
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $this->postCoverPhoto($request);
        }elseif($this->getPhoto('cover',$data['currentUserid'])){
            $data['cover-image']= $this->getPhoto('cover',$data['currentUserid']);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
        /* Profile Image */
        if (!empty($request->profile_photo)) {
            $data['profile-image']= $this->postProfilePhoto($request);
        }elseif($this->getPhoto('profile',$data['currentUserid'])){
            $data['profile-image']= $this->getPhoto('profile',$data['currentUserid']);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        } 

       
        /* Edit data or add data of user */

        if($request->submit == 'Save & Continue' && $request->info_edit_form){

            $data['success']='Basic Information';
           $usernameupdate = User::where('id',$uid)->update(['name' => $request->fname]);

            $spec_string = serialize($request->specialties);
            //print_r($request->specialties);
            $fsize= sizeof($request->specialties);
            //$getallsp=UserMetum::where('user_id', '=', $uid)->where('user_meta_key', '=', 'user_specialties')->count();
                //if($fsize$getallsp){
                    $delallsp=UserMetum::where('user_id', '=', $uid)->where('user_meta_key', '=', 'user_specialties')->delete();
               // }
            for ($i=0; $i <$fsize ; $i++) { 
                $requestedData=$request->specialties;
                
                $key='user_specialties';
                if ($data['userMetaObj']->isUserMetaValueExist($uid,$key,$requestedData[$i]) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData[$i]
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                     $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData[$i]
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
            }

            

             $requestedArray = array(
                   /* 'user_specialties'      =>serialize($request->specialties),*/
                    'user_gender'           => $request->user_gender,
                    'user_website'          => $request->user_website,
                    'user_location'         => $request->user_location_title,
                    'user_address'          => $request->user_address,
                    'user_state'            => $request->user_state,
                    'user_county'           => $request->user_county,
                    'user_city'             => $request->user_city,
                    'user_number'           => $request->number,
                    'user_fax_number'       => $request->fax,
                    'user_zipcode'          => $request->user_zipcode,              
                    'user_certification'    => $request->certification
                
                );
            
            foreach ($requestedArray as $key => $requestedData) {
                if ($data['userMetaObj']->isUserMetaKeyExist($uid,$key) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                    $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
            }
        }  
        // professional details
        if($request->submit == 'Save & Continue' && $request->professional_details){ 
            $data['success']='Professional Details';
            $valuep=explode(',',  $request->proceduretags);
            $fsize= sizeof($valuep);

            for ($i=0; $i <$fsize ; $i++) {               
             $requestedData=$valuep;                
                $key='user_procedure';
                if ($data['userMetaObj']->isUserMetaValueExist($uid,$key,$requestedData[$i]) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData[$i]
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                     $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData[$i]
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
            }
            $valuep=explode(',',  $request->conditionstag);
            $fsize= sizeof($valuep);

            for ($i=0; $i <$fsize ; $i++) {                
                $requestedData=$valuep;
                
                $key='user_conditions';
                if ($data['userMetaObj']->isUserMetaValueExist($uid,$key,$requestedData[$i]) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData[$i]
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                     $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData[$i]
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
            }

            $requestedArray = array(
                   
                    'user_hospital_affiliations'          => $request->hospaffir,
                    'user_board_certification'          => $request->borad_cerft,
                    'user_memberships'            =>$request->prof_memb,
                    'user_professional_statement'     =>$request->prof_stat 
                );
            
            foreach ($requestedArray as $key => $requestedData) {
                if ($data['userMetaObj']->isUserMetaKeyExist($uid,$key) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                    $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
            }

        } 
        //education details

        if($request->submit == 'Save & Continue' && $request->educations){    
        $data['success']='Education Details';       
            $fsize= sizeof($request->education_types);
            for ($i=0; $i <$fsize ; $i++) { 
               
                $requestedArray = array(
                    'user_education_types'          => $request->education_types[$i],
                    'user_institute'           => $request->user_institute[$i],
                    'edu_from_year'          => $request->from_year[$i],
                    'edu_to_year'          => $request->to_year[$i]
                );
            
            foreach ($requestedArray as $key => $requestedData) {
               /* $getallsp=UserMetum::where('user_id', '=', $uid)->where('user_meta_key', '=', $key)->count();
                if($fsize>$getallsp){
                    $delallsp=UserMetum::where('user_id', '=', $uid)->where('user_meta_key', '=', $key)->delete();
                }*/
                if ($data['userMetaObj']->isUserMetaValueExist($uid,$key,$requestedData) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                    $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
              }
                
            }

        }  
        //save user selected insurance  data
        if($request->submit == 'Save & Continue' && $request->info_insurance){
            //if selected no insurance in provider then remove all insurance
            $data['success']='Availability Schedule';
            if($request->insuranceprovider=='No Insurance'){
                $check =UserInsurance::where('user_id','=',Auth::user()->id)->delete();
               
            }else{
            //add insurance
            $isurancePlan = (array)$request->insuranceplan;
            $fsize= $request->insuranceprovider;
            $insuranceArray =  array(); 
            $keys = array_keys($request->insuranceplan);

            foreach ($fsize as $key => $provider) {
                $value =  $keys[$key]; 
                $insuranceArray[$provider] =  serialize($isurancePlan[$value]);
                 if($request->removeplans){
                $check =UserInsurance::where([['user_id','=',Auth::user()->id],['insurance_name','=',$request->insuranceprovider[$key]]])->delete();
               
               }else{

                //insert into user insurance table
                $check =UserInsurance::where([['user_id','=',Auth::user()->id],['insurance_name','=',$request->insuranceprovider[$key]]])->count();
                if($check==0){
                $insura=new UserInsurance();
                $insura->user_id=Auth::user()->id;
                $insura->insurance_name=$request->insuranceprovider[$key];
                $insura->insurance_plan_name=serialize($isurancePlan[$value]);
                $insura->created_at=$timestamps;
                $insura->updated_at=$timestamps;
                $insura->save();
               }else{
                $check =UserInsurance::where([['user_id','=',Auth::user()->id],['insurance_name','=',$request->insuranceprovider[$key]]])->update(
                     array('insurance_plan_name' =>serialize($isurancePlan[$value])) );
                   
               
               }
                
            }
            }
           }
            

        }


        if ($request->submit == 'Save Changes' && $request->post_experience) {

        $data['success']='Past Experience';
             $requestedArray = array(
                    'user_past_hospital_name'          => $request->hospitalname,
                    'user_past_postition'           => $request->postition,
                    'user_past_work_city'          => $request->work_city,
                    'user_past_experience'          => $request->past_experience,
                    'user_past_from'          => $request->workfrom,
                    'user_past_to'          => $request->workto,
                );
            
            foreach ($requestedArray as $key => $requestedData) {
              
                if ($data['userMetaObj']->isUserMetaValueExist($uid,$key,$requestedData) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                    $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
              }

        } 

        if ($request->submit == 'Save' && $request->about_me) {
             $data['success']='about Me';
            if ($data['userMetaObj']->isUserMetaKeyExist($uid,'user_about_me') == 0) {
                $setUserMeta = array(
                    'user_id'           => $uid,
                    'user_meta_key'     => 'user_about_me',
                    'user_meta_value'   => $request->about_me
                );
                $data['userMetaObj']->setUserMeta($setUserMeta); 
            }else{
                $checkMeta = array(
                    'user_id'=> $uid, 
                    'user_meta_key'=> 'user_about_me'
                );
                $updateMeta = array(
                        'user_meta_key'     => 'user_about_me',
                        'user_meta_value'   => $request->about_me
                    );
                $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
            } 
        } 

        //other user save information 
         if($request->submit == 'Save Changes' && $request->user_info_edit_form){
             $data['success']='Basic Information';

            $usernameupdate = User::where('id',$uid)->update(['name' => $request->username]);
   
            $requestedArray = array(

                    'user_address'          => $request->address,
                    'user_number'           => $request->number,
                    'user_company'          => $request->company,
                    'user_website'          => $request->website
                );
            
            foreach ($requestedArray as $key => $requestedData) {
                if ($data['userMetaObj']->isUserMetaKeyExist($uid,$key) == 0) {
                    $setUserMeta = array(
                        'user_id'           => $uid,
                        'user_meta_key'     => $key,
                        'user_meta_value'   => $requestedData
                    );
                    $data['userMetaObj']->setUserMeta($setUserMeta); 
                }else{
                    $checkMeta = array(
                        'user_id'=> $uid, 
                        'user_meta_key'=> $key
                    );
                    $updateMeta = array(
                            'user_meta_key'     => $key,
                            'user_meta_value'   => $requestedData
                        );
                    $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
                } 
            }

        }  


        if ($request->submit == 'Save Changes' && $request->professional_statement) {
             $data['success']='Professional Statement';
            if ($data['userMetaObj']->isUserMetaKeyExist($uid,'user_professional_statement') == 0) {
                $setUserMeta = array(
                    'user_id'           => $uid,
                    'user_meta_key'     => 'user_professional_statement',
                    'user_meta_value'   => $request->professional_statement
                );
                $data['userMetaObj']->setUserMeta($setUserMeta); 
            }else{
                $checkMeta = array(
                    'user_id'=> $uid, 
                    'user_meta_key'=> 'user_professional_statement'
                );
                $updateMeta = array(
                        'user_meta_key'     => 'user_professional_statement',
                        'user_meta_value'   => $request->professional_statement
                    );
                $data['userMetaObj']->updateUserMeta($checkMeta, $updateMeta); 
            } 
        }    
        /*****appointment setting section ***/
/*****appointment setting section ***/
        if ($request->submit == 'Save & Continue' && $request->patient) {

             $data['success']='Availability Schedule';
            $day1 = serialize($request->timemonday);
            $day2 = serialize($request->timetuesday);
            $day3 = serialize($request->timewednesday);
            $day4 = serialize($request->timethursday);
            $day5 = serialize($request->timefriday);
            $day6 = serialize($request->timesaturday);
            $day7 = serialize($request->timesunday);
          //  echo 'rizwana'.$request->timemonday;
           

            if(!empty($request->timemonday)){  
            $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Monday']])->count();          
            if($countts>0){
            $updatess=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Monday']])->update(
               array( 
                'opening_time' =>$day1,
                'number_of_patients' =>0
                ));
            
            }else {
            $appointmentsetting = new AppointmentSetting();
            $appointmentsetting->user_id=Auth::user()->id;
            $appointmentsetting->opening_days ='Monday';
            $appointmentsetting->opening_time =$day1;
            $appointmentsetting->number_of_patients =0;
            $appointmentsetting->save();
            }
        }
            if(!empty($request->timetuesday)){  
            $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Tuesday']])->count();          
            if($countts>0){
            $updatess=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Tuesday']])->update(
               array( 
                'opening_time' =>$day2,
                'number_of_patients' =>0
                ));
            }else {
            $appointmentsetting = new AppointmentSetting();
            $appointmentsetting->user_id=Auth::user()->id;
            $appointmentsetting->opening_days ='Tuesday';
            $appointmentsetting->opening_time =$day2;
            $appointmentsetting->number_of_patients =0;
            $appointmentsetting->save();
            }
           }
            if(!empty($request->timewednesday)){    
            $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Wednesday']])->count();          
            if($countts>0){        
            $updatess=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Wednesday']])->update(
               array( 
                'opening_time' =>$day3,
                'number_of_patients' =>0
                ));
            
            }else{
            $appointmentsetting = new AppointmentSetting();
            $appointmentsetting->user_id=Auth::user()->id;
            $appointmentsetting->opening_days ='Wednesday';
            $appointmentsetting->opening_time =$day3;
            $appointmentsetting->number_of_patients =0;
            $appointmentsetting->save();
            }
        }
            if(!empty($request->timethursday)){
                $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Thursday']])->count();          
            if($countts>0){  
                $updatess=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Thursday']])->update(
               array( 
                'opening_time' =>$day4,
                'number_of_patients' =>0
                ));
            
            }else{
            $appointmentsetting = new AppointmentSetting();
            $appointmentsetting->user_id=Auth::user()->id;
            $appointmentsetting->opening_days ='Thursday';
            $appointmentsetting->opening_time =$day4;
            $appointmentsetting->number_of_patients =0;
            $appointmentsetting->save();
            }
        }
            if(!empty($request->timefriday)){
            $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Friday']])->count();          
            if($countts>0){  
                $updatess=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Friday']])->update(
               array( 
                'opening_time' =>$day5,
                'number_of_patients' =>0
                ));
            
            }else{

            $appointmentsetting = new AppointmentSetting();
            $appointmentsetting->user_id=Auth::user()->id;
            $appointmentsetting->opening_days ='Friday';
            $appointmentsetting->opening_time =$day5;
            $appointmentsetting->number_of_patients =0;
            $appointmentsetting->save();
            }
        }
            if(!empty($request->timesaturday)){
                $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Satuday']])->count();          
            if($countts>0){  
                $updatess=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Satuday']])->update(
               array( 
                'opening_time' =>$day6,
                'number_of_patients' =>0
                ));
            
            }else{

            $appointmentsetting = new AppointmentSetting();
            $appointmentsetting->user_id=Auth::user()->id;
            $appointmentsetting->opening_days ='Satuday';
            $appointmentsetting->opening_time =$day6;
            $appointmentsetting->number_of_patients =0;
            $appointmentsetting->save();
            }
        }
           if(!empty($request->timesunday)){
             $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Sunday']])->count();          
            if($countts>0){  
                $updatess=AppointmentSetting::where([['user_id','=',Auth::user()->id],['opening_days','=','Sunday']])->update(
               array( 
                'opening_time' =>$day7,
                'number_of_patients' =>0
                ));
            
            }else{

            $appointmentsetting = new AppointmentSetting();
            $appointmentsetting->user_id=Auth::user()->id;
            $appointmentsetting->opening_days ='Sunday';
            $appointmentsetting->opening_time =$day7;
            $appointmentsetting->number_of_patients =0;
            $appointmentsetting->save();
            }
        }

        //remove not available time 
        if($request->multifeatured)
        {
            $sizeremove=sizeof($request->multifeatured);
            for ($i=0; $i < $sizeremove; $i++) { 
                    if($request->multifeatured[$i]!=0){

                 $countts=AppointmentSetting::where([['user_id','=',Auth::user()->id],['id','=',$request->multifeatured[$i]]])->delete();  
            }
        }

        }
            
            
        }            
        
        $data['userInformationMetaData']  = $this->getUserInformation(); 
        //user selected insurance
        $data['userinsurance']=UserInsurance::where('user_id','=',Auth::user()->id)->get();
      
        /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();

           $patientname =  User::where('id',$uid)->pluck('name');
          $name = $patientname[0];

        return view('user.edit',compact('data','searchdropdown','name'));
    }




    /* Get User Pic of cover / profile if exist */
    public function getPhoto($type,$userid)
    {
        $userMetaObj = new UserMetum();
        if ($type == 'cover') {
            $checkMeta = array(
                'user_id'=> $userid, 
                'user_meta_key'=> 'user_cover_photo'
            );
        }elseif($type == 'profile'){

            $checkMeta = array(
                'user_id'=> $userid, 
                'user_meta_key'=> 'user_profile_photo'
            );
        }        
        $photoObj = $userMetaObj->getUserMeta($checkMeta);        
        if (!empty($photoObj)) {
            foreach ($photoObj as $key => $pObj) {
                return $photo = $pObj->user_meta_value;
            }
        }else{
            return 0;
        }        
    }

    /* Save cover photo updation */
    public function postCoverPhoto($request){

        /*$this->validate($request, [
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);  */      
         $data['getNotification']=new Notification();
        $data['getuserConnection']=new UserConnection();
        $uid=Auth::user()->id;
        $userNameFolder = str_replace(' ', '-', $uid ); 
        $upload_dir = public_path('user/'.$userNameFolder.'/cover/');
        if (!file_exists($upload_dir)) {
        File::makeDirectory($upload_dir, $mode = 0777, true, true);
        }
        $img = $request->cover_photo;

        $img = str_replace('data:image/png;base64,', '', $img);
               // print_r($img);
       // exit();
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $profilePhotoName=time(). ".jpg";
        $file = $upload_dir .time(). ".jpg";
        $success = file_put_contents($file, $data);
        //print $success ? $file : 'Unable to save the file.';
                //print_r($success.'======'.$profilePhotoName);
        //exit();
        $userMetaObj = new UserMetum();
        $setUserMeta = array(
                'user_id'           => $uid,
                'user_meta_key'     => 'user_cover_photo',
                'user_meta_value'   => '/user/'.$userNameFolder.'/cover/'.$profilePhotoName
            );
        $checkMeta = array(
                'user_id'=> $uid, 
                'user_meta_key'=> 'user_cover_photo'
            );        
        if ($userMetaObj->isUserMetaKeyExist(Auth::user()->id,'user_cover_photo') == 0) {
            $userMetaObj->setUserMeta($setUserMeta);
            //echo 'text';
         
        }else{
            $updateMeta = array(

                    'user_meta_key'     => 'user_cover_photo',
                    'user_meta_value'   => '/user/'.$userNameFolder.'/cover/'.$profilePhotoName
                );
              $userMetaObj->updateUserMeta($checkMeta, $updateMeta);
        }
         //exit();   
        $usermedia = new UserMedia();
        $usermedia->uid=Auth::user()->id;
        $usermedia->media ='/user/'.$userNameFolder.'/cover/'.$profilePhotoName;
        $usermedia->save(); 
        /*****upload post ***/
        
        $bn=array();

        $timelinepost = new TimelinePost();
        $timelinepost->user_id=$uid;
        $timelinepost->content ='';
        $timelinepost->like_user_id =serialize($bn);
        $timelinepost->comment_user_id =serialize($bn);
        $timelinepost->media_id =$usermedia->id;
        $timelinepost->post_type=0;
        $timelinepost->type =3;
        $timelinepost->status =0;
        $timelinepost->save();
        $last_id=$timelinepost->id;
        //create notification for connected people
       /* $getconntedlist= $data['getuserConnection']->getUserConnectionList($uid);
        if(sizeof($getconntedlist)>0){
            foreach ($getconntedlist  as $key => $valueConnected) {
                //check id 
                if($valueConnected->user_id!=$uid){
                    $data['addNotification']=$data['getNotification']->createNotification($valueConnected->user_id,$last_id,6);
                }else{
                     $data['addNotification']=$data['getNotification']->createNotification($valueConnected->connect_user_id,$last_id,6);
                }

            }
            
        }*/
        return '/user/'.$userNameFolder.'/cover/'.$profilePhotoName; 
        
    }

    /* Save profile pic updation */
    public function postProfilePhoto($request){
        $data['getNotification']=new Notification();
        $data['getuserConnection']=new UserConnection();
        $uid=Auth::user()->id;
        $userNameFolder = str_replace(' ', '-', Auth::user()->id ); 
        $upload_dir = public_path('user/'.$userNameFolder.'/profile/');
        if (!file_exists($upload_dir)) {
        File::makeDirectory($upload_dir, $mode = 0777, true, true);
        }
        $img = $request->profilepic;
        //print_r($img);
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $profilePhotoName=time(). ".jpg";
        $file = $upload_dir .time(). ".jpg";
        $success = file_put_contents($file, $data);
        print $success ? $file : 'Unable to save the file.';
        $user = Auth::user();
        $user->avatar ='/user/'.$userNameFolder.'/profile/'.$profilePhotoName;
        $user->save();
        $usermedia = new UserMedia();
        $usermedia->uid=Auth::user()->id;
        $usermedia->media ='/user/'.$userNameFolder.'/profile/'.$profilePhotoName;
        $usermedia->save(); 
        /*****upload post ***/
        
        $bn=array();
        $timelinepost = new TimelinePost();
        $timelinepost->user_id=$uid;
        $timelinepost->content ='';
        $timelinepost->like_user_id =serialize($bn);
        $timelinepost->comment_user_id =serialize($bn);
        $timelinepost->media_id =$usermedia->id;
        $timelinepost->post_type=0;
        $timelinepost->type =2;
        $timelinepost->status =0;
        $timelinepost->save();
        $last_id=$timelinepost->id;
        //create notification for connected people
      /*  $getconntedlist= $data['getuserConnection']->getUserConnectionList($uid);
       // print_r($getconntedlist);
        if(sizeof($getconntedlist)>0){
            foreach ($getconntedlist  as $key => $valueConnected) {
                //check id 
                if($valueConnected->user_id!=$uid){
                    $data['addNotification']=$data['getNotification']->createNotification($valueConnected->user_id,$last_id,6);
                }else{
                     $data['addNotification']=$data['getNotification']->createNotification($valueConnected->connect_user_id,$last_id,6);
                }

            }
            
        }*/
        
        return $success; 
    }

    /* Get user Information */
    public function getUserInformation()
    {
        /* Get user Data */
        $uid = Auth::user()->id;
        $userMetaObj = new UserMetum();
        $editArray = $userMetaObj->getUserMeta(['user_id' => $uid]);
        $userData = array();
        foreach ($editArray as $editDataKey) { 
           
            $userAllMetaData  = $userMetaObj->getUserMeta(['user_id' => $uid,'user_meta_key'=>$editDataKey->user_meta_key]);
            foreach ($userAllMetaData as $key => $userMetaData) {               
                if (!empty($userMetaData->user_meta_value)) { 
                    $userData[$editDataKey->user_meta_key]= $userMetaData->user_meta_value; 
                }                
            }
        }

        return $userData;
    }



    /* Get user connections */
    public function getUserConnections($uid)
    {
       $connectionObj = DB::table('user_connections')->where('status', '=', '1')->where(
        function ($query) use($uid) { 
            $query->where('user_id', '=', $uid)->orWhere('connect_user_id', '=', $uid);
        })
       ->get();
       $connections = array();
       $connections[] =  $uid;
       foreach ($connectionObj as $key => $connection) {
           $connections[] =  $connection->connect_user_id;
           $connections[] =  $connection->user_id;
       }       
       $connections = array_unique($connections, SORT_REGULAR);       
       return $connections;
    }

    /* Get user information by user id */
    public function getUserInformationById($uid)
    {
       $userInfoObj = DB::table('users')->where('id', '=', $uid)->get();
       $userInfo = array();
       foreach ($userInfoObj as $key => $user) {
            $userInfo =  array(
                'role_id'   => $user->role_id,
                'name'      => $user->name,
                'email'     => $user->email,                
            );
       }
       return $userInfo;
    }
/* Get user postlike by user id */
    public function getUserPostLikeById($contentid)
    {
        $userpostlike=array();

        $userpostlike= DB::table('timeline_post_like')->where('content_id', '=', $contentid)->count();

        return $userpostlike;
    }
/* Get user postlike by user id */
    public function getPostLikeByMe($contentid)
    {
        if(Auth::check()){
        $uid = Auth::user()->id;
        $postuserlike=0;
        $postuserlike= DB::table('timeline_post_like')->where('user_id','=',$uid)->orWhere('content_id','=',$contentid)->get();
        return $postuserlike;
        }else{
        return 0;
        }   
    }


/****people Search by name **/
public function autocomplete(Request $request)
    {
        $term=$request->term;
        $data = User::where('name','LIKE','%'.$term.'%')
        ->take(5)
        ->get();
        $a1=array();
        $a2=array();
        foreach ($data as $key => $v){
        $a1[]=['value' =>$v->name];
        }
        $data2 =DB::table('doctorlisting')->where('name','LIKE','%'.$term.'%')->where('id','<>',1)
        ->take(5)
        ->get();
        foreach ($data2 as $key => $vdoct){
        $a2[]=['value' =>$vdoct->name];
        }
        $results=array_merge($a1,$a2);
        return response()->json($results);
}

    /****people Search by name **/
    public function searchconnectname(Request $request)
    {
        $term=$request->term;
        $data = User::where('name','LIKE','%'.$term.'%')->where('id','<>',1)
        ->take(5)
        ->get();
        $a1=array();
        $a2=array();
        foreach ($data as $key => $v){
        $a1[]=['value' =>$v->name];
        }
       $data2 =DB::table('doctorlisting')->where('name','LIKE','%'.$term.'%')->where('id','<>',1)
        ->take(5)
        ->get();
       foreach ($data2 as $key => $vdoct){
        $a2[]=['value' =>$vdoct->name];
        }
        $results=array_merge($a1,$a2);
        return response()->json($results);
    }

    /* Get Review comments */
    public function getReviewComments($reviewId)
    {        
        $reviewHtml = array();
        $commentData = DB::table('review_comments')->where('review_id', '=' ,$reviewId )->orderBy('created_at', 'DESC' )->get();
        foreach ($commentData as $comment) {  
            /*echo "<pre>";
            print_r($comment);         
            echo "</pre>";    
            exit();*/     
            $userObj = new User();
            $id = $comment->id;
            $uid = $comment->comment_user_id;
            $userDataObj = $userObj->getUserData(['id' => $uid]);
            $html = '';
            foreach ($userDataObj as $key => $userData) {
                $userName = $userData->name;
                $userProf =  $userData->avatar;
            }
            $commentData = $comment->comment;
            $commentTime = $comment->created_at;
            $currentTime = date('Y-m-d H:i:s');
            $datetime1 = new DateTime($commentTime);
            $datetime2 = new DateTime($currentTime);
            $interval = $datetime1->diff($datetime2);
            $postedTime = 'Just Now';
            if ($interval->format('%i') < 60 && $interval->format('%i') > 2) {
                $postedTime = $interval->format('%i').' min ago';
            }elseif($interval->format('%i') > 60 && $interval->format('%h') < 24){
                $postedTime = $interval->format('%h')." hr ".$interval->format('%i')." min ago";
            }elseif($interval->format('%h') > 24){
                $postedTime = $interval->format('%d')." days ".$interval->format('%h')." Hours ".$interval->format('%i')." Minutes ago";
            }
            $reviewHtml[] = array(
                    'id'        => $id,
                    'uid'       => $uid,
                    'postId'    => $reviewId,
                    'comment'   => $commentData,
                    'userName'  => $userName,
                    'userProf'  => $userProf,
                    'commentTime'  => $postedTime
                );
        }       
        return $reviewHtml;
    }

    /* Get parent post created time */
    public function getParentPostCreatedTime($postId,$uid)
    { 
      //$parentPostData = DB::table('timeline_share_post')->where(['post_id'=>$postId, 'post_user_id'=>$uid] )->orderBy('created_at', 'DESC' )->get();
      $createdAt = '';
      $parentPostData = DB::table('timeline_post')
            ->join('timeline_share_post', 'timeline_post.id', '=', 'timeline_share_post.parent_post_id')
            ->select('timeline_post.created_at')
            ->where(['timeline_share_post.post_id'=>$postId])
            ->get();
      foreach ($parentPostData as $key => $parentData) {
        $createdAt = $parentData->created_at;
      }
      return $createdAt;
      /*echo "<pre>";
      print_r($parentPostData);
      echo "</pre>";*/
    }


}
