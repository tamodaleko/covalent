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

                                        @foreach (\App\Models\Company\Company::all() as $company)
                                            <option value="{{ $company->id }}" @if(app('request')->input('company_id') == $company->id) selected @endif>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                        
                        <div class="x_content">
                            <div class="col-md-12 col-sm-12 col-xs-12 search-col">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 search-col-inner">
                                    <div class="dashboard-widget-content">
                                        <div>
                                            <ul class="tree-file">

                                                @foreach ($folders as $folder)
                                                    @include('partials.folders')
                                                @endforeach

                                            </ul>
                                        </div>
                                        <div class="btn-sec">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFileModal">
                                                <i class="fa fa-cloud-upload"></i> Upload File
                                            </button>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal">
                                                <i class="fa fa-folder-open-o"></i> Create Folder
                                            </button>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editStatusModal">
                                                <i class="fa fa-file-o"></i> Edit Status
                                            </button>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editTagModal">
                                                <i class="fa fa-tags"></i> Edit Tag
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 search-files">
                                    <div class="clearfix"></div>
                                    <div class="breadcrumbs">
                                        <!-- <ul class="folder-breadcrumb">
                                            <li><i class="fa fa-folder-open-o"></i> <b>Current path :</b> </li>
                                            <li><a href="javascript:;">/</a></li>
                                            <li class="active">Cybernext</li>
                                        </ul> -->
                                    </div>
                                    <!-- <div class="input-group search">
                                        <input id="search" type="text" class="form-control" placeholder="Input file name here">
                                        <button id="btn-search-new" type="button" class="btn btn-primary">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div> -->
                                    <div class="contentfrefix" id="contentfrefix">
                                        <form id="zips" name="zips" action="#" method="post">
                                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th>
                                                            <input value="" type="checkbox" name="multiple_checkbox">
                                                        </th>
                                                        <th class="column-title"></th>
                                                        <th class="column-title">Name</th>
                                                        <th class="column-title">Date Uploaded </th>
                                                        <th class="column-title">Size</th>
                                                        <th class="column-title no-link last"><span class="nobr">Action</span> </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="content-file">
                                                    <tr>
                                                        <td style="padding-left: 11px;">
                                                            <input id="del-1"  type="checkbox" class="flatchk file-checkbox" name="table_records">
                                                            <input id="download-1" class="chk" type="checkbox" name="files[]">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:;" class="img-popup" data-toggle="modal"></a>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-file-image-o"></i>
                                                            <a href="" title="" target="_blank">Amazon S3 File Managers (2).png</a>
                                                        </td>
                                                        <td>Sep 25,2018. 07:08:56</td>
                                                        <td>
                                                            <span>26,1 Kb</span>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:;"><i class="fa fa-cloud-download" ></i> Download</a>
                                                            <a href="javascript:;"><i class="fa fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <!-- <tfoot>
                                                    <tr>
                                                        <td colspan="12">
                                                            <span class="download_btn"><button class="btn btn-info download_all" id="submit" name="createzip" value="Download All" disabled="" type="submit"><i class="fa fa-cloud-download"></i> Download Selected</button></span>
                                                            <a class="btn btn-danger" href="javascript:;">
                                                                <i class="fa fa-trash"> </i> Delete selected
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tfoot> -->
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
