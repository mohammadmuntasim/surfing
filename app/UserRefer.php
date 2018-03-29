<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserRefer extends Model
{
     protected $table='user_refer';
	 public $timestamps = true;

	  //User Refer data
    public function getReferData($postid){
        $reqRefer=UserRefer::where('id', '=', $postid)->get(); 
        return $reqRefer;
    }

}
