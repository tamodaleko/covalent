@extends('layouts.app')

@section('title', 'Create Company')

@section('content')
<div id="page-wrapper">
    <div class="row new_company">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-plus-square"></i> Create Company</h2>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            {!! Form::open(['route' => 'companies.store', 'files' => true]) !!}
                                
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
                                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) }}
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Status') }}
                                        {{ Form::select('status', \App\Models\Company\Company::getStatusList(), old('status'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @if (count($folders))
                                    <div class="col-md-6 col-sm-6 col-xs-12 left">
                                        <br />
                                        <div class="form-group">
                                            {{ Form::label('folders', 'Folders') }}
                                            
                                            <ul class="tree-file" id="permission-folders">
                                                @foreach ($folders as $folder)
                                                    @include('partials.permissions.folders', ['selected' => []])
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
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

@section('modals')
    @include('modals.create_folder')
@endsection
