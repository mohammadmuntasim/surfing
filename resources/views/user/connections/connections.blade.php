@extends('layouts.app')

@section('content')
<style type="text/css">
.main-content-holder .dd-group-list-holder .listimage img {
    min-height: 120px;
    max-height: 120px;
    object-fit: fill;
    margin: 0 auto;
}
.dd-group-list-holder .alert.alert-danger {
    border-radius: 0;
}
.main-content-holder  .hovertext h5 {
    margin: 0 auto;
    bottom: 0;
    margin-top: 60%;
}
.col-md-3.listimage img {
    min-width: 136px;
    max-width: 136px;
}
.dd-group-list-holder .listimage:hover .hovertext {
    margin-left: 12px;
}
ul.dd-info-list li {
    padding: 4px;
}
div#tab1 .col-md-6 {
    padding: 0;
}
</style>
<section class="main-content">
    <div class="dd-userport">
        <div class="container">
            <div class="row"> 
                @include('user.profilehead')
            </div>
        </div>
    </div>
 @php($uid=Auth::user()->id)
   <div class="main-content-holder">
  
        <div class="container">
            <div class="row">
                <!-- <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab1" aria-controls="connections" role="tab" data-toggle="tab">Connections</a></li>
              <li role="presentation" ><a href="#tab2" aria-controls="followers" role="tab" data-toggle="tab">Followers</a></li>
              <li role="presentation" ><a href="#tab3" aria-controls="following" role="tab" data-toggle="tab">Following</a></li>
          </ul>-->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab1">
                @if(empty(app('request')->input('ref_app')))
                <style type="text/css">
                .dd-reffer-list-holder {
    margin-left: -14px;
}
                </style>
                  <div class="col-md-6 pr">
                    @else
                    <div class="col-md-12 pr">
                    @endif
                      
                   <!-- Connection Tabs start-->
                    @include('user.connections.connectionslist')
                    <!-- Connection Tabs end-->
                                              
                  </div>
                  @if(empty(app('request')->input('ref_app')))
                     <!-- Connection request  Tabs start-->
                            @include('user.connections.connection-request')
                    <!-- Connection request Tabs end-->
                  @endif
                </div>
                  
                </div>
                  
                   
                </div>
            </div>
        </div>
    </div>
 
</section>

@endsection
