<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TimelinePost extends Model
{
	protected $table = 'timeline_post';
	public $timestamps = false;

	/* Set timeline post data */
	/*public function save($data = ''){
		$postId = isset($data['id']) ? $data['id'] : 0;
		if (checkPost($postId)) {
			$data['updated_at'] = $timestamps;
			UserMetum::where('id', '=', $postId)->update($data);
		}else{
			$insertedRecord = UserMetum::insert($data);
			$postId = $insertedRecord->lastInsertId();
		}
		return $postId;
	}

    /* Check if post alreday exist with this ID */
    /*protected  function checkPost($postId = ''){
    	$postExist = TimelinePost::where('id', '=', $postId)->get();
        if ($postExist->count() > 0) {
        	return 1;
        }else{
        	return 0;
        }
    }*/



     //save post
    public function saveTimeLinePost($uid,$contents,$mediaId,$postType,$type)
    {
    	$absh=array();
    	$timelinepost = new TimelinePost();
        $timelinepost->user_id=$uid;
        $timelinepost->content =$contents;
        $timelinepost->like_user_id =serialize($absh);
        $timelinepost->comment_user_id =serialize($absh);
        $timelinepost->media_id =$mediaId;
        $timelinepost->post_type =$postType;
        $timelinepost->type =$type;
        $timelinepost->status =0;
        $timelinepost->save();
        return $timelinepost;
    }


    public function getPostDataById($postid)
    {
    	
    	 $timelinepost= TimelinePost::where('id','=',$postid)->get();
        return $timelinepost;
    }

    
}
