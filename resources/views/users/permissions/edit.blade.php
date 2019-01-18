@extends('layouts.app')

@section('title', 'User Permissions')

@section('content')
<div id="page-wrapper">
    <div class="row new_company">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-cogs"></i> User Permissions</h2>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <p class="alert alert-info"><i>Update permissions for:</i> <b>{{ $user->name }}</b></p>

                            @if (!$user->company)
                                <p class="alert alert-danger">User is not part of any company.</p>
                            @elseif (!$folders)
                                <p class="alert alert-danger">User's company doesn't have access to any folder.</p>
                            @endif

                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.permissions.update', $user->id]]) !!}

                                @if ($user->company && $folders)
                                    <div class="dashboard-widget-content">
                                        <div>
                                            <ul class="tree-file">
                                                @foreach ($folders as $folder)
                                                    @include('partials.permissions.folders')
                                                @endforeach
                                            </ul>
                                        </div>
                                        <button type="button" id="create_folder_button" class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal" data-id="" data-company_id="{{ $user->company_id }}">
                                            <i class="fa fa-folder-open-o"></i> Create Folder
                                        </button>
                                    </div>
                                @endif

                                <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                    @if ($user->company && $folders)
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-check"></i> Save
                                        </button>
                                    @endif

                                    <a href="{{ route('users.index') }}" class="btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
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
