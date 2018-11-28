@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col-xs-12 register-title">
        <h1>Covalent Metrology Customer Data Portal</h1>
        <h3>Registration Page</h3>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="register-content">
            <h2>Welcome to the Registration Page for our Customer Data Portal. The Data Portal will allow us to securely deliver reports and data to customers.</h2> 
            <h4>Please follow these steps:</h4>
            <ul>
                <li>Fill out the registration request form using your work email address, if applicable.</li>
                <li>Open the verification email and click the verification link inside it.</li>
                <li>Receive a registration confirmation email from our Data Portal administrator - which could take several hours.</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div id="login" class="animate form">
            <section class="login_content">

                {!! Form::open(['route' => 'register', 'id' => 'form1', 'class' => 'form-horizontal form-label-left']) !!}
                    
                    <h2>Registration Request Form</h2>

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

                    <div class="col-xs-12">
                        {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                    </div>
                    <div class="col-xs-12">
                        {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                    </div>  
                    <div class="col-xs-12">
                        {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
                    </div>

                    <div class="col-xs-12">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}                            
                    </div>
                    <div class="col-xs-12">
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password Confirmation']) }}
                    </div>

                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-forward"> </i>
                            Sign up
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <p class="sub-btn">Already registered? <b><a href="{{ route('login') }}">Sign In.</a></b></p>
                
                {!! Form::close() !!}
            
            </section>
        </div>
    </div>
</div>
@endsection
