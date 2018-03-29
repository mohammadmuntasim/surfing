@extends('layouts.app')

@section('content')
<div class="page-title-header">
	<div class="container">
    	<div class="page-tile-wrap">
            <h1 class="main-title"><br><i class="fa fa-user-secret "></i>  Disclaimer </h1>
        </div>
    </div>
</div>
<hr style="border:4px #eee solid">	
<section class="faq">
        	<div class="container">
            	@foreach($data as $data)
                                  @if($data->slug=='providers-discalimer')
                                    {!! $data->body !!}
                                    @endif
                                @endforeach     

            </div>
</section>	
@endsection