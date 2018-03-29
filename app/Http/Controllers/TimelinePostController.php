<?php

namespace App\Http\Controllers;


use Auth;
use DB;
use Illuminate\Http\Request;
use App\TimelinePost;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\TimelinePostLike;
use App\TimelineSharePost;
use App\UserMedia;
use Response;
use File;
use App\ConnectionTimelinePost;
class TimelinePostController extends Controller
{

	  public function createNewPost($request)
    {
        
        $content = \Request::get('content');
        $posttimeline=new TimelinePost();
        $timelineshare=new TimelineSharePost();
        /* Profile Image */       

        $uid = Auth::user()->id;
        $contents='';

        $uploadimage=$request->post_image;
        $mediaId=0;
        //upload image
        if (!empty($request->post_image)) {
            $data['post_image']= $this->postPhoto($request);
            $mediaId=$data['post_image'];
        }
            
        $postType=0;
        $type=0;
        $timelinepost=0;

        if($content!=''){
            $contents=$content;
        }

        $absh=array();
        ///inser new post
        $timelinepost=$posttimeline->saveTimeLinePost($uid,$contents,$mediaId,$postType,$type);
       
        
       return $timelinepost;
    }

    //share post
     public function createNewSharePost(Request $request)
    {
        
        $content = \Request::get('content');
        $posttimeline=new TimelinePost();
        $timelineshare=new TimelineSharePost();
        /* Profile Image */       

        $uid = Auth::user()->id;
        $contents='';

       
        $mediaId=0;
      	//upload image
        if (!empty($request->post_image)) {
            $data['post_image']= $this->postPhoto($request);
            $mediaId=$data['post_image'];
        }
       
        $postType=0;
        $type=0;
        $timelinepost=0;

        if($content!=''){
            $contents=$content;
        }

          $absh=array();
         if(isset($request->shareid)){
            $cdd=$request->scd;
           $sharedcontent='';
            $getinforpost=TimelinePost::where('id','=',$request->shareid)->get();
            foreach ($getinforpost as $getinforpostvalue) {
                if($cdd!='')
                $sharedcontent=$cdd;
                }
                 /****insert new share post ***/
                $timelinepost=$posttimeline->saveTimeLinePost($uid,$sharedcontent,$getinforpostvalue->media_id,$postType,1);
                $last_id = $timelinepost->id;
                 /****insert new share post data ***/
                $timelinepostshare =$timelineshare->saveTimeLineSharePost($last_id,$getinforpostvalue->user_id,$uid,$getinforpostvalue->id);         
                
               
            } 
             
       return Response::json($timelinepost);
    }

    /* save connection  timeline post data*/
    public function createNewConnectionPost($request,$post_on_userid)
    {	
    	//update timeline post
    	$content = \Request::get('content');
        $posttimeline=new TimelinePost();
        $timelineshare=new TimelineSharePost();
        /* Profile Image */       

      
        $contents='';

        $uploadimage=$request->post_image;
        $mediaId=0;
        //upload image
        if (!empty($request->post_image)) {
            $data['post_image']= $this->postPhoto($request);
            $mediaId=$data['post_image'];
        }
            
        $postType=0;
        $type=0;
        $timelinepost=0;

        if($content!=''){
            $contents=$content;
        }

        $absh=array();
        ///inser new post
        $timelineposts=$posttimeline->saveTimeLinePost(Auth::user()->id,$contents,$mediaId,$postType,0);
        $timelinepost = new ConnectionTimelinePost();
        $timelinepost->post_id=$timelineposts->id;
        $timelinepost->post_user_id =Auth::user()->id;
        $timelinepost->posted_on_user_id =$post_on_userid;
        $timelinepost->save();
    	
        return $timelinepost;
    }


     /* Save profile pic updation */
    public function postPhoto($request){
       /* $this->validate($request, [
            'post_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:402400',
        ]);  */      
        $data['usermedia'] = new UserMedia();
        
        $userNameFolder = str_replace(' ', '-', Auth::user()->id ); 
        $profilePath = public_path('user/'.$userNameFolder.'/post');
        $extension=array("jpeg","jpg","png","gif");
        if (!file_exists($profilePath)) {
            File::makeDirectory($profilePath, $mode = 0777, true, true);
        }
        $last_id=0;
       
      if(!empty($_FILES["post_image"]["tmp_name"]))
        {           
        
             
             $file_name=str_random(3).'-' .time(). '.jpg';
 
             $file_tmp=$_FILES["post_image"]["tmp_name"];
              
             $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            
             if (!file_exists($profilePath)) {
                 File::makeDirectory($profilePath, $mode = 0777, true, true);
             }
 
             $filesize = $_FILES['post_image']['size'];
               
             print_r($filesize);
             if(in_array($ext,$extension))
             {   
                 if(!file_exists($profilePath."/".$file_name))
                 {                 
                     if($filesize> 2097152)
                     {   
                         $fileDestination = $profilePath."/".$file_name;
                         move_uploaded_file($file_tmp=$_FILES["post_image"]["tmp_name"],$fileDestination);
                         // optimize
                         $compressImg = $profilePath.'/compress-img/';
                         if (!file_exists($compressImg)) {
                             File::makeDirectory($compressImg, $mode = 0777, true, true);
                         }
                         $check = $newAlbum->compress($fileDestination,$compressImg."/".$file_name, 20);
                         unlink($fileDestination);
                         $imageUrl ='/user/'.$userNameFolder.'/post/compress-img/'.$file_name;
                         //save image in media
                         $usermedia=$data['usermedia']->saveMedia($imageUrl,0);
                          $last_id=$usermedia->id;
                     }else
                     {
                         move_uploaded_file($file_tmp=$_FILES["post_image"]["tmp_name"],$profilePath."/".$file_name);
                         //save image in media
                         $imageUrl ='/user/'.$userNameFolder.'/post/'.$file_name;
                         $usermedia=$data['usermedia']->saveMedia($imageUrl,0);
                         $last_id=$usermedia->id;
                     }
 
                 }        
             }
             else
             {
                 array_push($error,"$file_name,");
             }
         
        }
    
        
        return $last_id;
    }
    

