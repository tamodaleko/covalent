@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="row log-in-page">
    <div class="col-xs-12">
        <div id="login" class="animate form">
            <section class="login_content">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input:<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="list-style: none;">-{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(Session::has('error'))
                    <p class="alert alert-danger" style="margin-top: 70px;"><strong>{{ Session::get('error') }}</strong></p>
                @endif
                
                {!! Form::open(['route' => 'login', 'id' => 'login', 'class' => 'form-horizontal form-label-left']) !!}
                    
                    <h1>Covalent User Portal</h1>
                    
                    <p class="small">
                        <i class="fa fa-lock"></i> Please login to continue
                    </p>
                    
                    <div class="col-xs-12">
                        {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
                    </div>
                    <div class="col-xs-12">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                    </div>
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-forward"> </i>
                            Sign in
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <p class="sub-btn">Don't have an account? <b><a href="{{ route('register') }}">Register</a></b></p>
                    <p class="sub-btn"><b><a href="{{ route('password.request') }}">Forgot password</a></b></p>
                
                {!! Form::close() !!}
            
            </section>
        </div>
    </div>
</div>
@endsection
