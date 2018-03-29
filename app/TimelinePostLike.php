<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TimelinePostLike extends Model
{
    protected $table = 'timeline_post_like';
	public $timestamps = true;
    public function TotalLikeByPostId($postid){
     return TimelinePostLike::where($postid)->count();
    }
   
}
