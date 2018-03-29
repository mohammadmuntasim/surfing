<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\UserMetum;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\UserConnection;
use Illuminate\Http\Response;
use App\Notification;
use Auth;
use App\Reviews;
use App\UserInsurance;

class SearchController  extends Controller
{
	/*****search code start***/
	public function index()
	{
		$data['rolename']=new RoleController();
		   $data['getreviews']=new Reviews();
		  $header=new HeaderController();
        $data=$header->headerAfterLogin($request);
		  $data['userConnections']=new UserConnection();
                if(Auth::check()){
                $userid= Auth::user()->id;
                }else{
                $userid=0;
                }
                //Notification
                $data['getNotification']=new Notification();
               $data['showNotification']=$data['getNotification']->getAllNotify($userid);
               $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($userid);
                       $data['encrypt']=new EndecryptController();
		//if($request){
		$search = ''; //<-- we use global request to get the param of URI
		$userMetaObj = new UserMetum();
                $data['userConnection']=new UserConnection();        
		$searcexist='';
		/**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
		/*$myusersdata= DB::table("users")->join('user_meta', 'users.id', '=', 'user_meta.user_id')->where('role_id', '=', 2)->get();*/
		$usertablename='no';
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
		return view('pages.search',compact('data','userMetaObj','searcexist','searchdropdown','usertablename'));
	//}
	}
	public function searchvalue(Request $request)
	{	
		
		//UserMetum
		$data['rolename']=new RoleController();
		 $data['getreviews']=new Reviews();
		$data['userdatabyid']=new User();
       
         $data['userConnections']=new UserConnection();
		if(Auth::check()){
                $userid= Auth::user()->id;
                }else{
                $userid=0;
        }
		//Notification
        $data['encrypt']=new EndecryptController();
 		$data['getNotification']=new Notification();
        $data['showNotification']=$data['getNotification']->getAllNotify($userid);
        $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($userid);
		if($request){
		$searchLocation1 = \Request::get('locations'); 
		//break address
		$searchLocation2=explode(' ', trim($searchLocation1));
		$searchLocation=$searchLocation2[0];
		$searchInsuranceprovider = \Request::get('insur_provider');
		$searchspecialityid = \Request::get('speciality_id');
		$roleid = \Request::get('role_id');
		$dentisname=trim(\Request::get('keysearch'));
		$searchbyname=trim(\Request::get('namekeysearch'));
		if($dentisname!=''){
			$searchbyname=$dentisname;
		}

		if($searchInsuranceprovider=='No Insurance')
		{
			$searchInsuranceprovider='';
		}
		$userMetaObj = new UserMetum(); 
		$searchresult3='';


		$search='';
		$searchresult='';
		$searchcount0 = UserMetum::where([['user_meta_value', '=', $searchspecialityid]])->count();
		$totalsearchcount2 = UserMetum::where([['user_meta_value', '=', $searchLocation]])->count();
		$totalsearchcount = UserMetum::where([['user_meta_value', '=', $searchspecialityid]])->count();
		// SEARCH IF ALL THREEE CATEGORY ARE TRUE
		if(!empty($searchInsuranceprovider) && !empty($searchLocation) && !empty($searchspecialityid))
		{
			$allMatchedQuery = DB::table('user_meta')
		            ->join('user_insurance', 'user_meta.user_id', '=', 'user_insurance.user_id')
		            ->where('insurance_name', $searchInsuranceprovider)
		            ->where('user_meta_key','=','user_address')
					->where('user_meta_value','like','%'.$searchLocation.'%')
					->get();


			if(count($allMatchedQuery)==0)
			{
					$searchresult=0;
			}	
			else
			{
				foreach ($allMatchedQuery as $key => $value){
					
					$searchresult = UserMetum::where('user_meta_value','=',$searchspecialityid)
										->where('user_id', $value->user_id)
									   ->paginate(30);

				}
			}	


		}
		//  SEARCH IF ANY TWO CATEGORY ARE TRUE
		elseif((!empty($searchInsuranceprovider) && !empty($searchspecialityid))  || (!empty($searchInsuranceprovider) && !empty($searchLocation)) || (!empty($searchspecialityid) && !empty($searchLocation)))
		{
			// SEARCH IF INSURACNE AND SPECL TRUE
			if(!empty($searchInsuranceprovider) && !empty($searchspecialityid))
			{	

				
				$searchresult = DB::table('user_meta')
		            ->join('user_insurance', 'user_meta.user_id', '=', 'user_insurance.user_id')
		            ->where('insurance_name', $searchInsuranceprovider)
		            ->where('user_meta_key','=','user_specialties')
					->where('user_meta_value','like',$searchspecialityid)
		            ->paginate(30);
		       
		        if(count($searchresult)==0)
		        {
		        	$searchresult=0;

		        }
		     

			}

			// SEARCH IF INSURANCE AND LOCATION IS TRUE
			elseif(!empty($searchInsuranceprovider) && !empty($searchLocation))
			{
				$count = DB::table('user_address_view')
		 			->join('user_insurance', 'user_address_view.user_id','=','user_insurance.user_id')
		 			->where('insurance_name','=',$searchInsuranceprovider )
		 			->where('user_address','like','%'.$searchLocation.'%')
		 			->where('user_role', '=', $roleid)
		 			->count();

		 			if($count>0)
		 			{
		 				$searchresult = DB::table('user_address_view')
		 			->join('user_insurance', 'user_address_view.user_id','=','user_insurance.user_id')
		 			->where('insurance_name','=',$searchInsuranceprovider )
		 			->where('user_address','like','%'.$searchLocation.'%')
		 			->where('user_role', '=', $roleid)
		 			->paginate(30);
		 			}
		        else
		        {
		        	$searchresult=0;
		        }
			}

			// SEARCH IF SPECL AND LOCATION ARE TRUE
			elseif(!empty($searchspecialityid) && !empty($searchLocation)) 
			{

				$count = DB::table('user_address_view')
		 			->join('user_specialties_view', 'user_address_view.user_id','=','user_specialties_view.user_id')
		 			->where('user_specialties_view.user_specialties','=',$searchspecialityid )
		 			->where('user_address_view.user_address','like','%'.$searchLocation.'%')
		 			->count();

		 			if($count>0)
		 			{
				
		 				$searchresult = DB::table('user_address_view')
		 			->join('user_specialties_view', 'user_address_view.user_id','=','user_specialties_view.user_id')
		 			->where('user_specialties','=',$searchspecialityid )
		 			->where('user_address','like','%'.$searchLocation.'%')
		 			->paginate(30);
		 			}
		 			else
		 			{
		 				$searchresult=0;

		 			}
				
			}	
		}
		// SINGLE SEARCH TRUE CONDITIONS
		else
		{

			if(!empty($searchspecialityid))
			{	
				
				$count=UserMetum::where([['user_meta_value', '=', $searchspecialityid]])->count();
				if($count>0)
				{

					$searchresult=UserMetum::where([['user_meta_value', '=', $searchspecialityid]])->paginate(30);
				}
				else
				{
					$searchresult=0;
				}	
				
			}
			elseif(!empty($searchLocation))
			{

				$search = DB::table('user_address_view')->where([['user_address', 'like', '%'.$searchLocation.'%']])->where('user_role', '=', $roleid)->paginate(30);
				if($search->count() > 0)
				{
					$searchresult = $search;
				}
				else
				{
					$searchresult=0;
				}
				
			}
			elseif(!empty($searchInsuranceprovider))
			{
				$count=UserInsurance::where('insurance_name',$searchInsuranceprovider)->count();
				if($count>0)
				{				

					$search=UserInsurance::where('insurance_name',$searchInsuranceprovider)->get();
				
					foreach ($search as  $value) 
					{
						$rr = $data['rolename']->RoleId($value->user_id);
						
						if($roleid == $rr[0])
						{

							$searchresult=UserInsurance::where('insurance_name',$searchInsuranceprovider)->paginate(30);
							
					
						}
					
					}
				}
				else
				{
					$searchresult=0;
				}
				
			}
			
		}

	



		/**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
		$usertable='';
		$usertablename='no';
		if($searchbyname!=''){
			if($dentisname!='' && $searchLocation==''){
				$usertablename = DB::table('users')->where('name','like','%'.$searchbyname.'%' )->where('role_id','=',$roleid)->paginate(30);
			}else{
				$usertablename = DB::table('users')->where('name','like','%'.$searchbyname.'%' )->paginate(30);
			}


		}
		//search from hospital name and address
		if($dentisname!='' && $searchLocation!=''){
			$searchresult = DB::table('user_address_view')
		 			->join('users', 'user_address_view.user_id','=','user.id')
		 			->where('name','=',$dentisname )
		 			->where('user_address','like','%'.$searchLocation.'%')
		 			->paginate(30);
		 			if(sizeof($searchresult)==0){
		 				$searchresult=0;
		 			}
		}

		$datacookie['sname']=$searchbyname;
		$datacookie['spid']=$searchspecialityid;
		$datacookie['locations']=$searchLocation;
		$datacookie['hosname']=$dentisname;
		if(!empty($searchInsuranceprovider)){
		$datacookie['insup']=$searchInsuranceprovider;
		}
			
		$bh=new Response();
        $data['specilaity']=$bh->withCookie(cookie('sbyname', $datacookie, 60));

		
        //exit();
		return view('pages.search',compact('data','userMetaObj','search','searchresult','searchdropdown','usertablename'));
		}
	}
	/*****search code end ***/

	
}



