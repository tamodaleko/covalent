<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display: inline-block;">
                    <i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload File
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open(['route' => 'files.store', 'files' => true]) !!}

                        <input type="hidden" id="folder_id" name="folder_id">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group" style="text-align: center;">
                                <div class="upload-button" style="width: 100%;">
                                    <a class='btn btn-primary' href='javascript:;' style="width: 100%; margin-bottom: 10px;">
                                        Choose File...
                                        <input type="file" id="upload_file_input" name="file" style="width: 100%;">
                                    </a>
                                    <span class='label label-info' id="upload-file-info"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;" id="file_upload_proceed">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    <i class="fa fa-check"></i> Upload
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <p class="alert alert-info" style="font-size: 12px;">
                    <b>Note:</b> This will upload a new file under the selected path above.
                </p>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>