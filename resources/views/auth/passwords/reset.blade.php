@extends('layouts.auth')

@section('content')
<div class="row log-in-page">
    <div class="col-xs-12">
        <div id="login" class="animate form">
            <section class="login_content">
                
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

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
                
                {!! Form::open(['route' => 'password.request', 'id' => 'login', 'class' => 'form-horizontal form-label-left']) !!}
                    
                    <h1>Covalent Reset Password</h1>
                    
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
                            Reset Password
                        </button>
                    </div>
                    <div class="clearfix"></div>

                {!! Form::close() !!}
            
            </section>
        </div>
    </div>
</div>
@endsection
