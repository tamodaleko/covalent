<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 780px;">
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
                    <div class="col-md-12">
                        <span>Selected Path: </span><span class="selected-path">/</span>
                    </div>
                </div>
                <hr style="margin:0;padding:0;" />
                <div class="row" style="margin-top: 15px;">
                    {!! Form::open(['route' => 'files.store', 'id' => 'fileupload', 'files' => true]) !!}

                        <input type="hidden" id="folder_id" name="folder_id">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="fileupload-buttonbar">
                                <div class="fileupload-buttons">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Select files...</span>
                                        <input type="file" name="files[]" multiple>
                                    </span>
                                    <button id="start_upload" type="submit" class="btn btn-primary start" style="display: none;">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Start upload</span>
                                    </button>
                                    <!-- The global file processing state -->
                                    <span class="fileupload-process"></span>
                                </div>
                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                        </div>
                    {!! Form::close() !!}
                </div>
                <p class="alert alert-info" style="font-size: 12px;">
                    <b>Note:</b> Don't close this popup until the upload is complete, but you can leave it running in the background.
                </p>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>