@extends('layouts.app')
@section('content')
<section class="dd-contactus-holder">
	@if($message = Session::has('message'))
	<div class="alert alert-info">
		{{$message}}
	</div>
	@endif
	<div class="container">
		<div class="title-wrap">
			<h3 class="contacttitle text-center"><strong>Contact Us</strong></h3>
			<h3 class="sub-head text-center">
				The health industry is all about caring, and we care about our professionals and users. Our support team is available 24/7 to help you find the care that’s right for you or reach the public and spread your message.
			</h3>
		</div>
		<br>
		<div class="contact-bar secondary-text-color">
			<div class="row text-center">
				<div class="col-lg-6 diff-icon">
					<i class="fa fa-envelope faicon" aria-hidden="true"></i>
					<div><a href="javascript:;" class="text-center text-warning" id="email_contactus">info@surfhealth.com</a></div>
				</div>
				<div class="col-lg-6 diff-icon">
					<i class="fa fa-phone faicon" aria-hidden="true"></i>
					<div class="text-center " id="phone_number_contactus"> 855-407-2454</div>
				</div>
			</div>
		</div>
		<br>
		<div class="ccontainer" id="contact_form_wrapper" style="display: block;">
			<h2 class="secondary-text-color">Send a message</h2>
			<p class="primary-text-color">Fill out a form below to send a message.</p>
			<hr class="contactdivider">
			<div class="row">
				<form class="form-horizontal" name="contactform" id="contactform" role="form" method="POST" action="{{ url('/contactus') }}">
					{{ csrf_field() }}
					<div class="col-md-4 col-sm-6">
						<div class="form-group form-group-lg fname">
							<!-- 	                        <label for="exampleInputEmail1">FULL NAME</label>
								-->	                            <input id="fname" type="text" class="form-control" name="fname" onkeypress="textonly(this)" autofocus placeholder="Full Name">
							<div class="alert alert-info">    </div>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="form-group form-group-lg cemail">
							<!-- 	                        <label for="exampleInputEmail1">EMAIL ADDRESS</label> -->
							<input id="cemail" type="text" class="form-control" name="email" value="{{ old('email') }}"  placeholder="E-maill Address">
							<div class="alert alert-info">    </div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12">
						<div class="form-group form-group-lg phone">
						<input type="text" class="form-control"  name="phone"  onkeypress="return isNumber(event)" id="cphone" maxlength="14"  placeholder="(xxx)xxx-xxxx" >
							<div class="alert alert-info">    </div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="form-group form-group-lg message_area">
							<textarea class="form-control" name="message" id="message_area" placeholder="Start typing your message"></textarea>
							<div class="alert alert-info">    </div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<input type="text"  value="" id="sucessmsg" required>
						<center> <button class="btn btn-warning contactus-form" type="button" onclick="SubmitFormcontact()" >Send Now</button> </center>
						<!-- <a class="btn btn-warning" id="send_btn" href="javascript:;"><span>Send Now</span><i class="custom-loader"></i></a> -->
						<!-- <button class="btn btn-warning" type="submit" class="dd-signup">Send Now</button> -->
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection