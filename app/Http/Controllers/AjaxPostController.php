<?php

namespace App\Http\Controllers;
use DB;
use View;
use App\TimelinePost;
use App\TimelinePostLike;
use App\Http\Requests;
use File;
use Exception;
use Illuminate\Http\Request;
use DateTime;
use Auth;
use App\UserMetum;
use App\Http\Controllers\TimelinePostController;
use Response;
use App\Http\Controllers\UserController;
use Image;
use App\TimelineSharePost;
use App\User;
use App\UserMedia;
class AjaxPostController extends Controller
{

   
    /* Like post */
    public function likePost(Request $request)
    {
     $senderid= $request->likeid; 
     $likevalue=json_decode($senderid);
     $contentid=$likevalue->p_id;
      /****post status means 0 menu it's is post like and if 1 the it's comment like **/
     $poststatus=$likevalue->l_status;
       $breakdelete=explode('-', $senderid);
       $uid = Auth::user()->id;      
       $timestamps = new DateTime();  
        $unserlizes=array();  
        $countrequest=TimelinePostLike::where([['user_id', '=', $uid],['content_id','=',$contentid],['type','=',$poststatus]])->count();
            if($countrequest>0){
                $deletepost = TimelinePostLike::where([['user_id', '=', $uid],['content_id','=',$contentid],['type','=',$poststatus]])->delete(); 
                        /***update post table ****/
                        if($poststatus==0){    
                         $postupdatedds=TimelinePostLike::where([['content_id','=',$contentid],['type','=',$poststatus],['type','=',$poststatus]])->get();
                        foreach ($postupdatedds as $unserlizes1) {
                            $unserlizes[]=$unserlizes1->id;
                        }
                        $vb=serialize($unserlizes);                                          
                        $postupdatedd=TimelinePost::where([['id','=',$contentid],['type','=',$poststatus]])->update(array( 'like_user_id' =>$vb ));
                        }
            }else{
            $data['test'] = TimelinePostLike::insert(array(
                    'user_id' => $uid,
                    'content_id' => $contentid,
                    'type' => $poststatus                   
                    ));
           
                    /***update post table ****/
                    if($poststatus==0){  
                    $postupdatedds=TimelinePostLike::where([['content_id','=',$contentid],['type','=',$poststatus]])->get();
                    foreach ($postupdatedds as $unserlizes1) {
                        $unserlizes[]=$unserlizes1->user_id;
                    }
                    $vb=serialize($unserlizes);           
                    $postupdatedd=TimelinePost::where([['id','=',$contentid],['type','=',$poststatus]])->update(  array(                    
                            'like_user_id' =>$vb
                            ));
                    }
           }
    $mylikecount=TimelinePostLike::where([['user_id', '=', $uid],['content_id','=',$contentid],['type','=',$poststatus]])->count();
    $countrequest=TimelinePostLike::where('content_id','=',$contentid)->count();
    $catss=array('totallikes' =>$countrequest ,'mylike'=> $mylikecount,'name'=>Auth::user()->name,'type'=>$poststatus);
   

        return Response::json($catss);
    }

