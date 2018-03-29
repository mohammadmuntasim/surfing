						@php($mytoppic = $data['myphotos']->myselectedphotos($data['currentUserid']))
						@if(sizeof($mytoppic)>0)
						<div class="dd-reffers-holders dd-card fw mg-b15 sidebarphoto">
							<div class="dd-title-holder">
								<h3>Photos</h3>
							</div>
							<div class="dd-reffer-list-holder">
								<div class="dd-reffer-list-holder">
								
								
									<div class="dd-timeline-posts-holder fw" >
                                          
                                         <!--  <div class="dd-content-inner fw dd-card"> -->
                                              
                                              <div class="dd-gallery-4-column">
                                                 @foreach($mytoppic as $mypics)

                                                  <div class="col-md-3" id="media{{$mypics->id}}">
                                                      <div class="dd-gallery-item">
                                                          <figure class="dd-gallery-image-holder" style="background-image:url({{ $mypics->media }});">
                                                          </figure>
                                                          <div class="dd-gallery-content">
                                                              <a class="dd-light-box" href="#" data-image-id="" data-toggle="modal" data-title="This is my title" data-caption="Some lovely red flowers" data-image="{{ $mypics->media }}" data-target="#image-gallery"><i class="fa fa-search" aria-hidden="true"></i></a>
                                                              
                                                          </div>
                                                      </div>
                                                  </div>
                                                  @endforeach
                                                 
                                              
                                               </div>
                                    </div>

								
								
							    </div>
							</div>
						</div>
						@endif