<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Cmgmyr\Messenger\Models\Participant;
use Auth;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /* Get user meat of specific field */
    public function getUserData($checkMetaArray){
        $userinfo=User::where($checkMetaArray)->get();
            
        return $userinfo;
    }

     /***get user insurance provider by user id function **/
    public function getInsuranceProviderByUserid($userid)
    {
      $userInsurance= DB::table('user_insurance')->where('user_id','=',$userid)->distinct()->pluck('insurance_name');
      return $userInsurance;
    }

     /***get Claim profile **/
    public function claimProfile($userid)
    {
      $userInsurance= UserVerification::where('user_id','=',$userid)->where('status','=',1)->count();

      return $userInsurance;
    }
    /***search dropdown function **/
    public function getSearchDropdownList()
    {
       $searchdropdown['providers'] = DB::table('insurance_providers')->get();
       $searchdropdown['insurances'] = DB::table('insurance_providers')->distinct()->pluck('insur_provider');
       /* Fetch doctor speciality list record from speciality viw of user meata speciality field*/
       $searchdropdown['docspeciality'] = DB::table('doctorspeciality')->OrderBy('speciality','ASC')->distinct()->get();
       //edit section
      


       /* Fetch dentists speciality list record from speciality viw of user meata speciality field*/
       //$searchdropdown['denspeciality'] = DB::table('dentists_specility_list')->OrderBy('denspeciality','ASC')->distinct()->get();
       //edit section
       $searchdropdown['denspeciality'] = DB::table('dentist_speciality')->OrderBy('denspeciality','ASC')->distinct()->get();

       $searchdropdown['wellnessspeciality'] = DB::table('wellness_speciality')->OrderBy('well_speciality','ASC')->distinct()->get();
       $searchdropdown['eldercarespeciality'] = DB::table('eldercare_speciality')->OrderBy('elder_speciality','ASC')->distinct()->get();
       $searchdropdown['states'] = DB::table('state_county_city')->OrderBy('state','ASC')->distinct()->pluck('state');
        $searchdropdown['county'] = DB::table('state_county_city')->OrderBy('county','ASC')->distinct()->pluck('county');
       return $searchdropdown;
    }
    
     /*public function getAvatarAttribute()
    {
        return new LetterAvatar($this->name);

    }
*/
   /* public function getAvatarAttribute($threadId)
    {
      $threads='';
       // if($threadId!=0 && $threadId!='' && $threadId==null){
         $threads1 = Participant::where([['thread_id','=', $threadId],['user_id','<>', Auth::user()->id]])->get();
         foreach ($threads1 as $key => $threads1) {
          $threads= User::where('id','=', $threads1->user_id)->pluck('avatar');
         }
       
        return  $threads;
    }
*/
}
