<!-- Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display: inline-block;">
                    <i class="fa fa-file-o" aria-hidden="true"></i> Edit Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Will edit status for folder: <b>/Test</b></span>

                <div class="row" style="margin-top: 5px;">
                    <form id="edit_status_form" method="POST">
                        
                        {{ method_field('PATCH') }}
                        {!! csrf_field() !!}

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    
                                    @foreach (\App\Models\Folder::getStatusList() as $key => $status)
                                        <option value="{{ $key }}">{{ $status }}</option>
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
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>