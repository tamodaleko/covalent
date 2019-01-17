@extends('layouts.app')

@section('title', 'Dashboard')

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
                            @if (!$company)
                                @if (auth()->user()->is_admin)
                                    <p class="alert alert-info">Please select a company to manage files and folders.</p>
                                @else
                                    <p class="alert alert-info">You are not part of any company.</p>
                                @endif
                            @endif

                            @if ($company)
                                <div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="dashboard-widget-content">
                                            <h4>
                                                <i class="fa fa-folder-open-o"></i> 
                                                <span style="font-size: 13px;"><i id="folder_path">{{ $company->name }}</i></span>
                                            </h4>
                                            
                                            <div class="btn-sec">
                                                <button type="button" class="btn btn-primary full" onclick="fileFormSubmit('download');">
                                                    <i class="fa fa-download"></i> Download Selected
                                                </button>
                                                <button type="button" class="btn btn-primary full" onclick="fileFormSubmit('delete', 1);">
                                                    <i class="fa fa-trash-o"></i> Delete Selected
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-xs-12" style="padding-top: 30px;">
                                        <div class="row">
                                            <form method="GET" action="{{ route('dashboard.index') }}">
                                                <div class="input-group search">
                                                    <input name="search" type="text" class="form-control" placeholder="Search for files..." value="{{ request()->get('search') ?: '' }}">

                                                    <button id="btn-search-new" type="submit" class="btn btn-primary">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="dashboard-widget-content">
                                            <div>
                                                @if (!count($files))
                                                    <p class="alert alert-info">There are no files found.</p>
                                                @else
                                                    <ul class="tree-file">
                                                        <form id="files-form" method="post" action="">
                                                            {{ csrf_field() }}
                                                            
                                                            <span>
                                                                <ul class="tree-file">
                                                                    @foreach ($files as $file)
                                                                        @include('partials.file', ['search' => true])
                                                                    @endforeach
                                                                </ul>
                                                            </span>
                                                        </form>
                                                    </ul>
                                                @endif
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
    @include('modals.image_preview')
    @include('modals.rename_file')
    @include('modals.copy_file')
    @include('modals.move_file')
@endsection
