@extends('layouts.app')

@section('content')

<section class="main-content">
    <div class="dd-userport">
        <div class="container">
            <div class="row"> 
                @include('user.profilehead')
            </div>
        </div>
    </div>  
    <div class="container">
      <div class="row">

            <div class="dd-common-inner-title">
               @if(empty(app('request')->input('ref_app')))
                <h3 class="photo-headings">Photos 
                  <!-- <h5 class="pull-left">
                    <button type="button" class="btn btn-info pull-left" data-toggle="modal" data-target="#albumModel">
                      Add Album</button>
                  </h5>
                      <h5 class="pull-left">
                       <button type="button" class="btn btn-info pull-left" data-toggle="modal" data-target="#albumModel">Add Photo</button>
                     </h5>  -->
                </h3> 
               @endif
            </div>
      </div>
        <div class="row">
          @if(empty(app('request')->input('ref_app')))
        <div class="col-md-9 col-xs-12 pl dd-memories-photo">
           
            <ul class="nav nav-tabs">
                  <li  @if(app('request')->input('memoriesid')) class="" @else class="active" @endif><a data-toggle="tab" href="#home">All Photos</a></li>                
                  <li @if(app('request')->input('memoriesid')) class="active" @endif><a data-toggle="tab" href="#menu1">Your Album</a></li>
                   <li @if(app('request')->input('memoriesid')) class="active" @endif><a data-toggle="modal" data-target="#albumModel" href="#">Add Album</a></li>
              </ul>
            <div class="tab-content">
              <div id="home" @if(app('request')->input('memoriesid')) class="tab-pane dd-mix-photos fade" @else class="tab-pane dd-mix-photos fade in active" @endif>                      
                    <div class="main-content-holder-photobox" >
                          <div class="dd-timeline-posts-holder fw" >
                              <div class="dd-gallery-4-column">
                                 <div class="col-md-3 album-img-div" id="media-upload">
                                     <a href="javascript:void(0);" onclick="document.getElementById('file-1').click();" class="img-plus" id="changeimage">
                                         
                                        <div class="dd-gallery-item">
                                          <figure class="dd-gallery-image-holder" style="background-image:url();">
                                             <i class="fa fa-plus" aria-hidden="true"></i>
                                            </figure>
                                        
                                        </div>
                                       </a>
                                  </div>
                                  @foreach($data['allimages'] as $userphotos)
                                  <div class="col-md-3" id="media{{$userphotos->id}}">
                                    <div class="dd-gallery-item">
                                          <figure class="dd-gallery-image-holder" style="background-image:url({{ $userphotos->media }});">
                                            </figure>
                                            <div class="dd-gallery-content">
                                                <a class="dd-light-box" href="javascript:void(0);" data-image-id="" data-toggle="modal"  data-image="{{ $userphotos->media }}" data-target="#image-gallery"><i class="fa fa-search" aria-hidden="true"></i></a>
                                                <a href="javascript:void(0);" onclick="deletemediaImage(this)" data-imageid="{{$userphotos->id}}" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </div>
                                      </div>
                                  </div>
                                  @endforeach
                                </div>
                        </div>
                        </div>
                    </div><!-- Mix Photos Tab End   -->                  
                    <div id="menu1" @if(app('request')->input('memoriesid')) class="tab-pane dd-mix-albums fade in active" @else class="tab-pane dd-maax-albums fade" @endif >
                      <div class="main-content-holder-photobox" >
                      <div class="main-content-holder-album" ><!-- ALBUM LIST -->
                              <div class="dd-timeline-posts-holder fw">
                                <div class="album-header row">
                                    <div class="col-md-6">
                                      <h2  class="albname">
                                        @if(!empty( app('request')->input('aname')))  
                                          {{ app('request')->input('aname') }}<span class="editmealbum" data-toggle="modal" data-target="#editalbumname"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>

                                         @endif  
                                      </h2>
                                     
                                    </div>
                                    <div class="col-md-6 add-more-img-btn">
                                      <?php if(isset($_GET['memoriesid']) ) : ?>
                                        <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#add-more-img"><i class="fa fa-plus"></i> Add image</button>
                                      <?php endif; ?>
                                    </div>  
                                </div>
                                  <div class="dd-gallery-4-column">
                                      
                                        @if(!empty($data['myAlbumsPic']))
                                        @foreach( $data['myAlbumsPic'] as $userphotos)
                                      <div class="col-md-3" id="mediaalbum{{$userphotos->id}}">
                                          <div class="dd-gallery-item">
                                              <figure class="dd-gallery-image-holder" style=" background-image:url('{{ $userphotos->media }}');">
                                              </figure>
                                                <div class="dd-gallery-content">
                                                    <a class="dd-light-box" href="javascript:void(0);" data-image-id="" data-toggle="modal"  data-image="{{ $userphotos->media }}" data-target="#image-gallery"><i class="fa fa-search" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0);" onclick="deleteAlbumImage(this)" data-imageid="{{$userphotos->id}}" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                </div>
                                          </div>
                                      </div>
                                        @endforeach
                                        @endif
                                    </div>
                            </div>
                          </div>
                          <!--Album section start here-->
                            @php($allmyalbum = $data['newAlbum']->myAllAlbum(['user_id' => $data['currentUserid']]))
                        @foreach($allmyalbum as $memories)
                          @php($albumid=$data['encrypt']->encryptIt($memories->id))
                            <div class="col-sm-4 col-xs-12 dd-single-album"  id="album-div-{{$albumid}}">
                              <a href="{{URL::current()}}/?memoriesid={{ $data['encrypt']->encryptIt($memories->id)}}&aname={{$memories->album_name}}">
                                    @php($mycoveralbum = $data['newAlbum']->coveralbum(['album_id' =>$memories->id])) 
                                    @if(!empty($mycoveralbum)) 
                                        <figure class="dd-album-cover" style="background-image:url({{url('/')}}{{$mycoveralbum->media}})">
                                        </figure>
                                        @if(!isset($_GET['memoriesid']) && !isset($_GET['aname']))
                                        
                                      
                                        <a href="javascript:void(0);" onclick="deleteMyAlbum(this)" class="deleet-my-album" data-album="{{$albumid}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                          @endif
                                    @else
                                        <!--<div class="blank-album text-center"> Empty Album</div>-->
                                    @endif
                                      <div class="dd-album-info">
                                        <h6>                                               
                                            @if(!empty($memories->album_name))  
                                            {{$memories->album_name}}
                                            @else
                                                Untitled Album
                                            @endif  
                                        </h6>
                                        @php($totalpics =  $data['newAlbum']->totalpic(['album_id' => $memories->id]))
                                        <strong>{{$totalpics}} Photos</strong>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                             <!--Album section end here-->
                        <hr>
                      </div>
                    </div>
                </div>
           
        </div>
         @else
         <div class="col-md-9 col-xs-12">
            @include('user.media.allPhotos')
          </div>
           @endif
            <div class="col-md-3 pr">
                <div class="dd-advertise-holders">
                  @include('user.sidebar')
              </div>
          </div>
        </div>
    </div>
