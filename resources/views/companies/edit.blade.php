@extends('layouts.app')

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
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name') }}
                                        {{ Form::text('name', $company->name, ['class' => 'form-control', 'placeholder' => 'Name']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('info', 'Info') }}
                                        {{ Form::text('info', $company->info, ['class' => 'form-control', 'placeholder' => 'Info']) }}
                                    </div>
                                </div>
                                <!-- <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label><span class="txt-lg"> Select Folder :</span></label><span id="show_error" style="display:none"></span><br>
                                        <div id="contentFolder3" class="contentFolder" style="position: relative;"><span class="loading"></span></div>
                                        <button id="btn-panel-create-new-folder" type="button" class="btn btn-info">
                                            <i class="fa fa-folder-open-o"></i>
                                            Create folder
                                        </button>
                                        <p class="help-block">Leave blank if you dont want to assign.</p>
                                    </div>
                                </div> -->
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Status') }}
                                        {{ Form::select('status', \App\Models\Company\Company::getStatusList(), $company->status, ['class' => 'form-control']) }}
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
