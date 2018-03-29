<?php

namespace App\Http\Controllers;

use View;
use Auth;
use File;
use Illuminate\Http\Request;
use App\UserMetum;
use DB;

class RoleController extends Controller
{
	/*Get Role Information */
	public function getRoleName($roleId)
	{
		$roleObj = DB::table('roles')->where('id', '=', $roleId)->get();
		$role = '';
		foreach ($roleObj as $key => $role) {
			 
			$role = $role->display_name;			
		}
               if($role!='Dr.'){$role='';}
		return $role;
	}
        
       public function checkRole($roleId)
	{
		$roleObj = DB::table('roles')->where('id', '=', $roleId)->get();
		$role = '';
		foreach ($roleObj as $key => $role) {
			 
			$role = $role->display_name;			
		}
               
		return $role;
	}
	public function SearchedUserRole($id)
	{
		$roledetail = DB::table('users')->where('id', '=', $id)->pluck('role_id');
		$roleObj= DB::table('roles')->where('id','=',$roledetail)->pluck('display_name');
	
		return $roleObj[0];
	}

	public function RoleId($rid)
	{
		$roleids = DB::table('users')->where('id','=',$rid)->pluck('role_id');

		return $roleids;
	}


}