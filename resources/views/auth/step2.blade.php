@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card card-signup">
                <h2 class="card-title text-center">Enter your Ethereum address</h2>
                <div class="row">

                    <div class="col-md-12">
                        
                        <form class="form-horizontal" method="POST" action="{{ route('addWallet') }}">
                        {{ csrf_field() }}
                            <div class="card-content text-center">
                                <div class=col-md-12>
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
                                <p style="color:black">OR</p>
                                <p><a href="#" data-toggle="modal" data-target="#Ethereum">Create a new wallet</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- notice modal -->
        <div class="modal fade" id="Ethereum" tabindex="-1" role="dialog" aria-labelledby="Ethereum" aria-hidden="true">
            <div class="modal-dialog modal-notice">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                        <h5 class="modal-title" id="Ethereum">Create a new Ethereum wallet</h5>
                    </div>
                    <div class="modal-body">
                        <div class="instruction">
                            <div class="row">
                                <div class="col-md-12">
                                    <create-wallet-component></create-wallet-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end notice modal -->
    </div>
</div>
@endsection
