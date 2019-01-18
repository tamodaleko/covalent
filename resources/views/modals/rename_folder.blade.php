<!-- Modal -->
<div class="modal fade" id="renameFolderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display: inline-block;">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Rename Folder
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
                <div class="row" style="margin-top: 5px;">
                    <form id="rename_folder_form" method="POST">

                        {!! csrf_field() !!}

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
                    <b>Note:</b> This will rename the selected folder.
                </p>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>