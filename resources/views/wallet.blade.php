@extends('layouts.app')

@section('content')
<div class="col-md-4">
    <div class="card card-profile">
        <div class="card-avatar">
            <a href="#" data-toggle="modal" data-target="#myModal">
                <img class="img" src="{{ '/identicon.php?size=130&hash=' . md5($address) }} '" />">
            </a>

        </div>
        <!-- small modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-small ">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img class="img" src="{{ '/identicon.php?size=252&hash=' . md5($address) }} '" />
                    </div>
                    <div class="modal-footer text-center">
                    </div>
                </div>
            </div>
        </div>
        <!--    end small modal -->
        <div class="card-content">
            <h6 class="category text-gray">Ethereum @if($currency == "etc") Classic @endif</h6>
        <div class="dropdown">
        <button href="#" class="dropdown-toggle btn btn-info btn-round btn-block" data-toggle="dropdown" aria-expanded="true">{{ $address}}
            <b class="caret"></b>
        <div class="ripple-container"></div></button>
        <ul class="dropdown-menu dropdown-menu-left">
            <li class="dropdown-header">Select the wallet to display</li>
            @foreach($wallets as $wallet)
            <li>
                <a href="{{ route('wallets', ['walletAddress' => $wallet->address]) }}">{{ $wallet->address }} ({{ $wallet->currency }})</a>
            </li>
            @endforeach
        </ul>
        </div>
            <h6 class="category text-gray" ></h6>
            <h4 class="card-title" rel="tooltip" data-placement="bottom" data-original-title="{{ $balance->value }} {{ strtoupper($currency) }}">{{ substr($balance->value,0,7) }} {{ strtoupper($currency) }}</h4>
            </br></br>
            <div class="col-md-6" rel="tooltip" data-placement="bottom" data-original-title="1 {{ strtoupper($currency) }} is &euro;{{ $balance->rate_eur }}">
                <p class="description">
                    EUR
                </p>
                <p>
                    &euro;{{ substr($balance->value_eur,0,5) }}
                </p>
            </div>

            <div class="col-md-6" rel="tooltip" data-placement="bottom" data-original-title="1 {{ strtoupper($currency) }} is ${{ $balance->rate_usd }}">
                <p class="description">
                    USD
                </p>
                <p>
                   ${{ substr($balance->value_usd,0,5) }} 
                </p>
            </div>
            <a href="#" class="btn btn-info btn-round" data-toggle="modal" data-target="#recieveModal">Recieve</a>

            <!-- notice modal -->
            <div class="modal fade" id="recieveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-notice">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                            <h5 class="modal-title" id="myModalLabel">Recieve Ethereum @if($currency == "etc") Classic @endif</h5>
                        </div>
                        <div class="modal-body">
                            <div class="instruction">
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Scan the QR code</strong>
                                        <p></p>
                                        {!! html_entity_decode(DNS2D::getBarcodeSVG("4445645656", "QRCODE",12,12)) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="instruction">
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong>Address</strong>
                                        <p>{{ $address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-info btn-round" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end notice modal -->
        </div>
    </div>
</div>

<div class="col-md-8">
    <div class="card">
        
        
        <div class="card-header card-header-icon" data-background-color="blue">
            <i class="material-icons">insert_chart</i>
        </div>
        <div class="card-content table-responsive">
        <div class="card-title" >
            <h4 class="title">Transactions
            <small> - {{ $address }}</small>
        </h4>
        </div>
            <table class="table table-hover">
                <thead class="text-warning">
                    <th>Block</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Value</th>
                    <th>TX</th>
                    <th>Time</th>
                </tr></thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td><a target="_blank" href="https://www.etherchain.org/block/{{ $transaction->blockNumber }}">{{ $transaction->blockNumber}}</td>
                        <td><a target="_blank" href="https://www.etherchain.org/account/{{ $transaction->from }}">{{ substr($transaction->from, 0, 10) . '...' }}</a></td>
                        <td><a target="_blank" href="https://www.etherchain.org/account/{{ $transaction->to }}">{{ substr($transaction->to, 0, 10) . '...' }}</a></td>
                        <td>{{ substr($transaction->value, 0, 7) }} {{strtoupper($currency) }}</td>
                        <td><a target="_blank" href="https://www.etherchain.org/tx/{{ $transaction->hash }}">{{ substr($transaction->hash, 0, 15) . '...' }}</a></td>
                        <td>@if($currency == 'eth') {{ $transaction->timeStamp }} @else {{ $transaction->timestamp }} @endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card" > 
        <div class="card-header card-header-icon" data-background-color="blue">
            <i class="material-icons">insert_chart</i>
        </div>
        <div class="card-content table-responsive">
        <div class="card-title" >
            <h4 class="title">Ethereum @if($currency == "etc") Classic @endif Charts
                <small> - {{ $address }}</small>
            </h4>
        </div>
        @if($currency == "eth")
        <!-- TradingView Widget BEGIN -->
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script type="text/javascript">
        new TradingView.widget({
        "width": "100%",
        "height": 610,
        "symbol": "COINBASE:ETHEUR",
        "interval": "D",
        "timezone": "Europe/Paris",
        "theme": "Dark",
        "style": "0",
        "locale": "en",
        "toolbar_bg": "#f1f3f6",
        "enable_publishing": false,
        "allow_symbol_change": true,
        "hideideas": true
        });
        </script>
        <!-- TradingView Widget END -->
        @else
        <!-- TradingView Widget BEGIN -->
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script type="text/javascript">
        new TradingView.widget({
        "width": "100%",
        "height": 610,
        "symbol": "KRAKEN:ETCEUR",
        "interval": "D",
        "timezone": "Europe/Paris",
        "theme": "Dark",
        "style": "0",
        "locale": "en",
        "toolbar_bg": "#f1f3f6",
        "enable_publishing": false,
        "allow_symbol_change": true,
        "hideideas": true
        });
        </script>
        <!-- TradingView Widget END -->
        @endif
    </div>
</div>

@endsection