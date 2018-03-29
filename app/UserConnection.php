<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserConnection extends Model
{
   protected $table = 'user_connections';
   public $timestamps =  false;
       // get user in connection  or not it counts by user id
	public function  getConnnected($loginuserid,$userid){
	return UserConnection::where([['user_id', '=', $loginuserid],['connect_user_id','=',$userid]])->orWhere([['user_id', '=', $userid],['connect_user_id','=',$loginuserid]])->get();

	}
	//insert connenction 
	public function  setUserConnection($uid,$senderid){	
		$reqConnection = new UserConnection();
        $reqConnection->user_id=$uid;
        $reqConnection->connect_user_id =$senderid;
        $reqConnection->status ='0';
        $reqConnection->save();
	    return $reqConnection;
	}
	//delete  connenction 
	public function deleteUserConnection($connectionid){
        $reqConnection=UserConnection::where('id', '=', $connectionid)->delete();
	    return $reqConnection;
	}
	//Accept  connenction 
	public function acceptUserConnection($uid,$senderid){
        $reqConnection=UserConnection::where([['user_id', '=', $uid],['connect_user_id','=',$senderid]])->update( array(
                    'status' => '2',
                    )); 
	    return $reqConnection;
	}

	//Accept  connenction 
	public function getUserConnectionList($uid){
        $reqConnection=UserConnection::where([['user_id', '=', $uid],['status','=',1]])->orWhere([['connect_user_id','=',$uid],['status','=',1]])->orderBy('updated_at', 'DESC')->get(); 
        
	    return $reqConnection;
	}

	//Accept  connenction 
	public function getUserConnectionListPending($uid){
        $reqConnection=UserConnection::where([['connect_user_id','=',$uid],['status','=',0]])->orderBy('updated_at', 'DESC')->get(); 
	    return $reqConnection;
	}
}
