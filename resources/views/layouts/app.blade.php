<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Float</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        @if(Auth::user())
        const userId = {{ Auth::user()->id }}
        @endif
    </script>
</head>

<body>
    <div class="wrapper" id="app">
        <div class="sidebar"  data-active-color="rose" data-background-color="white" data-image="/img/sidebar-1.jpg">
            <div class="logo">
                <a href="/home" class="simple-text logo-mini">
                    <i class="material-icons">cloud_queue</i>
                </a>
                <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                    Minerc.tl
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#wallets" class="" aria-expanded="false">
                            <i class="material-icons">account_balance_wallet</i>
                            <p> Wallets
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="wallets" aria-expanded="false" style="">
                            <ul class="nav">
                                <li>
                                    <a href="{{ route('wallets', ['walletAdress' => Auth::user()->wallets->first()->address]) }}">
                                        <span class="sidebar-mini"> VW </span>
                                        <span class="sidebar-normal"> View Wallets </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('createWallet') }}">
                                        <span class="sidebar-mini"> CW </span>
                                        <span class="sidebar-normal"> Create Wallet </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="">
                        <a href="{{ route('pools', ['walletAdress' => Auth::user()->wallets->first()->address]) }}">
                        <i class="material-icons">timeline</i>
                            <p>Pools</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('rigs') }}">
                            <i class="material-icons">settings_input_component</i>
                            <p>Rigs</p>
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
                            <!-- <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="hidden-lg hidden-md">
                                        Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul>
                            </li> -->
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

<!--   Core JS Files   -->
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/app.js"></script>
<script src="/js/material.min.js" type="text/javascript"></script>

<script src="/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Library for adding dinamically elements -->
<script src="/js/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="/js/jquery.validate.min.js"></script>
<!-- Promise Library for SweetAlert2 working on IE -->
<script src="/js/es6-promise-auto.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="/js/chartist.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="/js/bootstrap-notify.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="/js/nouislider.min.js"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="/js/jquery.select-bootstrap.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="/js/sweetalert2.js"></script>

<script src="/js/material-dashboard.js?v=1.2.0"></script>

@include('sweet::alert')


</html>