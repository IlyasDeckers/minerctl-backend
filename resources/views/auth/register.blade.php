@extends('layouts.auth')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card card-signup">
                <h2 class="card-title text-center">Register</h2>
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <div class="card-content">
                            <div class="info info-horizontal">
                                <div class="icon icon-rose">
                                    <i class="material-icons">timeline</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Monitor your mining rigs</h4>
                                    <p class="description">
                                        Monitor you daily profits, GPU temperature or hashrate. All features are free for all users.
                                    </p>
                                </div>
                            </div>
                            <div class="info info-horizontal">
                                <div class="icon icon-primary">
                                    <i class="material-icons">code</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Open Source</h4>
                                    <p class="description">
                                        Developer friendly! You can user, review or modify our codebase at your own will. 
                                    </p>
                                </div>
                            </div>
                            <div class="info info-horizontal">
                                <div class="icon icon-info">
                                    <i class="material-icons">group</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">Secure & transparent</h4>
                                    <p class="description">
                                        We do not share or store any sensitive information, MinerCTL cares about your privacy and security. 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                            <div class="card-content">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">face</i>
                                    </span>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Username...">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email...">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password..."/>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password..."/>
                                </div>
                                <!-- If you want to add a checkbox to this form, uncomment this code -->
                                <div class="checkbox">
                                    <label>
                                        <!-- <input type="checkbox" name="optionsCheckboxes"> I agree to the
                                        <a href="#">terms and conditions</a>. -->
                                    </label>
                                </div>
                            </div>
                            <div class="footer text-center">
                                <button type="submit" class="btn btn-primary btn-round">Get Started</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
