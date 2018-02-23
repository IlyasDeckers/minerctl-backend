<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MinerCTL</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="/css/app.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper" id="app">
        <div class="sidebar"  data-active-color="rose" data-background-color="black" data-image="/img/sidebar-1.jpg">
            <div class="logo">
                <a href="/home" class="simple-text logo-mini">
                    <i class="material-icons">cloud_queue</i>
                </a>
                <a href="http://minerctl.eu" class="simple-text logo-normal">
                    Minerc.tl
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li @if(Request::route()->getName() === 'dashboard') class="active" @endif>
                        <a href="{{ route('dashboard') }}">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li @if(Request::route()->getName() === 'wallets') class="active" @endif>
                        <a href="#wallets" data-toggle="collapse" aria-expanded="false">
                            <i class="material-icons">account_balance_wallet</i>
                            <p> Wallets
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="wallets" aria-expanded="false" style="">
                            <ul class="nav">
                                <li @if(Request::route()->getName() === 'wallets') class="active" @endif>
                                    <a href="{{ route('wallets', ['walletAdress' => Auth::user()->wallets->first()->address]) }}">
                                        <span class="sidebar-mini"> VW </span>
                                        <span class="sidebar-normal"> View Wallets </span>
                                    </a>
                                </li>
                                <li @if(Request::route()->getName() === 'createWallet') class="active" @endif>
                                    <a href="{{ route('createWallet') }}">
                                        <span class="sidebar-mini"> CW </span>
                                        <span class="sidebar-normal"> Create Wallet </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li @if(Request::route()->getName() === 'pools') class="active" @endif>
                        <a href="{{ route('pools', ['walletAdress' => Auth::user()->wallets->first()->address]) }}">
                        <i class="material-icons">timeline</i>
                            <p>Pools</p>
                        </a>
                    </li>
                    <li @if(Request::route()->getName() === 'rigs') class="active" @endif>
                        <a href="{{ route('rigs') }}">
                            <i class="material-icons">settings_input_component</i>
                            <p>Rigs</p>
                        </a>
                    </li>
                    <li @if(Request::route()->getName() === 'userProfile') class="active" @endif>
                        <a href="{{ route('userProfile') }}">
                            <i class="material-icons">settings</i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="material-icons">power_settings_new</i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- <a class="navbar-brand" href="#"> Profile </a> -->
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="{{ route('userProfile') }}">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                            <li>
                                 <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="material-icons">power_settings_new</i>
                                    <p class="hidden-lg hidden-md">power_settings_new</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    

                </div>
            </nav>
            <div class="content" >
                <div class="container-fluid">
                    <div class="row">
                    @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</body>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>

    @if(Auth::user())
    const userId = {{ Auth::user()->id }}
    @endif
</script>
<!--   Core JS Files   -->
<script src="/js/app.js"></script>

<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>



@include('sweet::alert')


</html>
