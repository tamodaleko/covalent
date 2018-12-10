@extends('layouts.app')

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
                                <p class="alert alert-danger">User's company has access to no folders.</p>
                            @endif

                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.permissions.update', $user->id]]) !!}

                                <div class="dashboard-widget-content">
                                    <div>
                                        <ul class="tree-file">
                                            @foreach ($folders as $folder)
                                                @include('partials.permissions.folders')
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 sub-btn">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-check"></i> Save
                                    </button>

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
