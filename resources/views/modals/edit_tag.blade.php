<!-- Modal -->
<div class="modal fade" id="editTagModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display: inline-block;">
                    <i class="fa fa-tags" aria-hidden="true"></i> Edit Tag
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Will edit tag for folder: <b>/Test/Bla</b></span>

                <div class="row" style="margin-top: 5px;">
                    <form id="edit_tag_form" method="POST">

                        {{ method_field('PATCH') }}
                        {!! csrf_field() !!}

                        <input type="hidden" name="id">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="text" name="tag" class="form-control" placeholder="Folder Tag">
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