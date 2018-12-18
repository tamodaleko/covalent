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
                                    <select id="company" class="form-control">
                                        <option value="">Select Company</option>

                                        @foreach (\App\Models\Company\Company::all() as $singleCompany)
                                            <option value="{{ $singleCompany->id }}" @if($company && $company->id === $singleCompany->id) selected @endif>
                                                {{ $singleCompany->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                        
                        <div class="x_content">
                            @if (auth()->user()->is_admin)
                                @if (!$company)
                                    <p class="alert alert-info">Please select a company to manage files and folders.</p>
                                @elseif (!count($folders))
                                    <p class="alert alert-info">The company doesn't have permission to access any folder.</p>
                                @endif
                            @else
                                @if (!$company)
                                    <p class="alert alert-info">You are not part of any company.</p>
                                @elseif (!count($folders))
                                    <p class="alert alert-info">You don't have permission to access any folder.</p>
                                @endif
                            @endif

                            @if ($company && count($folders))
                                <div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="dashboard-widget-content">
                                            <h4>
                                                <i class="fa fa-folder-open-o"></i> 
                                                <span style="font-size: 13px;"><i id="folder_path"> /{{ $folders[0]->getPath() }}</i></span>
                                            </h4>
                                            
                                            <div class="btn-sec">
                                                <button type="button" id="upload_file_button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFileModal" data-id="{{ $folders[0]->id }}">
                                                    <i class="fa fa-cloud-upload"></i> Upload File
                                                </button>
                                                <button type="button" id="create_folder_button" class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal" data-id="{{ $folders[0]->id }}" data-company_id="{{ $company->id }}">
                                                    <i class="fa fa-folder-open-o"></i> Create Folder
                                                </button>
                                                <button type="button" id="edit_status_button" class="btn btn-primary" data-toggle="modal" data-target="#editStatusModal" data-id="{{ $folders[0]->id }}">
                                                    <i class="fa fa-file-o"></i> Edit Status
                                                </button>
                                                <button type="button" id="edit_tag_button" class="btn btn-primary" data-toggle="modal" data-target="#editTagModal" data-id="{{ $folders[0]->id }}">
                                                    <i class="fa fa-tags"></i> Edit Tag
                                                </button>
                                                <button type="button" class="btn btn-primary full" onclick="$('#download-files-form').submit();">
                                                    <i class="fa fa-download"></i> Download Selected
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-xs-12" style="padding-top: 30px;">
                                        <div class="row">
                                            <form method="GET" action="{{ route('dashboard.index') }}">
                                                <div class="input-group search">
                                                    <input name="search" type="text" class="form-control" placeholder="Search for files...">

                                                    <button id="btn-search-new" type="submit" class="btn btn-primary">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="dashboard-widget-content">
                                            <div>
                                                <ul class="tree-file">
                                                    {!! Form::open(['route' => 'files.download', 'id' => 'download-files-form']) !!}
                                                        @foreach ($folders as $folder)
                                                            @include('partials.folders')
                                                        @endforeach
                                                    {!! Form::close() !!}
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
    @include('modals.image_preview')
    @include('modals.copy_folder')
    @include('modals.move_folder')
    @include('modals.copy_file')
    @include('modals.move_file')
@endsection
