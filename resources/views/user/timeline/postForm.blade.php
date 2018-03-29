
<div class="dd-write-post dd-card">
	                            <ul class="nav nav-tabs" role="tablist">
	                            	@if(Request::path()!='photos')
	                                <li role="presentation" class="active">
	                                    <a class="type-article" href="#post-type-article" aria-controls="article" role="tab" data-toggle="tab">Post Article</a>
	                                </li>
	                                @endif
	                                <li role="presentation" @if(Request::path()=='photos') class="active" @endif>
	                                    <a class="type-photo" href="#post-type-photo" aria-controls="photo" role="tab" data-toggle="tab">Post Photo</a>
	                                </li>
	                            </ul>
	                            <!-- Tab panes -->
	                            <div class="tab-content">
	                            	@if(Request::path()!='photos')
	                                <div role="tabpanel" class="tab-pane active" id="post-type-article">
		                                <div class="dd-post-write-holder">
		                                    <form class="form-horizontal" role="form"  data-toggle="validator"  id="upload_form" method="POST" action="#" onsubmit="return disablepostingstatus()">
		                                         {{ csrf_field() }}
		                                        
			                                        <div class="form-group">
			                                        	<div class="col-md-1">
			                                        		<a href="{{url('/profile')}}">
			                                        		<img src="{{ isset(Auth::user()->avatar) ?  Auth::user()->avatar : '/css/assets/img/profile-image.jpg' }}" class="img-responsive">
															</a>
			                                        	</div>
			                                        	<div class="col-md-11">
			                                            <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content" required></textarea>
			                                            </div>
			                                        </div>
		                                        <button type="submit" class="btn btn-default" id="postNewStatus">Post</button>
		                                    </form>
		                                </div>  
	                            	</div>
	                            	@endif
		                            <div role="tabpanel" class="tab-pane  @if(Request::path()=='photos') active @endif" id="post-type-photo">
		                                <div class="dd-post-write-holder">
		                                     <form class="form-horizontal" role="form"  id="upload_form" data-toggle="validator" method="POST" action="#"  enctype="multipart/form-data" onsubmit="return disablepostingstatus()">
		                                         {{ csrf_field() }}                                         

		                                        <div class="form-group">
		                                        	<div class="col-md-1">
		                                        			<a href="{{url('/profile')}}">
			                                        			<img src="{{ isset(Auth::user()->avatar) ?  Auth::user()->avatar : '/css/assets/img/profile-image.jpg' }}" class="img-responsive">
		                                        			</a>
			                                        	</div>
			                                        	<div class="col-md-11">
		                                            <textarea class="form-control" rows="3" cols="40" placeholder="Share an article, photo, or update" name="content"></textarea>
		                                        </div>
		                                        </div>
		                                        
		                                        <div class="form-group">
		                                        <figure class="dd-cover-changer">  
		                                            <!--<a href="#" class="removedpost"><i class="fa fa-remove" aria-hidden="true"></i></a>  -->                 
		                                           <img src="" alt="surf health cover " id="cover-image-individiual">     
		                                         </figure>
		                                        </div>
		                                        <div class="form-group margin-top-10 dd-post-img-uploader">
		                                       		<input id="file-1" class="inputfile inputfile-1 file" type="file" required name="post_image" multiple data-overwrite-initial="false" data-min-file-count="1" id="imagedatagetimagedata(document.getElementById('imagedata'))">
		                                           	<label for="file-1"><i class="glyphicon glyphicon-plus"></i><span></span></label>
		                                         	<button type="submit" class="btn btn-default" id="postNewStatus2">Post</button>
		                                        </div>		                                       
		                                    </form>

		                                </div>
		                            </div>
	                            </div>
	                        </div>