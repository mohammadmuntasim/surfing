<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class ConnectionTimelinePost extends Model
{
     protected $table = 'connection_timeline_post';
    public $timestamps = false;
    //post on connected user timeline
     public function saveConnectedTimelinePost($postid,$post_user_id,$post_on_userid)
    {
    	$timelinepost = new ConnectionTimelinePost();
        $timelinepost->post_id=$postid;
        $timelinepost->post_user_id =$post_user_id;
        $timelinepost->posted_on_user_id =$post_on_userid;
        $timelinepost->save();
        return $timelinepost;
    }
    //get user id of user who posted on timeline and which user
     public function getUserDataTimelinePosted($postid)
    {
    	
    	$timelinepostConnected=ConnectionTimelinePost::where('post_id','=',$postid)->get();
    	return $timelinepostConnected;
    }
}
