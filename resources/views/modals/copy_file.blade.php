<!-- Modal -->
<div class="modal fade" id="copyFileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display: inline-block;">
                    <i class="fa fa-copy" aria-hidden="true"></i> Copy File
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top: 5px;">
                    <form id="copy_file_form" method="POST">

                        {!! csrf_field() !!}

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <select name="folder_id" class="form-control">
                                    <option value="">Select Folder</option>
                                    
                                    @foreach (\App\Models\Folder::getAllowedByCompany($company) as $folder)
                                        <option value="{{ $folder->id }}">
                                            {{ $folder->name }} ( /{{$folder->getPath() }} )
                                        </option>
                                    @endforeach
                                </select>
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
                    <b>Note:</b> This will copy the file to selected folder.
                </p>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>