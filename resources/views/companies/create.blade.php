@extends('layouts.app')

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
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name') }}
                                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('info', 'Info') }}
                                        {{ Form::text('info', old('info'), ['class' => 'form-control', 'placeholder' => 'Info']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 right">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Status') }}
                                        {{ Form::select('status', \App\Models\Company\Company::getStatusList(), old('status'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-sm-6 col-xs-12 left">
                                    <div class="form-group">
                                        {{ Form::label('folder', 'Folder') }}
                                        <div>
                                            <ul class="tree-file">
                                                <li>
                                                    <span class="item">
                                                        <input type="checkbox" name="folder[]" value="Cybernext/" class="chb">
                                                        <a href="javascript:;" class="arrow"><span><i class="fa fa-caret-right"></i></span></a>
                                                        <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name"> Cybernext</span></a>
                                                    </span>
                                                    <span class="sub" style="display: none;">
                                                        <ul class="tree-file">
                                                            <li id="pKamal" class="sub">
                                                                <span class="item Kamal">
                                                                    <input type="checkbox" name="folder[]" value="Cybernext/" class="chb">
                                                                    <span class="no-sub"></span>
                                                                    <i class="fa fa-folder-open-o"></i> <a href="javascript:;"><span class="name-prefix name">Kamal</span></a>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> -->

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
