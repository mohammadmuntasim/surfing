@extends('layouts.app')
@section('content')
<section class="main-content">

    <div class="main-content-holder">
        <div class="container">
            <div class="row">
                <div class="col-md-8 pl-pr dd-scroll-contents">
                	 @if(sizeof($postblog['timeline_posts'])>0)
        				@foreach($postblog['timeline_posts'] as $key => $postvalues)
				         <?php $usert=$postvalues->user_id;
				          $uid=Auth::user()->id;
				          $check1=array('user_id'=>$uid,'connect_user_id'=>$usert,'status'=>1 );
				          $check2=array('user_id' => $usert,'connect_user_id'=>$uid,'status'=>1 );
				          $data['checkconnected']=$data['checkconnection']->getConnnected($check1,$check2);           
             
			             $mylikes=0;
			             $totallikes = $userController->getUserPostLikeById(['content_id'=>$postvalues->id]);
			             $totallikesme = $userController->getPostLikeByMe(['user_id'=>$uid,'content_id'=>$postvalues->id]);                             
			             $sharepost=$data['sharedpost']->getPostShareData(['post_id'=>$postvalues->id]);  
			             $parentPostCreatedTime = $userController->getParentPostCreatedTime($postvalues->id,$uid); ?>
							@include('user.timeline.timeline-ajax-post')
						@endforeach
						@endif

			    </div>
			    <div class="col-md-4 pl-pr dd-scroll-contents text-center">
                    @include('user.sidebar')
                </div>
			</div>
		</div>
	</div>	