	/* Get All Post for this user connection  */
	public function getAllPost($uid)
	{      
		$userController = new UserController(); 
		$roleController = new RoleController(); 
		$connectedUserArray = $userController->getUserConnections($uid); 
               
		$timelinePost = array();
		foreach ($connectedUserArray as $key => $connectedUserId) {
		$timelinePostObj = TimelinePost::where('user_id',$connectedUserId)->where('status','=', '0')->orderBy('id', 'DESC')->paginate(5);
			foreach ($timelinePostObj as $key => $timeline_post) {
                  
				$timelinePost['timeline_post'][] = $timeline_post;
			}
			
		}
		if (!empty($timelinePost['timeline_post'])) {
			usort($timelinePost['timeline_post'], array($this, "sortTimelinePostByCreatedDate"));
			foreach ($timelinePost['timeline_post'] as $key => $timelinePostValue) {
				$connectedUserId = $timelinePostValue->user_id;

				$userInfo = $userController->getUserInformationById($connectedUserId);

				$timelinePost['user_name'][] = $roleController->getRoleName($userInfo['role_id']).' '.$userInfo['name'];

			}
		}

		return $timelinePost;
	}

	public function getAllMyPost($uid)
	{      
		$userController = new UserController(); 
		$roleController = new RoleController(); 
		
        $uid = Auth::user()->id;
        $connectedUserArray = $userController->getUserConnections($uid); 
		$timelinePost = array();
		foreach ($connectedUserArray as $key => $connectedUserId) {
		$timelinePostObj = TimelinePost::where('user_id',$uid)->where('status','=', '0')->orderBy('id', 'DESC')->paginate(5);
			foreach ($timelinePostObj as $key => $timeline_post) {                  
				$timelinePost['timeline_post'][] = $timeline_post;
			}
			
		}
		if (!empty($timelinePost['timeline_post'])) {
			usort($timelinePost['timeline_post'], array($this, "sortTimelinePostByCreatedDate"));
			foreach ($timelinePost['timeline_post'] as $key => $timelinePostValue) {
				$connectedUserId = $timelinePostValue->user_id;
				$userInfo = $userController->getUserInformationById($connectedUserId);
				$timelinePost['user_name'][] = $roleController->getRoleName($userInfo['role_id']).' '.$userInfo['name'];

			}
		}
		

		return $timelinePost;
	}

	/* Get All Post of this user  */
	public function getPostByUid($uid)
	{  //echo $uid;
		$userController = new UserController(); 		 
		$roleController = new RoleController(); 
        $data['otherUserTimelinePosted']=new ConnectionTimelinePost();

        $timelinePost['timeline_post'] =TimelinePost::whereIn('id', ConnectionTimelinePost::select('post_id')->where('posted_on_user_id','=',$uid)->get()) 
                    ->orwhere('user_id','=',$uid) 
                    ->orderBy('created_at','DESC')                    
                    ->paginate(30);
  
       
		$userInfo = $userController->getUserInformationById($uid);
        if(sizeof($userInfo)>0){
		$timelinePost['user_name'] = $roleController->getRoleName($userInfo['role_id']).' '.$userInfo['name'];
        }
		return $timelinePost;
	}	

	function sortTimelinePostByCreatedDate($a, $b)
	{
		$pervPostDate = strtotime($a->created_at);
		$nextPostDate = strtotime($b->created_at);
		if ($pervPostDate>$nextPostDate) {
			return -1;
		}else{
			return 1;
		}
	}
        
      function getComment($postdetails)
	{

		   $comment=array();
	          
		if(!empty($postdetails['timeline_post']))
		{
                    foreach ($postdetails['timeline_post'] as  $values) {
	 	
		 	// for($i=0;$i<sizeof($values);$i++)
		  //        {
				 		
				//  		if(!is_object($values[$i]))
				//  		{
				//  		 	$comment[] = DB::table('user_comment')->where('content_id',$values->id)->get();
				 		 	

				//  		}
				//  		else
				 		
				//  		$comment[] = DB::table('user_comment')->where('content_id',$values[$i]->id)->get();
				 		
				 		
			 //  }
  		 }
               }
  			 
				  	        foreach ($comment as $valuedd) 
				               {
				  		  foreach ($valuedd as $replies)
				  	          {	
					          $comment[] = DB::table('user_comment')->where([['content_id',$replies->id],['typeof_comment',1]])->get();

						   }
		 				}
			
		return $comment;
         

	}

   function totalcomment($id)
	{
		$commentcount = DB::table('user_comment')->where('content_id',$id)->count();

				

				return $commentcount;

	}

	function replycount($id)
	{
		 $repliescount = DB::table('user_comment')->where([['content_id',$id],['typeof_comment',1]])->count();

	        return $repliescount ;

	}
       function mycomments($postid)
	{
				$comment = DB::table('user_comment')->where('content_id',$postid)->get();

				

				return $comment;
	}

	function commentreplies($contentid)
	{
		
	         			 $replies = DB::table('user_comment')->where([['content_id',$contentid],['typeof_comment',1]])->get();

	         			 return $replies;

		  		
	}
	
}