<?php

namespace App\Http\Controllers;
use DB;
use View;
use App\TimelinePost;
//use App\TimelinePostLike;
use App\Http\Requests;
//use File;
//use Exception;
use Illuminate\Http\Request;
use DateTime;
use Auth;
//use App\UserMetum;
//use App\Http\Controllers\TimelinePostController;
use Response;
//use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\UserComment;
use App\User;

// use App\Http\Controllers\TimelinePostController;
class AjaxCommentController  extends Controller
{
    

   
     public function timelinepostcommentajaxrequests(Request $request)
    {   
       $absh=array();
        $uid = Auth::user()->id;
        $content =$request->all();
        // $request = json_decode($content['data']); 
        $timestamps = new DateTime();
       
       if($request->type==0)
       {

           $user = DB::table('user_comment')->insert(array(
            'content_id'        => $request->statusid,
            'comment_userid'    => $uid,
            'comment'           => $request->comment,
            'typeof_comment'    => $request->type,
            'created_at'        => $timestamps,
            'updated_at'        => $timestamps,
            ));
                $countcomment=UserComment::where([['comment_userid', '=', $uid],['content_id','=',$request->statusid]])->count();
                 if($countcomment>0){
                   
                    $postcomments=UserComment::where([['comment_userid', '=', $uid],['content_id','=',$request->statusid]])->get();
                    foreach ($postcomments as $unserlizes1) {
                        $unserlizes[]=$unserlizes1->comment_userid;
                    }

                    $vb=serialize($unserlizes);

           

            $post = TimelinePost::find($request->statusid);


            $post->comment_user_id=$vb;

            $post->save();
            }
            
       }
       else
       {

            $user = DB::table('user_comment')->insert(array(
            'content_id'        => $request->statusid,
            'comment_userid'    => $uid,
            'comment'           => $request->comment,
            'typeof_comment'    => $request->type,
            'created_at'        => $timestamps,
            'updated_at'        => $timestamps,
        ));

       }


     
        
        
    }

  public function homepostcommentajaxrequests(Request $request)
    {   
       $absh=array();
        $uid = Auth::user()->id;
        // $content =$request->all();
        // $request = json_decode($content['data']); 
        $timestamps = new DateTime();
       
       if($request->type==0)
       {
            $user = DB::table('user_comment')->insert(array(
                'content_id'        => $request->statusid,
                'comment_userid'    => $uid,
                'comment'           => $request->comment,
                'typeof_comment'    => $request->type,
                'created_at'        => $timestamps,
                'updated_at'        => $timestamps,
            ));
            $lastCommentId = DB::getPdo()->lastInsertId();
            $countcomment=UserComment::where([['comment_userid', '=', $uid],['content_id','=',$request->statusid]])->count();
            if($countcomment>0){
                $postcomments=UserComment::where([['comment_userid', '=', $uid],['content_id','=',$request->statusid]])->get();
                foreach ($postcomments as $unserlizes1) {
                    $unserlizes[]=$unserlizes1->id;
                }

                $vb=serialize($unserlizes);

                $post = TimelinePost::find($request->statusid);

                /*echo "<pre>";
                print_r($post->user_id);
                echo "</pre>";*/
                $postUserId = $post->user_id;
                $post->comment_user_id =$vb;

                $post->save();
            }
            
            $this->getUpdatedCommentOnPost($request->statusid,$request->comment,$lastCommentId,$postUserId);
       }elseif($request->type==3)
       {
              $commentId = $request->commentId;
            
              $comment = $request->comment;
            
              $ParentPostOfComment = $request->postId;

           
             $postUserId = TimelinePost::where('id',$ParentPostOfComment)->pluck('user_id');
            
            
          
                $this->updateMyComment($commentId, $comment,$ParentPostOfComment,$postUserId[0]);
       }
        elseif($request->type==5)
       {

           

              $replyId = UserComment::find($request->replyId);
              $replyId = $request->replyId;
            
              $reply = $request->reply;

            
              $parentPostOfReply = $request->postId;

           
            
              $postUserId =   TimelinePost::where('user_id',$parentPostOfReply)->pluck('id');
            if(count($postUserId)==0)
            {
              
               $postUserId[0] =  $parentPostOfReply; 
            }
             $this->updateMyReply($replyId, $reply,$parentPostOfReply,$postUserId[0]);

       }
       elseif($request->type==4)
       {
            $commentId = $request->commentId;
             $this->deleteMyComment($commentId);
       }
       else
       {
             
            if($request->replyid)
            {
                $updatemyreply  = DB::table('user_comment')
                    ->where('id', $request->replyid)
                    ->update(['comment' => $request->comment]);

                $commentId = DB::getPdo()->lastInsertId();
                $post = TimelinePost::find($request->postId);
                $postUserId = $post->user_id; 
                $postId = $request->statusid;
                $comment = $request->comment;
               $this->updateMyReply($postId,$comment,$commentId,$postUserId);

            }else
            {
           
                $user = DB::table('user_comment')->insert(array(
                    'content_id'        => $request->statusid,
                    'comment_userid'    => $uid,
                    'comment'           => $request->comment,
                    'typeof_comment'    => $request->type,
                    'created_at'        => $timestamps,
                    'updated_at'        => $timestamps,
                ));
                $commentId = DB::getPdo()->lastInsertId();
                $post = TimelinePost::find($request->postId);
                $postUserId = $post->user_id; 
                $postId = $request->statusid;
                $comment = $request->comment;
                $this->getUpdatedCommentReplyOnPost($postId,$comment,$commentId,$postUserId);
            }

       }


     
        
       
    }

