@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default loginPage">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if(!empty($showstatus))
                    
                            @if($showstatus!=1)
                             <div class="alert alert-danger fade in">
                                    {{$showstatus}}
                            </div> 
                            @else
                            <div class="alert alert-success fade in ">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                   Your Email has been verified. Thank You !! 

                            </div> 
                              
                            @endif
                    
                    @endif

                    <form data-toggle="validator" class="form-horizontal" role="form" method="POST" action="{{ url('/claim-profile') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <input id="updateuser" type="hidden" class="form-control" name="updateuser" value="{{ $userid }}"   required autofocus>
                        @if($showstatus==1) 

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="inputPassword" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="inputPassword" type="password" data-minlength="6" class="form-control" name="password" placeholder="New Password" required>
                                <div class="help-block with-errors"></div>
                                
                                <div class="help-blocks">Minimum of 6 characters</div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary"  >
                                    Reset Password
                                </button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
