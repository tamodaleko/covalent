<!-- Modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                <span>Will create folder under: <b>/Test</b></span>

                <div class="row" style="margin-top: 5px;">
                    <form method="POST" action="{{ route('folders.store') }}">

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
                    <b>Note:</b> Choose available folder on the left panel to specify the target path where your new folder will be created.
                </p>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>