</section>


  




<!-- Text Modal End -->
<!-- Light Box Modal -->
<!-- <div class="modal fade modal-style gallery-modal" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{asset('/css/assets/img/close-white.png')}}" aria-hidden="true"></button>
            <div class="modal-body">
                <div class="dd-gallery-carousel">
                    <figure class="dd-gallery-image-holder">
                        <img id="image-gallery-image" src="">
                    </figure>
                    <button type="button" id="show-previous-image" class="dd-control left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button type="button" id="show-next-image" class="dd-control right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Album Modal -->
<div class="modal fade" id="albumModel" role="dialog">
    <div class="modal-dialog  modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Your Album</h4>
        </div>
        <div class="modal-body">
          <form action="/photos" id="mediaAlbum" data-toggle="validator" method="post" enctype="multipart/form-data" onsubmit="return validate()">
           {{ csrf_field() }}
         
            <h6>Note: Supported image format: .jpeg, .jpg, .png.</h6>
            <div id="alert1" class="alert-danger hideme"> Please Upload Image in Album</div>

                  
           <div class="form-group">
              
                <label for="albumname" class="control-label">Album Name: <img src="{{url('/')}}/css/assets/loaders/surfhealth.svg" title="Surf Health" class="medialoader"></label>
                <input type="text" placeholder="Enter album Name" id="albumname" name='albumname' class="form-control vol-md" data-error="Please Enter Name of Album" required>
                <!-- <div id="alert2" class="alert-danger hideme" >Please Enter Name of Album</div> -->
                <div class="help-block with-errors"></div>
           </div>
            <div style="clear:both">
              <span id="image_preview"></span>
               <label class="image_preview2 upload_file">
                  <i class="fa fa-plus"></i><br>
                </label>
                <input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple class="up_img upload_file_field upload_img_0" />
            </div>
            <div style="clear:both" >              
               <input type="submit" class="btn btn-info center-block pull-right" value="Create Album" id="selectedButton"/>
            </div> 
            <div style="clear:both" ></div> 
         </form>

        </div>
       <!--  <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
      
    </div>
  </div>

   <div id="editalbumname" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            <h4 class="modal-title">{{app('request')->input('aname')}}</h4>
          </div>
          <div class="modal-body">
            <h4>Rename Your Album</h4>
            
             <form class="form-inline"  action="/photos" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                  <input type="text" class="form-control myname" id="albumnewname" name="renamed" placeholder="Search" value="{{app('request')->input('aname')}}" >
                  <input type="hidden" value="{{app('request')->input('memoriesid')}}" id="hiddenid" name="hiddenid">
              </div>
                  <button class="btn btn-default renameit" type="submit" name="renamealbum" >Rename it</button>
            </form>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
  </div>

  <!-- Add more img in album -->
  <div id="add-more-img" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add more images in album</h4>
        </div>
        <div class="modal-body">
          <form action="/photos/update?memoriesid=<?php echo isset($_GET['memoriesid']) ? $_GET['memoriesid'] : '' ?>" method="post"   enctype="multipart/form-data">
           {{ csrf_field() }}
            <h6>Note: Supported image format: .jpeg, .jpg, .png.</h6>
            <div id="alert1" class="alert-danger hideme"> Please Upload Image in Album</div>
              <div style="clear:both">
                <span id="add_more_image_preview"></span>
                 <label class="add_more_image_preview2 add_more_upload_file">
                    <i class="fa fa-plus"></i><br>
                  </label>
                 <!--  <div class="form-group">
    <label for="inputEmail" class="control-label">Email</label>
    <input type="email" class="form-control" id="inputEmail" placeholder="Email" >
    <div class="help-block with-errors"></div>
  </div> -->
                  <input type="hidden" name="albumname" value="<?php echo isset($_GET['aname']) ? $_GET['aname'] : '' ?>" >
                  <input type="hidden" name="albumid" value="<?php echo isset($_GET['memoriesid']) ? $_GET['memoriesid'] : '' ?>" >
                  <input type="file" id="add_more_img_album" name="more_upload_file[]" onchange="add_more_preview_image();" multiple class="add_more_up_img add_more_upload_file_field add_more_upload_img_0"/>
                <div class="help-block with-errors"></div>
              </div>
              <div style="clear:both" >  
                <input type="submit" class="btn btn-info center-block pull-right" value="Update Album" id="add_more_selectedButton"/>
              </div> 
              <div style="clear:both" > </div>
         </form>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>

    </div>
  </div>

<!-- Modal -->
<div id="uploadPhoto" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Post</h4>
      </div>
      <div class="modal-body">
        @include('user.timeline.postForm')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 @endsection
