@extends('layouts.app')
@section('content')
<div class="page-title-header">
	<div class="container">
		<div class="page-tile-wrap">
			<h1 class="main-title text-center">Help</h1>
			<h3 class="sub-title text-center">Get help. Find answers. Here are the top frequently asked questions.</h3>
		</div>
	</div>
</div>
<section class="faq">
<div class="container">
	<div class="row">
		<div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">

			@foreach($data['faqs'] as $faqsvalue)
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="heading{{$faqsvalue->id}}">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$faqsvalue->id}}" aria-expanded="{{($loop->iteration==='1')}}? '1': ''}}" aria-controls="collapse{{$faqsvalue->id}}">{{$faqsvalue->title}}<span class="glyphicon glyphicon-chevron-up pull-right"></span></a>
					</h4>
				</div>
				<div id="collapse{{$faqsvalue->id}}" class="panel-collapse collapse {{($loop->iteration==='1')}}? 'in': ''}}" role="tabpanel" aria-labelledby="heading{{$faqsvalue->id}}">
					<div class="panel-body">{{$faqsvalue->body}}</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
</div>
@endsection