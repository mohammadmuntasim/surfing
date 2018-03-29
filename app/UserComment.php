<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class UserComment extends Model
{
    protected $table = 'user_comment';		
    	public $timestamps = false;
	protected $fillable = [
         'content_id','comment_userid', 'comment','typeof_comment',

    ];
   
   function getreplyusername($uid)
    {
    	$getreplyusername = DB::table('users')->where('id',$uid)->pluck('name');

    	return $getreplyusername[0];
    }
}
