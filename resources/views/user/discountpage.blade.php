@extends('layouts.app')

@section('content')
	<section class="dd-discount-contain portfolio-item discount-box-wrap @if(Auth::check()) after-login-header @endif">
	    <div class="container" >
		      <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <div class="discount-box">
                           <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv1.png" alt="" height="93">
                           </a>
                           <h5>
                             <center><a href="#">TurboTax</a></center> 
                           </h5>
                    	    <center><p>Avail Discount of <b>45%</b> </p></center> 
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv2.png"  alt="" height="93">
                        </a>
                        <h5>
                            <center> <a href="#">Best Buy<center></a></center>
                        </h5>
        					<center><p>Avail Discount of <b>35%</b> </p></center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv3.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">Caret & Barel</a></center>
                        </h5>
                    	<center>	<p>Avail Discount of <b>35%</b> </p></center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv4.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">Carasoel Checksl</a></center>
                        </h5>
                        	<center><p>Avail Discount of <b>10%</b> </p></center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive"  src="{{url('/')}}/img/companies/adv5.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">Bed Bath And Beyond</a></center>
                        </h5>
                    		<center><center><p>Avail Discount of <b>45%</b> </p>	</center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv6.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">Oriental Trading</a></center>
                        </h5>
                    		<center><p>Avail Discount of <b>35%</b> </p></center>
                    </div>
              </div>
               <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv7.png" alt="" height="93">
                        </a>
                        <h5>
                           <center><a href="#">Bush Garden</a></center> 
                        </h5>
                       
                        <center><p>Avail Discount of <b>45%</b> </p></center> 
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv8.png"  alt="" height="93">
                        </a>
                        <h5>
                          <center>   <a href="#">Free Tax USA </a></center>
                        </h5>
                          <center>   <p>Avail Discount of <b>35%</b> </p></center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv9.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">Walgreens</a></center>
                        </h5>
                        <center>    <p>Avail Discount of <b>35%</b> </p></center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv10.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">H & R Block</a></center>
                        </h5>
                            <center><p>Avail Discount of <b>10%</b> </p></center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive"  src="{{url('/')}}/img/companies/adv11.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">FTD Coupons</a></center>
                        </h5>
                            <center><center><p>Avail Discount of <b>45%</b> </p>    </center>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <a href="#">
                            <img class="img-responsive" src="{{url('/')}}/img/companies/adv12.png"  alt="" height="93">
                        </a>
                        <h5>
                           <center> <a href="#">Pet Smart</a></center>
                        </h5>
                            <center><p>Avail Discount of <b>35%</b> </p></center>
                    </div>
              </div>
		</div>   
	</section>
    <br><br><br>	 
@endsection