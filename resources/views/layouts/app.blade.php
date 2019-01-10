<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="nprogress-busy">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>{{ config('app.name', 'Covalent Metrology') }} | @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-glyphicons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fileupload-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
</head>
<body class="nav-sm">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view" tabindex="5000" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ route('dashboard.index') }}" class="site_title"><img class="img-fluid" src="/img/logo.png" alt="logo"></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Menu profile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            @if (auth()->user()->avatar)
                                <img src="/uploads/images/users/{{ auth()->user()->avatar }}" alt="{{ Auth::user()->name }}" class="img-circle profile_img">
                            @else
                                <img src="/img/user.png" alt="{{ Auth::user()->name }}" class="img-circle profile_img">
                            @endif
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
                                @if (auth()->user()->is_admin)
                                    <li>
                                        <a href="{{ route('companies.index') }}">
                                            <i class="fa fa-building-o" aria-hidden="true"></i>Companies
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('users.create') }}">
                                            <i class="fa fa-user-plus" aria-hidden="true"></i>New User
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('users.index') }}">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>Users
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('permissions.index') }}">
                                            <i class="fa fa-cogs" aria-hidden="true"></i>Permissions
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('users.profile') }}">
                                        <i class="fa fa-address-card-o" aria-hidden="true"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('users.password.update') }}">
                                        <i class="fa fa-key" aria-hidden="true"></i>Change Password
                                    </a>
                                </li>
                                @if (!auth()->user()->is_admin)
                                    <li>
                                        <a href="https://covalentmetrology.com/" target="_blank">
                                            <i class="fa fa-external-link" aria-hidden="true"></i>Covalent Website
                                        </a>
                                    </li>
                                @endif
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
                    </nav>
                </div>
            </div>
            <!-- /Top navigation -->
            <!-- Page content -->
            <div class="right_col" role="main">
                <div class="clearfix"></div>

                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-top: 70px;">
                        <strong>Whoops!</strong> There were some problems with your input:<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="list-style: none;">-{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(Session::has('success'))
                    <p class="alert alert-success" style="margin-top: 70px;">{{ Session::get('success') }}</p>
                @endif

                @if(Session::has('error'))
                    <p class="alert alert-danger" style="margin-top: 70px;"><strong>{{ Session::get('error') }}</strong></p>
                @endif

                @yield('content')
            </div>
            
            <footer>
                <p align="center">
                    Copyright © 2018 | <b>Covalent Metrology</b>
                </p>
            </footer>
            <!-- /Page content -->
        </div>
    </div>

    @yield('modals')

    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width: 0%;"></div></div>
            </td>
            <td class="td-action">
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="fa fa-upload"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Stop</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            <td>
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                </span>
            </td>
            <td>
                <p class="name">
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                </p>
                {% if (file.error) { %}
                    <div><span class="error label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
            </td>
            <td>
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/tmpl.min.js') }}"></script>
    <script src="{{ asset('js/load-image.all.min.js') }}"></script>
    <script src="{{ asset('js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-image.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-audio.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-video.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-validate.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-ui.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>