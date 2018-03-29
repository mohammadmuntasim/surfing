<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\User;
use Auth;
use File;
use App\UserMetum;
use App\UserMedia;
use DB;
use App\UserFollow;
use App\Notification;
use App\UserAlbum;
use App\TimelinePost;
use App\ConnectionTimelinePost;
use App\UserComment;
use App\TimelinePostLike;
use App\TimelineSharePost;

class UserPhotosController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');         
    }
    public function index(Request $request){
       
        
        $usercontroller = new UserController();
        
        $header=new HeaderController();
        $data=$header->headerAfterLogin($request);

        $timelinePostController = new TimelinePostController();
        $data['otherUserTimelinePosted']=new ConnectionTimelinePost();
        $uid=Auth::user()->id;
         $data['encrypt']=new EndecryptController();
         $searchcontroller = new SearchViewController();
         //add post
        if(empty($request->shareid)){
            if (!empty($request->content) || !empty($request->post_image)) {
                $newpost = $timelinePostController->createNewPost($request); 
            }
        }
        //add album
        if(isset($request->albumname)){
        $usermedia=$this->uploadAlbum($request);
        }
        //update album name
        if(isset($request->renamealbum) && !empty($request->renamed) && !empty($request->hiddenid))
        {
            
            $aid = $data['encrypt']->decryptIt($request->hiddenid);           
            UserAlbum::where("id",'=',$aid)->update(['album_name' => $request->renamed]);
            TimelinePost::where("media_id",'=',$aid)->where("post_type",'=',1)->update(['content' => $request->renamed]);
        }


            $data['currentUserid']=''; 
            if(isset($_GET['ref_app'])){
              if(!empty($_GET['ref_app'])){
                $val=$data['encrypt']->decryptIt($_GET['ref_app']);
                $data['currentUserid']=$val;
                $data['userid']=$val;
                //data['cover-image']='/css/assets/img/default-cover.jpg';
              }else{
                $data['currentUserid']=Auth::user()->id;
              }
              
            }else if(!empty($data['userid'])){
             $data['currentUserid']=$data['userid'];
              }else{
              $data['currentUserid']=Auth::user()->id;
            }
             $data['usergeneralinfo']  = $searchcontroller->getUserGeneralInfo($data['currentUserid']);
           $data['userAllMetaData']  = $searchcontroller->getUserInformation($data['currentUserid']);
                  /* Cover Image */
        if (!empty($request->cover_photo)) {
            $data['cover-image']= $usercontroller->postCoverPhoto($request);
        }elseif($usercontroller->getPhoto('cover',$data['currentUserid'])){
            $data['cover-image']= $usercontroller->getPhoto('cover',$data['currentUserid']);
        }else{
            $data['cover-image']= '/css/assets/img/default-cover.jpg';
        }
       
        /* Profile Image */
        if (!empty($request->profile_photo)) {
            $data['profile-image']= $usercontroller->postProfilePhoto($request);
        }elseif($usercontroller->getPhoto('profile',$data['currentUserid'])){
            $data['profile-image']= $usercontroller->getPhoto('profile',$data['currentUserid']);
        }else{
            $data['profile-image']= '/css/assets/img/profile-image.jpg';
        }  
//Notification
       $data['getNotification']=new Notification();
       $data['showNotification']=$data['getNotification']->getAllNotify($uid);
       $data['showNotificationConnection']=$data['getNotification']->getNotifyConnection($uid);
       
        $data['countrequests']=0;
        $data['userAllMetaData']  = $usercontroller->getUserInformation();
        $data['allimages']=UserMedia::where('uid','=',Auth::user()->id)->get();
         /**** search drop down ***/
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();


      $data['newAlbum'] =  new UserAlbum();
        $data['encrypt']=new EndecryptController();

         $data['myAlbumsPic']='';
        $albumdetail = $data['newAlbum']->MyAlbum();

        if(isset($request->memoriesid))
        {   
            $albumid = $data['encrypt']->decryptIt($request->memoriesid);

            $myAlbumsPic = UserMedia::where('album_id','=',$albumid)->get();

            $data['myAlbumsPic'] = $myAlbumsPic;
        }

        if(isset($request->album) && !empty($request->album)){
              $data['album']=$this->deleteAlbum($request->album);
            }

         if($request->ajax()){
            

           return redirect()->back();
        }else{
            return view('user.media.photos',compact('data','searchdropdown','albumdetail'));
        }

     
    }

     /* Delete Album */
    public function deleteAlbum($deleteAlbums)
    {



      $data['encrypt']=new EndecryptController();
      $userid=Auth::user()->id;
      $albumId =$data['encrypt']->decryptIt($deleteAlbums);  
      $removeimage=UserMedia::where('album_id','=',$albumId)->where('uid','=',$userid)->count();
      if($removeimage>0){
          $removeimage=UserMedia::where('album_id','=',$albumId)->where('uid','=',$userid)->delete();
          $text="";
      }
     $getpostid=TimelinePost::where('media_id','=',$albumId)->where('post_type','=',1)->get();
    $postid=0;
    foreach ($getpostid as $key => $getpostidvalue) {
      $postid=$getpostidvalue->id;
     
      $removeimage=UserComment::where('content_id','=',$postid)->delete();
      $removeimage=TimelinePostLike::where('content_id','=',$postid)->delete();
      $removeimage=TimelineSharePost::where('post_id','=',$postid)->delete();
      $removeimage=ConnectionTimelinePost::where('post_id','=',$postid)->delete();
    }
     $removeimage=TimelinePost::where('media_id','=',$albumId)->where('post_type','=',1)->delete();
     $removeimage=UserAlbum::where('id','=',$albumId)->delete();
      return $albumId;
      
    }
    //user photo album upload
    public function uploadAlbum($request){

        //extract($_POST);
        $error=array();
        $data['album'] = New UserAlbum();
        $data['usermedia'] = new UserMedia();
        $data['postTimeline']=new TimelinePost();
        $userNameFolder = str_replace(' ', '-', Auth::user()->id ); 
        $albname = str_replace(' ', '-', $request->input('albumname'));  
        $txtGalleryName=Auth::user()->id.'-'.str_random(3).'-'.$albname;
        $profilePath = public_path('/user/'.$userNameFolder.'/photo_gallery/'.$txtGalleryName);
        $extension=array("jpeg","jpg","png","gif");
        //save album data in album table
        $newAlbum = $data['album']->saveAlbum($txtGalleryName,$request->input('albumname'));
        $albumid =  $newAlbum->id;
        
        if(!empty($_FILES["upload_file"]["tmp_name"]))
        { 
          
          $fileUploadArray = array_filter($_FILES["upload_file"]["tmp_name"]);
           foreach($fileUploadArray as $key=>$tmp_name)
           {
               $file_name=str_random(3) . '-' . str_replace(')','',str_replace('(','', $_FILES["upload_file"]["name"][$key]));   
               $file_tmp=$_FILES["upload_file"]["tmp_name"][$key]; 
               $ext=pathinfo($file_name,PATHINFO_EXTENSION);
               if (!file_exists($profilePath)) {
                   File::makeDirectory($profilePath, $mode = 0777, true, true);
               }
               $filesize = $_FILES['upload_file']['size'][$key];
               if(in_array($ext,$extension))
               {   
                   if(!file_exists($profilePath."/".$file_name))
                   {                 
                       if($filesize> 2097152)
                       {   
                          
                           $fileDestination = $profilePath."/".$file_name;
                           move_uploaded_file($file_tmp=$_FILES["upload_file"]["tmp_name"][$key],$fileDestination);
                           // optimize
                           $compressImg = $profilePath.'/compress-img/';
                           if (!file_exists($compressImg)) {
                               File::makeDirectory($compressImg, $mode = 0777, true, true);
                           }
                           $check = $newAlbum->compress($fileDestination,$compressImg."/".$file_name, 20);
                           unlink($fileDestination);
                           $imageUrl ='/user/'.$userNameFolder.'/photo_gallery/'.$txtGalleryName."/".'compress-img/'.$file_name;
                            //save image in media
                           $saveMediaIameg=$data['usermedia']->saveMedia($imageUrl,$albumid);
   
                       }else
                       {
                           
                           move_uploaded_file($file_tmp=$_FILES["upload_file"]["tmp_name"][$key],$profilePath."/".$file_name);
                           $imageUrl ='/user/'.$userNameFolder.'/photo_gallery/'.$txtGalleryName."/".$file_name;
                           //save image in media
                           $saveMediaIameg=$data['usermedia']->saveMedia($imageUrl,$albumid);
                           
                       }
   
                   }        
               }
               else
               {
                   array_push($error,"$file_name,");
               }
           }

           //upload Album as a Post
           $uid=Auth::user()->id;
           //get all image of album by id
            $userMedais=$data['usermedia']->getMediaByAlbumId($uid,$albumid);

           /* add album as a post*/
             $addPost=$data['postTimeline']->saveTimeLinePost($uid,$albname,$albumid,1,0);

           /* make post of album image*/
           
            /*$contents='';
            foreach ($userMedais as $key => $mediaId) {
               $addPost=$data['postTimeline']->saveTimeLinePost($uid,$contents,$mediaId->id,1,0);
             
            }*/
           

           

        }
        return $albumid;
       
    }



    /* Update user Album */
    public function updateAlbum(Request $request)
    {
      $endecryptController = new EndecryptController();
      extract($_POST);
      $error=array();
      $data['usermedia'] = new UserMedia();
      $userNameFolder = str_replace(' ', '-', Auth::user()->id ); 
      $albname = str_replace(' ', '-', $request->input('albumname')); 
      $albumid =  $endecryptController->decryptIt($request->input('albumid'));
      $albumRecord = UserAlbum::where('id',$albumid)->select('album_path')->get();     
      $txtGalleryName = $albumRecord[0]->album_path;
      $profilePath = public_path('/user/'.$userNameFolder.'/photo_gallery/'.$txtGalleryName);
      $extension=array("jpeg","jpg","png","gif");
      if(!empty($_FILES["more_upload_file"]["tmp_name"]))
        {           
         foreach($_FILES["more_upload_file"]["tmp_name"] as $key=>$tmp_name)
         {
             
             $file_name=str_random(3) . '-' . $_FILES["more_upload_file"]["name"][$key];
 
             $file_tmp=$_FILES["more_upload_file"]["tmp_name"][$key];
 
 
             $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            
             if (!file_exists($profilePath)) {
                 File::makeDirectory($profilePath, $mode = 0777, true, true);
             }
 
             $filesize = $_FILES['more_upload_file']['size'][$key];
               
             
             if(in_array($ext,$extension))
             {   
                 if(!file_exists($profilePath."/".$file_name))
                 {                 
                     if($filesize> 2097152)
                     {   
                         $fileDestination = $profilePath."/".$file_name;
                         move_uploaded_file($file_tmp=$_FILES["more_upload_file"]["tmp_name"][$key],$fileDestination);
                         // optimize
                         $compressImg = $profilePath.'/compress-img/';
                         if (!file_exists($compressImg)) {
                             File::makeDirectory($compressImg, $mode = 0777, true, true);
                         }
                         $check = $newAlbum->compress($fileDestination,$compressImg."/".$file_name, 20);
                         unlink($fileDestination);
                        
                         $imageUrl ='/user/'.$userNameFolder.'/photo_gallery/'.$txtGalleryName."/".'compress-img/'.$file_name;
                         //save image in media
                         $usermedia=$data['usermedia']->saveMedia($imageUrl,$albumid);
                          $last_id=$usermedia;
                     }else
                     {
                         move_uploaded_file($file_tmp=$_FILES["more_upload_file"]["tmp_name"][$key],$profilePath."/".$file_name);
                         $imageUrl ='/user/'.$userNameFolder.'/photo_gallery/'.$txtGalleryName."/".$file_name;
                         //save image in media
                         $usermedia=$data['usermedia']->saveMedia($imageUrl,$albumid);
                         $last_id=$usermedia;
                         
                     }
 
                 }        
             }
             else
             {
                 array_push($error,"$file_name,");
             }
         }
        /* Update Post */
        //$this->updatePostOnAlbumUpdate($albumid);

      }
      return redirect()->back();
    }
}
