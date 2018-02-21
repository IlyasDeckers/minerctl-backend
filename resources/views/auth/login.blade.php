@extends('layouts.auth')

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <div class="card card-login card-hidden">
                    <div class="card-header text-center" data-background-color="rose">
                        <h4 class="card-title">Login</h4>
                        <div class="social-line">
                            
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="card-content">
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} label-floating">
                                    <label class="control-label">Email address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} label-floating">
                                    <label class="control-label">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">Let's go</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
