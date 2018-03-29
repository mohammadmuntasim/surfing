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
   <style type="text/css">
div#bookingModaldoctor .modal-dialog {
    width: 1000px;
}
.modal-contents {
    border: 2px solid #3d88ed;
}
.booked.your .fa{color: green !important;}
   </style>
 <div class="main-content-holder">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-9 pl">        		
                    <!-- Nav tabs -->
                    <div class="card">
                    <!-- show success message after booked appointment -->
                    @if($data['sucess']==1)
                    <div class="alert alert-success fade in alert-dismissable">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                          YOUR APPOINTMENT HAS BEEN SUCCESSFULLY SUBMITTED.
                    </div>
                    
                    @endif
                    <div id="getday" style="display:none;">{{print_r($data['daysavail'])}}</div>

                    <ul class="nav nav-tabs appointment-tab" role="tablist">
                        <?php if(isset($_GET['ref_app'])) { ?>
                        <li role="presentation"  data-toggle="tooltip" title="Appointment"  class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Book An Appointment </a></li>
                       
                        <?php }else{ ?>
                        <li role="presentation"  class="active"><a href="#myappoold" aria-controls="profile" role="tab" data-toggle="tab">Appointments</a></li>

  <?php } ?>
                     
                    </ul>
                    <!-- Tab panes -->
                    
                    <div class="tab-content appointment-tab-content">
                         <?php // if(isset($_GET['ref_app'])) { ?>
                        <div role="tabpanel" class="tab-pane active " id="home"><div id="dncalendar-container"></div></div>
                        <?php //}else{ ?>
                        
                    </div> 
                  </div>			 
				</div>
				 <div class="col-md-3 pr">
                    <div class="dd-advertise-holders">
                       @include('user.sidebar')
                    </div>
                </div>
	</div>
</div>
</section>
@include('user.bookings.bookappointment')
@include('user.bookings.showpatientsList')
@endsection