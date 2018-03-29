<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\UserConnection;

class Notification extends Model
{
    protected $table = 'notifications';
    public $timestamps = false;


    /***connection request ***/
    public function createNotification($userid,$postid,$notificationtype)
    {

    	$requestConnection=new Notification();
    	$requestConnection->user_id=$userid;
    	$requestConnection->post_id=$postid;
    	$requestConnection->notifiable_type=$notificationtype;
    	$requestConnection->save();    	
    	return $requestConnection;
    }
    /***delete notification request ***/
    public function deleteNotification($userid,$postid,$notificationtype)
    {

        $notify=Notification::where([['user_id','=',$userid],['post_id','=',$postid],['notifiable_type','=',$notificationtype]])->delete(); 
        return $notify;
    }

    /*** Show Notification ***/
    public function getAllNotify($userid)
    {
    	//get  notofication  records
    	if(!empty($userid)){
    	$requestConnection=Notification::where([['user_id','=',$userid],['notifiable_type','<>',1],['read_at','=',0]])->orderBy('id', 'desc')->get();
        return $requestConnection;
        }
    	
    }
    /*** Show Notification for Connection***/
    public function getNotifyConnection($userid)
    {
    	//get  notofication  records
    	if(!empty($userid)){
    	$requestConnection=Notification::where([['user_id','=',$userid],['notifiable_type','=',1],['read_at','=',0]])->orderBy('id', 'desc')->get();
return $requestConnection;
        }
    	
    }
    //single connection  connenction 
    public function getUserConnectionSingle($postid){
        $reqConnection=UserConnection::where('id', '=', $postid)->get(); 
        return $reqConnection;
    }

   /**** time diffrence ***/
    public function timeDifferences( $date1, $date2 )
{
$date1 = date('Y-m-d H:i:s', strtotime($date1));
                                           
                                           
                                            $diff = abs(strtotime($date2) - strtotime($date1));

                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                            $times=abs(strtotime($date2)-strtotime($date1));
                                            $gettimepost = date('h:i A', strtotime($date2));
                                             $countstime=$times/60;
                                            if($days==0){
                                                $days=$times;
                                                if($times<60)
                                                {
                                                    $days=$times." seconds";
                                                }elseif($countstime<=1){
                                                    $checkminuts=floor($times/60);
                                                    if($checkminuts<59){
                                                            $days=$checkminuts."  minutes";
                                                    }else{
                                                    $days="about an hours";
                                                   }

                                                }else{
                                                   
                                                    $days=$countstime." hrs";
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
                                            

    return $days;
}
   
}
