<?php
namespace App\Http\Controllers;
use View;
use Auth;
use Illuminate\Http\Request;
use App\TimelinePost;
use App\UserMetum;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\TimelinePostController;
use App\UserConnection;
use App\TimelineSharePost;
use App\User;
use App\TimelinePostLike;
use App\UserMedia;
use App\UserFollow;
use DB;
class FileController extends Controller {
    public function loadMore(Request $request){
$uid = Auth::user()->id; 
 $userMetaObj = new UserMetum(); 
        $roleController = new RoleController(); 
        $userController = new UserController(); 
        $timelinePostController = new TimelinePostController();
        $postblog = $timelinePostController->getAllPost($uid);    
        $data['sharedpost']=new TimelineSharePost();
        $data['userdatabyid']=new User();
       $data['countlike']=new TimelinePostLike();
        $userInfoObj = $userController->getUserInformation();
                 $userpic=new User();
$data['rolename']=new RoleController();
              $comments =  $timelinePostController->getComment($postblog);
        $postblog['timeline_post']=TimelinePost::paginate(4);
        $html='';

foreach($postblog['timeline_post'] as $key => $postvalues){
                             $uid=Auth::user()->id;
                             $mylikes=0;
                             $totallikes = $userController->getUserPostLikeById(['content_id'=>$postvalues->id]);
                             $totallikesme = $userController->getPostLikeByMe(['user_id'=>$uid,'content_id'=>$postvalues->id]);                             
                             $sharepost=$data['sharedpost']->getPostShareData(['post_id'=>$postvalues->id]);                              
            $html.=view('user.timeline-ajax-post',compact('data','postvalues','userController','userpic','comments','timelinePostController'));
        }
        if ($request->ajax()) {
            return $html;
        }

$searchdropdown['providers'] = DB::table('insurance_providers')->get();
		$searchdropdown['docspeciality'] = DB::table('doctorspeciality')->get();
		$searchdropdown['denspeciality'] = DB::table('dentist_speciality')->get();
		$searchdropdown['wellnessspeciality'] = DB::table('wellness_speciality')->get();
		$searchdropdown['eldercarespeciality'] = DB::table('eldercare_speciality')->get();
        return view('user.loadmore',compact('products','searchdropdown'));
    }
}