<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UserMedia extends Model
{
	protected $table = 'user_media';
	public $timestamps = true;
	public function myselectedphotos($uid)
	{

		$myphotos= UserMedia::where('uid',$uid)->orderBy('id', 'DESC')->take(6)->get();
		return $myphotos;
	}
	//get image url by image Id
	public function getMediaUrlById($mediaId)
	{

		$myphotos= UserMedia::where('id',$mediaId)->pluck('media');
		return $myphotos[0];
	}


	//save media image data in media table
	public function saveMedia($mediaUrl,$AlbumId)
	{
		$usermedia = new UserMedia();
		$usermedia->uid=Auth::user()->id;
		$usermedia->media =$mediaUrl;
		$usermedia->album_id = $AlbumId;    
		$usermedia->save();
		$usermediaId=$usermedia->id;
		return $usermediaId;
	}

	//get  image by Album id
	public function getMediaByAlbumId($userid,$AlbumId)
	{
		$usermedia= UserMedia::where([['uid','=',$userid],['album_id','=',$AlbumId]])->orderBy('created_at', 'DESC')->get();
		
		return $usermedia;
	}

	  //get all images of album
      public function getMediaAlbum($albumId)
      {
            
            $myphotos= UserMedia::where('album_id',$albumId)->get();
            return $myphotos;
      }
}