    public function getUpdatedCommentOnPost($postId,$comment,$commentId,$postUserId)
    {
        $userObj = new User();
        $uid = Auth::user()->id;
        $userDataObj = $userObj->getUserData(['id' => $uid]);
        $html = '';
        foreach ($userDataObj as $key => $userData) {
            $userName = $userData->name;
            $userProf =  $userData->avatar;
        }
        echo view('user.timeline.comment.ajax-post-comment',compact('uid','postId','comment','commentId','postUserId','userName','userProf'));
    }

    public function getUpdatedCommentReplyOnPost($postId,$comment,$commentId,$postUserId)
    {
        $userObj = new User();
        $uid = Auth::user()->id;
        $userDataObj = $userObj->getUserData(['id' => $uid]);
        $html = '';
        foreach ($userDataObj as $key => $userData) {
            $userName = $userData->name;
            $userProf =  $userData->avatar;
        }
         $getpostid = $this->getMyPostIdIfNotAvail($commentId);
        echo view('user.timeline.comment.ajax-post-comment-reply',compact('uid','postId','comment','commentId','postUserId','userName','userProf','getpostid'));
    }

    public function updateMyComment($commentId, $comment,$parentPostOfComment,$postUserId)
    {
        $savecomment = UserComment::find($commentId);
        $savecomment->comment = $comment;
        $savecomment->save();
        $userObj = new User();
        $uid = Auth::user()->id;
        $postId = $parentPostOfComment;





        // $this->getUpdatedCommentOnPost($postId,$commentId,$comment,$postUserId);
        /**/
        $userDataObj = $userObj->getUserData(['id' => $uid]);
        $html = '';

        foreach ($userDataObj as $key => $userData) {
            $userName = $userData->name;
            $userProf =  $userData->avatar;
        }
        
        // echo $uid.'======'.$postId.'======='.$comment.'======='.$commentId.'======='.$postUserId.'======='.$userName.'======='.$userProf;
        $view = '';
        echo View::make('user.timeline.comment.test-pst-comment',compact('uid','postId','comment','commentId','postUserId','userName','userProf','view'))->render();
        
    }

    public function updateMyReply($commentId, $comment, $parentPostOfReply,$postUserId)
    {
       
       
        $savereply = UserComment::find($commentId);
        $savereply->comment = $comment;
        $savereply->save();
     



        $postId = $parentPostOfReply;
       $getpostid = $this->getMyPostIdIfNotAvail($commentId);
          /* print_r("d==================");
          print_r($getpostid[0]);
          exit();*/
         $rr = $getpostid[0];

        $userObj = new User();
        $uid = Auth::user()->id;
        $userDataObj = $userObj->getUserData(['id' => $uid]);
        $html = '';
        foreach ($userDataObj as $key => $userData) {
            $userName = $userData->name;
            $userProf =  $userData->avatar;
        }
        echo view('user.timeline.comment.test-pst-comment-reply',compact('uid','postId','comment','commentId','postUserId','userName','userProf','getpostid'));
    }
    public function deleteMyComment($id)
    {
        UserComment::where('id',$id)->delete();
        return "deleted";
    }

    public function getMyPostIdIfNotAvail($id)
    {
       
        $mypostid = UserComment::where('id',$id)->pluck('content_id');
        
        return $mypostid;
    }
}