@extends('layouts.app')

@section('title', 'Update User')

@section('content')
<div id="page-wrapper">
    <div class="row new_company">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> <i class="fa fa-edit"></i> Update User</h2>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) !!}

                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('first_name', 'First Name') }}
                                        {{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('last_name', 'Last Name') }}
                                        {{ Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('email', 'Email') }}
                                        {{ Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('is_admin', 'Admin') }}
                                        {{ Form::select('is_admin', [0 => 'No', 1 => 'Yes'], $user->is_admin, ['id' => 'admin', 'class' => 'form-control']) }}
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
                                        {{ Form::select('status', \App\Models\User\User::getStatusList(), $user->status, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group" id="company_form_group" @if($user->is_admin) style="display: none;" @endif>
                                        {{ Form::label('company_id', 'Company') }}
                                        {{ Form::select('company_id', \App\Models\Company\Company::getList(true), $user->company_id, ['class' => 'form-control', 'onchange' => 'getFolders(this.value)']) }}
                                    </div>
                                </div>
                                <div id="folders_ajax_container" class="col-md-6 col-sm-6 col-xs-12 left">
                                    <span>
                                        @if ($folders && !$user->is_admin)
                                            @include('partials.permissions.folders_ajax')
                                        @endif
                                    </span>
                                    <button type="button" id="create_folder_button" class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal" data-id="{{ $folders ? $folders[0]->id : '' }}" data-company_id="{{ $user->company_id }}" @if (!$folders || $user->is_admin) style="display: none;" @endif>
                                        <i class="fa fa-folder-open-o"></i> Create Folder
                                    </button>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                    {{ Form::button('<i class="fa fa-check"></i> Save', ['type' => 'submit', 'class' => 'btn btn-default']) }}

                                    <a href="{{ route('users.index') }}" class="btn btn-default">
                                        <i class="fa fa-backward"></i> Exit Without Saving
                                    </a>

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

@section('modals')
    @include('modals.create_folder')
@endsection
