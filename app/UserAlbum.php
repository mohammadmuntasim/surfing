<?php

namespace App;
use Auth;
use App\UserMedia;
use Illuminate\Database\Eloquent\Model;

use ImageOptimizer\OptimizerFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class UserAlbum extends Model
{
    protected $table = 'user_album';		
	protected $fillable = [
        'user_id','album_path', 'album_name',
    ];

    public function MyAlbum()
    {	
    	$allalbumsimages=array();
    	$useralbum = UserAlbum::where('user_id',Auth::user()->id)->pluck('id');
    	foreach ($useralbum as $value) {
    		
    		$allalbumsimages[] = UserMedia::where([['uid',Auth::user()->id],['album_id','=',$value]])->get();
    	}
    	// $MyAlbum = DB::table('user_media')->where('user_id',Auth::user()->id)->where('album_id',$useralbum->id)->get();

    	return  $allalbumsimages;


    }

    public function myAllAlbum($uid)
    {
        
       
    	$useralbum = UserAlbum::where($uid)->get();
       
    	return $useralbum;
    }

    public function coveralbum($caid)
    {
    	$coverpic = UserMedia::where($caid)->first();

     
   
    	return $coverpic;

    }

    public function allalbumpic($albumid)
    {
    	$allalbumsimages[] = UserMedia::where($albumid)->get();

    	return $allalbumsimages;
    }

    public function totalpic($albid)
    {
    	$totalpic = UserMedia::where($albid)->count();

    	

    	return $totalpic;
    }

    function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

     //save album
    public function saveAlbum($albumPath,$albumName)
    {
        $newAlbum = New UserAlbum();
        $newAlbum->user_id = Auth::user()->id;
        $newAlbum->album_path =  $albumPath;
        $newAlbum->album_name = $albumName;
        $newAlbum->save();

        return $newAlbum;
    }
  
}
