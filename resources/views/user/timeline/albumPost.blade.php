        <div class='list-groups gallerys'>
            <!-- get all images of album -->
            @php($getAllmediaofAlbum=$data['myphotos']->getMediaAlbum($postvalues->media_id))
           
            <?php
                 $countphotos=intval(sizeof($getAllmediaofAlbum));
                 $setcolumnr=intval(0);
                 $countphotosshow=$countphotos-6;
                if($countphotos<5){
                        if($countphotos != 0)
                        {
                         $setcolumnr=(12/$countphotos);
                         $setcolumnr = round($setcolumnr, 1);
                       }
                 }else{
                     $setcolumnr=4;
                 }
                 
             ?>
             <div class="dd-gallery-4-column">
            @foreach($getAllmediaofAlbum as $key=>$getPhotoUrl)
                @if($key<=4)
                    @if($countphotos<=3)
                        @if($key==0)
                        @php($setcolumnr=12)
                        @else
                        @php($setcolumnr=6)
                        @endif
                    @endif

                    @if($countphotos<=5)
                        @if($key==0 || $key==1)
                        @php($setcolumnr=6)
                        @else
                        @php($setcolumnr=4)
                        @endif
                    @endif
                    @if($countphotos==1)
                        @if($key==0)
                        @php($setcolumnr=12)
                        @endif
                    @endif
                        <div class="col-md-{{$setcolumnr}} padding-none">
                            <div class="dd-gallery-item">
                                <figure class="dd-gallery-image-holder" style="background-image:url({{$getPhotoUrl->media}});">
                                </figure>
                                <div class="dd-gallery-content">
                                    <a class="dd-light-box" href="#" data-image-id="" data-toggle="modal" data-target="#exampleModal{{$postvalues->media_id}}" data-image="{{$getPhotoUrl->media}}" ><i class="fa fa-search" aria-hidden="true"></i></a>
                                   
                                </div>
                            </div>
                        </div> <!-- col- / end -->

                   
                @endif
                 @if($key==5)
                <div class="col-md-{{$setcolumnr}} padding-none">
                    <div class="dd-gallery-item">
                        <figure class="dd-gallery-image-holder" style="background-image:url({{$getPhotoUrl->media}});">
                        </figure>
                        <div class="dd-gallery-content">
                            <a class="dd-light-box" href="#" data-image-id="" data-toggle="modal" data-target="#exampleModal{{$postvalues->media_id}}" data-image="{{$getPhotoUrl->media}}" ><i class="fa fa-searchs" aria-hidden="true">{{$countphotosshow}}</i></a>
                           
                        </div>
                    </div>
                </div> <!-- col- / end -->
                @endif
            @endforeach
            </div>

           

        </div> <!-- list-group / end -->
    
<!-- Modal -->
<div class="modal gallery fade" id="exampleModal{{$postvalues->media_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Album Photos</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <!-- main slider carousel -->
        
            <div class="col-md-12" id="slider">
                
                
                    <div class="col-md-12" id="carousel-bounding-box">
                        <div id="myCarousel" class="carousel slide">
                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
                              @foreach($getAllmediaofAlbum as $key=>$getPhotoUrl)
                                <div class="@if($key==0) active @endif item" data-slide-number="{{$key}}">
                                    <img src="{{$getPhotoUrl->media}}" class="img-responsive">
                                </div>
                              @endforeach
                            </div>
                            <!-- main slider carousel nav controls -->
                            <a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
    
                            <a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>
                        </div>
                    </div>
    
            </div>
        
        <!--/main slider carousel-->
      <!-- thumb navigation carousel -->
       <!--  <div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">
              <!-- thumb navigation carousel items -->
             <!--  <ul class="list-inline">
                 @foreach($getAllmediaofAlbum as $key=>$getPhotoUrl)
              <li>
              <a id="carousel-selector-{{$key}}" @if($key==0) class="selected" @endif>
                <div class="slider-navigation">
                   <img src="{{$getPhotoUrl->media}}" class="img-responsive">
                </div>
              </a></li>
                @endforeach
             
             
                </ul>
        </div> --> 
        
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

