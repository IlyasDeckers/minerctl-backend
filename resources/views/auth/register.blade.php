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
                                        We've created the marketing campaign of the website. It was a very interesting collaboration.
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
                                        We've developed the website with HTML5 and CSS3. The client has access to the code using GitHub.
                                    </p>
                                </div>
                            </div>
                            <div class="info info-horizontal">
                                <div class="icon icon-info">
                                    <i class="material-icons">group</i>
                                </div>
                                <div class="description">
                                    <h4 class="info-title">User Friendly</h4>
                                    <p class="description">
                                        There is also a Fully Customizable CMS Admin Dashboard for this product.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        {{-- <div class="social text-center">
                            <button class="btn btn-just-icon btn-round btn-twitter">
                                <i class="fa fa-twitter"></i>
                            </button>
                            <button class="btn btn-just-icon btn-round btn-dribbble">
                                <i class="fa fa-dribbble"></i>
                            </button>
                            <button class="btn btn-just-icon btn-round btn-facebook">
                                <i class="fa fa-facebook"> </i>
                            </button>
                            <h4> or be classical </h4>
                        </div> --}}
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
                                        <input type="checkbox" name="optionsCheckboxes" required> I agree to the
                                        <a href="#">terms and conditions</a>.
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
