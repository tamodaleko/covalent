@extends('layouts.app')

@section('title', 'Update Company')

@section('content')
<div id="page-wrapper">
    <div class="row new_company">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-edit"></i> Update Company</h2>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            {!! Form::model($company, ['method' => 'PATCH', 'route' => ['companies.update', $company->id], 'files' => true]) !!}

                                @if ($company->logo)
                                    <div>
                                        <img src="/uploads/images/companies/{{ $company->logo }}" alt="{{ $company->name }}">
                                    </div>
                                    </br>
                                @endif
                                
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('logo', 'Logo') }}
                                        {{ Form::file('logo', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name') }}
                                        {{ Form::text('name', $company->name, ['class' => 'form-control', 'placeholder' => 'Name']) }}
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Status') }}
                                        {{ Form::select('status', \App\Models\Company\Company::getStatusList(), $company->status, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <br />
                                    <div class="form-group">
                                        {{ Form::label('users', 'Users') }}

                                        <select name="users[]" class="select2-multiple2" multiple style="width: 100%;">
                                            @foreach (\App\Models\User\User::all() as $user)
                                                <option value="{{ $user->id }}" @if (in_array($user->id, $users)) selected @endif>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if (count($folders))
                                    <div class="col-md-12 col-sm-12 col-xs-12 left">
                                        <br />
                                        <div class="form-group">
                                            {{ Form::label('folders', 'Folders') }}
                                            
                                            <ul class="tree-file">
                                                @foreach ($folders as $folder)
                                                    @include('partials.permissions.folders')
                                                @endforeach
                                            </ul>
                                        </div>
                                        <button type="button" id="create_folder_button" class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal" data-id="" data-company_id="">
                                            <i class="fa fa-folder-open-o"></i> Create Folder
                                        </button>
                                    </div>
                                @endif
                                <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                    {{ Form::button('<i class="fa fa-check"></i> Save', ['type' => 'submit', 'class' => 'btn btn-default']) }}

                                    <a href="{{ route('companies.index') }}" class="btn btn-default">
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
