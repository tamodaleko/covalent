<!-- Modal -->
<div class="modal fade" id="storeFolderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display: inline-block;">
                    <i class="fa fa-folder-open-o" aria-hidden="true"></i> Create Folder
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <span>Will create folder under: </span><span id="store-folder-selected-folder">/</span>
                    </div>
                </div>
                <div class="row" style="margin-top: 5px;">
                    
                    <form method="POST" action="{{ route('folders.store') }}">

                        {!! csrf_field() !!}

                        <input type="hidden" id="company_id" name="company_id">
                        <input type="hidden" id="parent_folder_id" name="parent_folder_id">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Folder Name">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <p class="alert alert-info" style="font-size: 12px;">
                    <b>Note:</b> This will create a new folder under the selected path above.
                </p>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>