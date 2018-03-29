@extends('layouts.app')
@section('content')
	@include('messenger.partials.flash')
	<section class="main-content">
	<div class="container bootstrap snippet">
  		<div class="row">
  			<div class="col-md-4 bg-white ">
			    <div class=" row border-bottom padding-sm" style="height: 40px;text-align: center;padding: 5px;font-size: 20px;">
			        Connection User List
			    </div> 
			    <!-- member list -->
			    <ul class="friend-list" id="chat-user-list">
			    	@include('messenger.partials.thread')
				    @include('messenger.partials.users-list')
				</ul>
			</div>
		</div>		
	</div>
  	<div id="chat"></div>
  </section>
  	@include('messenger.partials.delete-thread')		    
@stop
