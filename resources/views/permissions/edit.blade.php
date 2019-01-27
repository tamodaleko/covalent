@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 file_browser">
                    <div class="x_panel">
                        <div class="x_title" style="margin-bottom: 0;">
                            <div class="form-group">
                                <br>
                                <select id="permissions" class="form-control">
                                    @foreach (\App\Models\Company\Company::getList(true) as $companyId => $companyName)
                                        <option value="{{ $companyId }}" @if($company && $company->id === $companyId) selected @endif>
                                            {{ $companyName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <h2 class="not_active">
                                <a href="{{ route('dashboard.index') }}">File Browser</a>
                            </h2>
                            <h2 class="active_state">Permission Management</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            @if (!$users->count())
                                <p class="alert alert-info">Selected company has no users assigned.</p>
                            @elseif (!$folders)
                                <p class="alert alert-info">Selected company has no folders assigned.</p>
                            @else

                                {!! Form::open(['route' => ['permissions.update', 'id' => $company->id]]) !!}

                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <br />
                                            <div class="form-group"">
                                                {{ Form::label('users', 'Users:') }}

                                                @foreach ($users as $user)
                                                    <div class="users-permission">
                                                        <input type="checkbox" name="users[]" value="{{ $user->id }}">
                                                        <span>{{ $user->name }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if ($users->count() && $folders)
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <br />
                                                <div class="form-group">
                                                    {{ Form::label('folders', 'Folders:') }}
                                                    
                                                    <ul class="tree-file" id="permission-folders">
                                                        @foreach ($folders as $folder)
                                                            @include('partials.permissions.folders', ['selected' => []])
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <button type="button" id="create_folder_button" class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal" data-id="" data-company_id="{{ $company->id }}">
                                                    <i class="fa fa-folder-open-o"></i> Create Folder
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                            @if ($users->count() && $folders)
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fa fa-check"></i> Save
                                                </button>
                                            @endif

                                            <a href="{{ route('permissions.index') }}" class="btn btn-default">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </div>
                                    </div>
                                
                                {!! Form::close() !!}

                            @endif
                        
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
