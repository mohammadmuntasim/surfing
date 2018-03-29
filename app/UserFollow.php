<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\UserFollow;
class UserFollow extends Model
{
	protected $table='user_follow';
	public $timestamps = true;
	//User Following and followers
	public function  UserFollowing($userid){
	return UserFollow::where($userid)->get();
	}
    // count following and followers
	public function  CountFollowing($userid){
	return UserFollow::where($userid)->count();
	}
}