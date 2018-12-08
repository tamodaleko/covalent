@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 file_browser">
                    <div class="x_panel">
                        
                        @if (auth()->user()->is_admin)
                            <div class="x_title">
                                <div class="form-group">
                                    <br>
                                    <select id="company" name="company" class="form-control">
                                        <option value="">Select Company</option>

                                        @foreach (\App\Models\Company\Company::all() as $singleCompany)
                                            <option value="{{ $singleCompany->id }}" @if(app('request')->input('company_id') == $singleCompany->id) selected @endif>
                                                {{ $singleCompany->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                        
                        <div class="x_content">
                            @if (auth()->user()->is_admin && !$company)
                                <p class="alert alert-info">Please select a company to manage files and folders.</p>
                            @elseif (!$company)
                                <p class="alert alert-info">You are not part of any company.</p>
                            @elseif (!$folders)
                                <p class="alert alert-info">The company does not have a main folder set up.</p>
                            @else
                                <div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="dashboard-widget-content">
                                            <h4>
                                                <i class="fa fa-folder-open-o"></i> 
                                                <span style="font-size: 13px;"><i>/ {{ $folders[0]->name }}</i></span>
                                            </h4>
                                            
                                            <div class="btn-sec">
                                                <button type="button" id="upload_file_button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFileModal" data-id="{{ $folders[0]->id }}" data-path="">
                                                    <i class="fa fa-cloud-upload"></i> Upload File
                                                </button>
                                                <button type="button" id="create_folder_button" class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal" data-id="{{ $folders[0]->id }}">
                                                    <i class="fa fa-folder-open-o"></i> Create Folder
                                                </button>
                                                <button type="button" id="edit_status_button" class="btn btn-primary" data-toggle="modal" data-target="#editStatusModal" data-id="{{ $folders[0]->id }}">
                                                    <i class="fa fa-file-o"></i> Edit Status
                                                </button>
                                                <button type="button" id="edit_tag_button" class="btn btn-primary" data-toggle="modal" data-target="#editTagModal" data-id="{{ $folders[0]->id }}">
                                                    <i class="fa fa-tags"></i> Edit Tag
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-xs-12" style="padding-top: 42px;">
                                        <div class="dashboard-widget-content">
                                            <div>
                                                <ul class="tree-file">
                                                    @foreach ($folders as $folder)
                                                        @include('partials.folders')
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    @include('modals.upload_file')
    @include('modals.create_folder')
    @include('modals.edit_status')
    @include('modals.edit_tag')
@endsection
