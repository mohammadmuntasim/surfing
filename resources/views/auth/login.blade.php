@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default loginPage">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                   
                   @if($status = Session::get('showstatus'))
                    

                            <div class="alert alert-success fade in">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>

                                    {{$status}}

                            </div>    
                    
                    @endif
                   

                    <form class="form-horizontal login" role="form" id="loginform" data-toggle="validator" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                      <input id="showerror" type="hidden" class="form-control" name="showerror"  value="1">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="emails" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"   placeholder="E-mail" value="{{ old('email') }}" required autofocus>
                                <div id="login-email-error">
                                     @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>                               
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control"   name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                               
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" name="submit1" id="submit1" class="btn btn-primary ">
                                    Login
                                </button>
                            </div>
                            <?php if(isset($_GET['active'])): ?>
                                <div class="col-md-4">
                                    <a href="{{ url('/email-resend-verification') }}" class="btn btn-primary">
                                        Resend Activation
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
