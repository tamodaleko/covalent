@extends('layouts.app')

@section('content')
<div id="page-wrapper">
    <div class="row new_company">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-cogs"></i> Company Permissions</h2>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <p class="alert alert-info"><i>Update permissions for:</i> <b>{{ $company->name }}</b></p>
                            
                            {!! Form::model($company, ['method' => 'PATCH', 'route' => ['companies.permissions.update', $company->id]]) !!}

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

                                    <a href="{{ route('companies.permissions.index') }}" class="btn btn-default">
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