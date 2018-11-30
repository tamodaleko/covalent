<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="gr__dev9_co">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>{{ config('app.name', 'Covalent Metrology') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-glyphicons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body style="background:#fff;" data-gr-c-s-loaded="true">
    <header class="header landing-page-header">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-sm-5 site-branding">
                    <a class="navbar-brand" href="">
                        <img class="img-fluid" src="/img/logo.png" alt="logo" style="width: 100%;">
                    </a>        
                </div>
                <div class="col-12 col-sm-auto"></div>      
            </div>
        </div>
    </header>
    <div>
        <div id="wrapper">
            @yield('content')
        </div>
    </div>
    <div id="container">
        <div class="row">
            <div class="col-xs-12">
                <footer>
                    <p align="center">
                        Copyright © 2018 | <b>Covalent Metrology</b>
                    </p>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>
