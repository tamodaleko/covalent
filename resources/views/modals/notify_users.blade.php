<!-- Modal -->
<div class="modal fade" id="notifyUsersModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display: inline-block;">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i> Notify Users
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top: 5px;">

                    <div class="col-md-12 no-users" style="display: none;">
                        <p class="alert alert-info">Selected company has no users assigned.</p>
                    </div>
                    
                    <form method="POST" action="" id="notify_users_form">

                        {!! csrf_field() !!}

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('users', 'Users:') }}
                                
                                <select name="users[]" id="notify_users_select" class="select2-multiple2" multiple style="width: 100%;"></select>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('subject', 'Subject:') }}

                                <input type="text" name="subject" class="form-control" placeholder="Subject">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('subject', 'Message:') }}

                                <textarea name="message" class="form-control" placeholder="Message" style="min-height: 150px !important; resize: vertical;"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-send-o"></i> Send
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