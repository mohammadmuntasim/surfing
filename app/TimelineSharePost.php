<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TimelineSharePost;

class TimelineSharePost extends Model
{
    protected $table = 'timeline_share_post';
    public $timestamps = false;

     /****save shared post created user data ***/
     public function saveTimeLineSharePost($last_id,$createdUserId,$shareUserId,$postParentId)
    {

        $timelinepostshare = new TimelineSharePost();            
        $timelinepostshare->post_id =$last_id;
        $timelinepostshare->post_user_id=$createdUserId;
        $timelinepostshare->share_user_id =$shareUserId;
        $timelinepostshare->parent_post_id=$postParentId;      
        $timelinepostshare->save();
        return $timelinepostshare;
    } 
    /****find shared post created user data ***/
     public function getPostShareData($postid)
    {
        return TimelineSharePost::where($postid)->get();
    } 
    /****find shared post created user data ***/
     public function getShareCount($postid)
    {

      $sharecount= TimelineSharePost::where($postid)->count();
        return $sharecount;
    } 
}
