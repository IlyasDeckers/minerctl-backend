@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="dropdown">
            <button href="#" class="dropdown-toggle btn btn-info btn-round btn-block" data-toggle="dropdown" aria-expanded="true">Change Pool
                <b class="caret"></b>
                <div class="ripple-container"></div></button>
                <ul class="dropdown-menu dropdown-menu-left">
                    <li class="dropdown-header">Select the pool to display</li>
                    @foreach($wallets as $wallet)
                    <li>
                        <a href="{{ route('pools', ['walletAddress' => $wallet->address]) }}">{{ $wallet->address }} ({{ $wallet->currency }})</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="orange">
                    <i class="material-icons">content_copy</i>
                </div>
                <div class="card-content">
                    <p class="category">Current Hashrate</p>
                    <h3 class="title" rel="tooltip" data-placement="bottom" data-original-title="Your effective current hashrate. It is calculated according your submitted shares using a 60 minute window. It will take up to 2 hours till the displayed hashrate is accurate. Deviations from your local hashrate are normal.">
                        {{ $ethermine_stats->reportedHashrate }}<small>Mh/s</small>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-danger">warning</i>
                        <a href="#pablo">Get More Space...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="blue">
                    <i class="fa fa-briefcase "></i>
                </div>
                <div class="card-content">
                    <p class="category">Active Workers</p>
                    <h3 class="title">{{ $ethermine_stats->activeWorkers }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Manage your workers
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="red">
                    <i class="material-icons">info_outline</i>
                </div>
                <div class="card-content">
                    <p class="category">Unpaid Balance</p>
                    <h3 class="title">{{ substr($ethermine_stats->unpaid, 0, 6) }}
                        <small>{{ strtoupper($currency) }}</small>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">local_offer</i> Tracked from <a target="_blank" href="https://ethermine.org/miners/{{ $wallet->address }}">ethermine.org</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="green">
                    <i class="fa fa-money"></i>
                </div>
                <div class="card-content">
                    <p class="category">Wallet balance</p>
                    <h3 class="title">{{ substr($wallet_balance, 0, 6) }}
                        <small>{{ strtoupper($currency) }}</small>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">date_range</i> View Wallet
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Hashrate</h4>
                </div>
                <div class="card-content">
                    {!! $chartjs->render() !!}
                </div>
                
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Payouts</h4>
                </div>
                <div class="card-content table-responsive">
                    <table class="table table-hover">
                        <thead class="text-warning">
                            <tr><th>Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>TX</th>
                            </tr></thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->paidOn }}</td>
                                    <td>{{ $payment->start }}</td>
                                    <td>{{ $payment->end }}</td>
                                    <td>{{ substr($payment->amount, 0, 7) }} eth</td>
                                    <td><a href="https://www.etherchain.org/tx/{{ $payment->txHash }}">{{ substr($payment->txHash, 0, 15) . '...' }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
        </div>



        @endsection
