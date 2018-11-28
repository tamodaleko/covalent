@extends('layouts.app')

@section('content')
<div id="page-wrapper">
    <div class="row new_user">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> <i class="fa fa-plus-square"></i> Create User</h2>
                    <hr>
                </div>
                <div class="panel-body">

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

                    <div class="row">
                        <div class="col-lg-12">

                            {!! Form::open(['route' => 'users.store']) !!}

                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('first_name', 'First Name') }}
                                        {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('last_name', 'Last Name') }}
                                        {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('email', 'Email') }}
                                        {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('company', 'Company') }}
                                        <select id="com_id" name="company_id" class="form-control" onchange="getFolders(this.value);">
                                            <option value="">Select Company</option>
                                            <option value="3">cybernext</option>
                                            <option value="10">Hindustan Times Pvt Ltd</option>
                                            <option value="11">IBM India Ltd</option>
                                            <option value="22">sdddsdds</option>
                                            <option value="25">Cybernext 5</option>
                                            <option value="27">Test com 5</option>
                                            <option value="28">Company D</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('password', 'Password') }}
                                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', 'Password Confirmation') }}
                                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password Confirmation']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Status') }}
                                        {{ Form::select('status', \App\Models\User::getStatusList(), old('status'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('is_admin', 'Admin') }}
                                        {{ Form::select('is_admin', [0 => 'No', 1 => 'Yes'], old('is_admin'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                    {{ Form::button('<i class="fa fa-check"></i> Save', ['type' => 'submit', 'class' => 'btn btn-default']) }}
                                    
                                    {{ Form::button('<i class="fa fa-repeat"></i> Reset', ['type' => 'reset', 'class' => 'btn btn-default']) }}
                                </div>
                            
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
