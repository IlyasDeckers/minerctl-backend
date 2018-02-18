@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card card-signup">
                <h2 class="card-title text-center">Add your wallet address</h2>
                <div class="row">

                    <div class="col-md-12">
                        
                        <form class="form-horizontal" method="POST" action="{{ route('addWallet') }}">
                        {{ csrf_field() }}
                            <div class="card-content text-center">
                                {{-- <create-wallet-component></create-wallet-component>
                                <h3>OR</h3>
                                <h5>Use an existing address</h5> --}}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">money</i>
                                    </span>
                                    <input id="name" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus placeholder="Wallet Address...">
                                </div>
                                <div class="col-md-12">
                                    <br>
                                @if (session('walletError'))
                                    <div class="alert alert-danger">
                                        {{ session('walletError') }}
                                    </div>
                                @endif
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