    public function postdatabyid(Request $request)
    {   
        $userdatabyid=new User();
        $contentid=$request->getdata;
        $postdatastore='';
         $postdata=TimelinePost::where([['id','=',$contentid],['type','=','0']])->get();
         foreach ($postdata as $postdatavalue) {
             $userdatas=$userdatabyid->getUserData(['id' => $postdatavalue->user_id]);
             //print_r($userdatas);
             $date=$postdatavalue->updated_at;
                                            $date1 = date('Y-m-d H:i:s', strtotime($date));
                                            $date2 = date("Y-m-d H:i:s");
                                            $diff = abs(strtotime($date2) - strtotime($date1));

                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                            $times=abs(strtotime($date2)-strtotime($date1));
                                            $gettimepost = date('h:i A', strtotime($date1));
                                            if($days==0){
                                                $days=$times;
                                                if($times<60)
                                                {
                                                    $days=$times." seconds";
                                                }elseif($times<3600){
                                                    $checkminuts=floor($times/60);
                                                    if($checkminuts<59){
                                                            $days=$checkminuts."  minutes";
                                                    }else{
                                                    $days="about an hours";
                                                   }

                                                }else{
                                                    $checkminuts=floor($times/3600);
                                                    $days=$checkminuts." hrs";
                                                }
                                                
                                            }elseif($days==1) {
                                                   $days='Yesterday at '.$gettimepost;
                                            }elseif($days>1){
                                                    if($years==0){
                                                    $days=date('d M', strtotime($date1))." at ".$gettimepost;
                                                   }else{
                                                    $days=date('d-m-y h:i A', strtotime($date1))." at ".$gettimepost;
                                                   }
                                                }
                                                $names='';
                                                $imageuser='';
                                                foreach ($userdatas as $userdatasvalue) {
                                                   $names=$userdatasvalue->name;
                                                   $imageuser=$userdatasvalue->avatar;
                                                }
                                                if($imageuser=='')
                                                {
                                                    $imageuser='/css/assets/img/profile-image.jpg';
                                                }
                                                $postdatastore='<div class="dd-single-post-holder">
                                                <div class="dd-post-header fw">
                                                <figure class="dd-post-avater-holder">  
                                                <img src="'.$imageuser.'" alt="Image" class="img-responsive media-object">
                                                </figure>
                                                <div class="dd-post-user-holder">        
                                                <h5>'.$names.'</h5>
                                                <span>'.$days.'</span>
                                                </div>
                                                </div>
                                                <div class="dd-post-content fw" id="timeline-post-content66">
                                                <p>'.$postdatavalue->content.'</p>
                                                </div>
                                                </div>';
                                
         }

        return Response::json($postdatastore);
    }
   
     public function ajaxalbumrequest($images)
    {
        $timestamps = new DateTime();
        $contents = $images;
        $uid = Auth::user()->id;
       
        $absh=array();

        $timelinepost = new TimelinePost();
        $timelinepost->user_id=$uid;
        $timelinepost->content =$contents;
        $timelinepost->like_user_id =serialize($absh);
        $timelinepost->comment_user_id =serialize($absh);
        $timelinepost->type =0;
        $timelinepost->status =0;
        $timelinepost->save();
        
         return redirect()->action('HomeController@index');
    }

    public function updateajaxrequest(Request $request)
    {
        // delete query for post

        if($request->type==1)
        {   
            
            $delpost = TimelinePost::where('id','=',$request->postId)->delete();

            $delshareif =   DB::table('timeline_share_post')->where('parent_post_id',$request->postId)->pluck('post_id');
            if(sizeof($delshareif)>0)
            {
                $delaallsharepost = DB::table('timeline_post')->where('id',$delshareif[0])->delete();
            }
        }

        // update query for simple post
        else if($request->type==2)
        {
            $savepost = TimelinePost::find($request->postId);
            $savepost->content = $request->updatedcontent;
            $savepost->save();
            
            $userObj = new User();
            $uid = Auth::user()->id;
            return redirect()->action('HomeController@index');
        }elseif ($request->type==3) {

            $savephotopost = TimelinePost::find($request->postId);
            $savephotopost->content = $request->content;
            $savephotopost->media_id= $request->imageid;
            $savephotopost->save();
            
            $userObj = new User();
            $uid = Auth::user()->id;
            return redirect()->action('HomeController@index');
        }

        elseif($request->type==4)
        {
            echo $request->postId;

            echo "<br>";
            echo $request->content;
            echo "<br>";
            echo $request->imageid;echo "<br>";
            echo $request->shareinfo;echo "<br>";
             
             $idd=$request->postId;

             $saveshareposty = TimelinePost::find($idd);
             $saveshareposty->content = $request->content;
             $saveshareposty->media_id = $request->imageid;
             $saveshareposty->type = $request->shareinfo;
             $saveshareposty->save();
             
            $userObj = new User();
            $uid = Auth::user()->id;
            return redirect()->action('HomeController@index');

        }

    }
}