<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="nprogress-busy">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>{{ config('app.name', 'Covalent Metrology') }}</title>

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-glyphicons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fileupload-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom9.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-jvectormap-2.0.1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/green.css') }}" rel="stylesheet">
    <link href="{{ asset('css/floatexamples.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/nprogress.js') }}"></script>
    <script src="{{ asset('js/select2.full.js') }}"></script>
    <script src="{{ asset('js/global17.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    
    <style>
        #contentFolder3 li {
            display: none;
        }
        .file_browser #contentFolder3 li:nth-child(1) {
            display: none;
        }
        #Cybernext {
            display: block !important;
        }
        #contentFolder3 li:nth-child(1) {
            display: block;
        }
        #pCybernext {
            display: block !important;
        }
        #pCybernext > span.sub > .tree-file li {
            display: block;
        }
        #contentFolder3 li:nth-child(1) {
            display: block;
        }
        .fa.fa-bars {
            color: red;
        }
    </style>
</head>
<body class="nav-sm">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view" tabindex="5000" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ route('dashboard.index') }}" class="site_title"><img class="img-fluid" src="/img/cavalent-logo.png" alt="logo"></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Menu profile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="/img/1459167985_users-13.png" alt="{{ Auth::user()->name }}" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                    <!-- /Menu profile quick info -->
                    <div class="clearfix"></div>
                    <!-- Sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li>
                                    <a href="{{ route('dashboard.index') }}">
                                        <i class="fa fa-tasks" aria-hidden="true"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('companies.index') }}">
                                        <i class="fa fa-building-o" aria-hidden="true"></i>Companies
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('users.index') }}">
                                        <i class="fa fa-user-o" aria-hidden="true"></i>Users
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="#">
                                        <i class="fa fa-cogs" aria-hidden="true"></i>Permissions
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-cog" aria-hidden="true"></i>Settings
                                    </a>
                                </li> -->
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>Log Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /Sidebar menu -->
                </div>
            </div>
            <!-- Top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav class="row" role="navigation">
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                        </div>
                        <div class=" col-md-6 col-sm-5 col-xs-4 dashboard-title">
                            <h1>Customer Data Portal</h1>
                        </div>
                        <div class=" col-md-3 col-sm-4 col-xs-9">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="./img/1459167985_users-13.png" alt="">&nbsp;Menu
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                        <li>
                                            <a href="#setting"><i class="fa fa-wrench pull-right"></i>Settings</a>
                                        </li>
                                        <li>
                                            <a href="#change-password"><i class="fa fa-exchange pull-right"></i>
                                                <span>Change password</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- /Top navigation -->
            <!-- Page content -->
            <div class="right_col" role="main">
                <div class="clearfix"></div>

                @if(Session::has('success'))
                    <p class="alert alert-success" style="margin-top: 70px;">{{ Session::get('success') }}</p>
                @endif

                @if(Session::has('error'))
                    <p class="alert alert-danger" style="margin-top: 70px;"><strong>{{ Session::get('error') }}</strong></p>
                @endif

                @yield('content')
            
            </div>
            <!-- /Page content -->
        </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    
    <!-- <div id="error-popup" data-backdrop="static" data-keyboard="false" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div style="width: 80%" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title title-popup" id="myModalLabel2">Oops! Something wrong. Error from server: </h4>
                </div>
                <div class="modal-body" id="content-detail">
                    <div class="alert alert-error" style="word-wrap: break-word;"></div>
                </div>
            </div>
        </div>
    </div> -->
    <div id="ascrail2000" class="nicescroll-rails" style="width: 5px; z-index: auto; cursor: -webkit-grab; position: absolute; top: 0px; left: 65px; height: 740px; display: none; opacity: 0;">
        <div style="position: relative; top: 0px; float: right; width: 5px; height: 740px; background-color: rgba(42, 63, 84, 0.35); border: 0px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px;"></div>
    </div>
    <div id="ascrail2000-hr" class="nicescroll-rails" style="height: 5px; z-index: auto; top: 735px; left: 0px; position: absolute; display: block; width: 70px; opacity: 0;">
        <div style="position: relative; top: 0px; height: 5px; width: 65px; background-color: rgba(42, 63, 84, 0.35); border: 0px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px; left: 0px;"></div>
    </div>
    <div class="jvectormap-tip"></div>
</body>
</html>
