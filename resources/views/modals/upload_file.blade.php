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

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="upload-button">
                                    <a class='btn btn-primary' href='javascript:;'>
                                        Choose File...
                                        <input type="file" id="upload_file_input" name="file">
                                    </a>
                                    <span class='label label-info' id="upload-file-info"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 left" style="display: none;" id="file_upload_proceed">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
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