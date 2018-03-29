@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default loginPage">
                <div class="panel-heading">Email Verification</div>
                <div class="panel-body">                                        
                    <?php echo ($alertMessage != '') ? '<div class="alert alert-success">'.$alertMessage.'</div> ' : '' ?>
                    <?php echo ($alertErrmessage != '') ? '<div class="alert alert-danger">'.$alertErrmessage.'</div> ' : '' ?>
                    @if($alertMessage == '')
                        <form  data-toggle="validator" class="form-horizontal login" role="form" method="POST" action="{{ url('/email-resend-verification-send') }}">
                            {{ csrf_field() }}
                            <?php
                                    $claimbvalue = ( isset ( $_GET["claim"] ) && trim ( $_GET["claim"] ) == 'true' ) ? trim ( $_GET["claim"] ) : 'false';
                                    ?>
                            <input id="claim" type="hidden" class="form-control" name="claim"  value="{{$claimbvalue}}" >
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-3 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    
                                    <input id="email" type="email" class="form-control" name="email" placeholder="E-mail" value="{{ $email }}" required autofocus style="border-radius: 0;">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        Send
                                    </button>
                                </div>
                            </div>                            
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
