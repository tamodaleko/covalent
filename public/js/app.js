/*************************************************************************/
$(function () {
    $('#uploadFileModal').on('show.bs.modal', function () {
        var folder_id = $('#upload_file_button').data('id');
        $('#folder_id').val(folder_id);

        $('.selected-path').html('<small><b>' + $('#folder_path').text() + '</b></small>');
    });

    $('#uploadFileModal').on('hidden.bs.modal', function () {
        $('table tbody.files').empty();
        $('#start_upload').hide();
    });

    $('#storeFolderModal').on('show.bs.modal', function () {
        var folder_id = $('#create_folder_button').data('id');
        var company_id = $('#create_folder_button').data('company_id');

        $('#company_id').val(company_id);
        $('#parent_folder_id').val(folder_id);

        $('.selected-path').html('<small><b>' + $('#folder_path').text() + '</b></small>');
    });

    $('#createFolderModal').on('shown.bs.modal', function (e) {
        var folder_id = $('#create_folder_button').attr('data-id');
        var company_id = $('#create_folder_button').attr('data-company_id');
        var path = $('#create_folder_button').attr('data-path');

        $('#input_company_id').val(company_id);
        $('#input_parent_folder_id').val(folder_id);

        if (path) {
            $('.selected-path').html('<small><b>' + path + '</b></small>');
        }
    });

    $('#editStatusModal').on('show.bs.modal', function () {
        var folder_id = $('#edit_status_button').data('id');
        var url = '/folders/' + folder_id + '/status';
        $('#edit_status_form').attr('action', url);

        $('.selected-path').html('<small><b>' + $('#folder_path').text() + '</b></small>');
    });

    $('#editTagModal').on('show.bs.modal', function () {
        var folder_id = $('#edit_tag_button').data('id');
        var url = '/folders/' + folder_id + '/tag';
        $('#edit_tag_form').attr('action', url);

        $('.selected-path').html('<small><b>' + $('#folder_path').text() + '</b></small>');
    });

    $('#notifyUsersModal').on('shown.bs.modal', function (e) {
        var company_id = $(e.relatedTarget).data('company_id');
        var url = '/companies/' + company_id + '/users/notify';
        $('#notify_users_form').attr('action', url);

        $('#notify_users_select').empty().trigger('change');

        $.ajax({
            url: '/companies/' + company_id + '/users',
            cache: false,
            success: function(result) {
                if (result['users']) {
                    $.each(result['users'], function( index, value ) {
                        var option = new Option(value['name'], value['id']);
                        $(option).html(value['name']);
                        $('#notify_users_select').append(option).trigger('change');
                    });
                }
            }
        });
    });

    $('#imagePreviewModal').on('show.bs.modal', function (e) {
        var url = $(e.relatedTarget).data('url');
        $('#image-preview').attr('src', url);
    });

    $('#renameFolderModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var url = '/folders/' + id + '/rename';
        $('#rename_folder_form').attr('action', url);
    });

    $('#copyFolderModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var company_id = $(e.relatedTarget).data('company_id');
        var url = '/folders/' + id + '/copy';
        $('#copy_folder_form').attr('action', url);

        $('#parent_folder_id_copy').empty();

        $.ajax({
            url: '/companies/' + company_id + '/folders/' + id + '/copy',
            cache: false,
            success: function(result) {
                var option = new Option('Select Folder', '');
                $(option).html('Select Folder');
                $('#parent_folder_id_copy').append(option);

                if (result) {
                    $.each(result, function( index, value ) {
                        var option = new Option(value['path'], value['id']);
                        $(option).html(value['path']);
                        $('#parent_folder_id_copy').append(option);
                    });
                }
            }
        });
    });

    $('#moveFolderModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var company_id = $(e.relatedTarget).data('company_id');
        var url = '/folders/' + id + '/move';
        $('#move_folder_form').attr('action', url);

        $('#parent_folder_id_move').empty();

        $.ajax({
            url: '/companies/' + company_id + '/folders/' + id + '/move',
            cache: false,
            success: function(result) {
                var option = new Option('Select Folder', '');
                $(option).html('Select Folder');
                $('#parent_folder_id_move').append(option);

                if (result) {
                    $.each(result, function( index, value ) {
                        var option = new Option(value['path'], value['id']);
                        $(option).html(value['path']);
                        $('#parent_folder_id_move').append(option);
                    });
                }
            }
        });
    });

    $('#renameFileModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var url = '/files/' + id + '/rename';
        $('#rename_file_form').attr('action', url);
    });

    $('#copyFileModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var url = '/files/' + id + '/copy';
        $('#copy_file_form').attr('action', url);
    });

    $('#moveFileModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var url = '/files/' + id + '/move';
        $('#move_file_form').attr('action', url);
    });

    $('#company').on('change', function () {
        window.location.search = 'company_id=' + $(this).val();
    });

    $('#permissions').on('change', function () {
        window.location.href = '/permissions/' + $(this).val();
    });

    $('#admin').on('change', function () {
        var is_admin = $(this).val();

        if (is_admin == 1) {
            $('#company_form_group').hide();
            $('#folders_ajax_container').hide();
        } else {
            $('#company_form_group').show();
            $('#folders_ajax_container').show();
        }
    });

    $('input:file').change(function () {
        $('#start_upload').show();
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('#create_folder_submit').on('click', function (e) {
        e.preventDefault();

        var button = $(this);
        var company_id = $('#input_company_id').val();
        var parent_folder_id = $('#input_parent_folder_id').val();
        var name = $('#input_name').val();

        button.attr('disabled', true);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: $('#create_folder_form').attr('action'),
            data: { company_id:company_id, parent_folder_id:parent_folder_id, name:name },
            cache: false,
            success: function(result) {
                $('#ajax-alert-error').hide();
                $('#ajax-alert-success').hide();

                if (!result['success']) {
                    $('#ajax-alert-error').html(result['message']).show();
                } else {
                    if (!parent_folder_id) {
                        $('#permission-folders').append(result['html']);
                    } else {
                        $('ul#ul-' + parent_folder_id).append(result['html']);
                        $('#folder_nosub_' + parent_folder_id).hide();
                        $('#folder_caret_' + parent_folder_id).show();
                    }

                    $('#ajax-alert-success').html(result['message']).show();
                }

                button.attr('disabled', false);
                $('#input_name').val('');
                $('#createFolderModal').modal('toggle');
            }
        });
    });
});
/*************************************************************************/



/*************************************************************************/
$('.main_container').on('click', '.confirm', function () {
    return window.confirm('Are you sure?');
});

$('.main_container').on('click', '.arrow', function () {
    var parent_id = $(this).data('id');
    
    if ($(this).find('i').hasClass('fa-caret-down')) {
        $(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-right');
        $('#sub-' + parent_id).hide();
        $('#files-' + parent_id).hide();
    } else {
        $(this).find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
        $('#sub-' + parent_id).show();
        $('#files-' + parent_id).show();
    }
});

$('.main_container').on('click', '.folder_checkbox', function () {
    var id = $(this).val();

    if ($(this).is(':checked')) {
        $('#sub-' + id + ' input[type=checkbox]').prop('checked', true);
    } else {
        $('#sub-' + id + ' input[type=checkbox]').prop('checked', false);
    }
});

$('.main_container').on('click', '.sub_folders_toggle', function () {
    var folder_id = $(this).data('id');
    var caret = $('#folder_caret_' + folder_id);
    var opened = $(':hidden#sub_folders_opened_' + folder_id);

    if ($(this).hasClass('folder_name') && !$(this).hasClass('active')) {
        return;
    }

    if (opened.val() === '0') {
        $('#sub-' + folder_id).show();
        opened.val('1');
    } else {
        $('#sub-' + folder_id).hide();
        opened.val('0');
    }

    if (caret.length != 0) {
        if (caret.find('i').hasClass('fa-caret-down')) {
            caret.find('i').removeClass('fa-caret-down').addClass('fa-caret-right');
        } else {
            caret.find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
        }
    }
});

$('.main_container').on('click', '.name', function () {
    $('.name').removeClass('active');
    $(this).addClass('active');

    var folder_id = $(this).data('id');
    var folder_path = $(this).data('path');

    $('#arrow-' + folder_id + ' i').removeClass('fa-caret-right').addClass('fa-caret-down');
    $('#sub-' + folder_id).show();
    $('#files-' + folder_id).show();

    $('#upload_file_button').attr('data-id', folder_id);
    $('#create_folder_button').attr('data-id', folder_id);
    $('#edit_status_button').attr('data-id', folder_id);
    $('#edit_tag_button').attr('data-id', folder_id);

    $('#folder_path').html('/' + folder_path);
});

$('.main_container').on('click', '.folder_name', function () {
    var folder_id = $(this).data('id');
    var folder_path = $(this).data('path');

    $('.folder_name').removeClass('active');
    $(this).addClass('active');

    $('#create_folder_button').attr('data-id', folder_id);
    $('#create_folder_button').attr('data-path', '/' + folder_path);
});
/*************************************************************************/



/*************************************************************************/
function fileFormSubmit(type, conf = 0) {
    if (conf && !confirm('Are you sure?')) {
        return false;
    }

    var form = $('#files-form');

    form.attr('action', '/files/' + type);
    form.submit();
}

function confSubmit(form) {
    if (!confirm('Are you sure?')) {
        return false;
    }

    form.submit();
}

function getFolders(company_id, user_id) {
    if (!company_id) {
        $('#folders_ajax_container span').html('');
        $('#folders_ajax_container button').hide();
        return;
    }

    $.ajax({
        url: '/companies/' + company_id + '/folders?user_id=' + user_id,
        cache: false,
        success: function(result) {
            if (result) {
                $('#folders_ajax_container span').html(result);
                $('#folders_ajax_container button').attr('data-id', $('.folder_name').first().data('id'));
                $('#folders_ajax_container button').attr('data-company_id', company_id);
                $('#folders_ajax_container button').attr('data-path', '/' + $('.folder_name').first().data('path'));
                $('#folders_ajax_container button').show();
            } else {
                $('#folders_ajax_container span').html('');
                $('#folders_ajax_container button').hide();
            }
        }
    });
}
/*************************************************************************/



/*************************************************************************/
jQuery(function($) {
    $('.select2-multiple').select2MultiCheckboxes({
        placeholder: 'Choose multiple elements',
    });

    $('.select2-multiple2').select2MultiCheckboxes({
        formatSelection: function(selected, total) {
            return 'Selected ' + selected.length + ' of ' + total;
        }
    });

    $('.select2-original').select2({
        placeholder: 'Choose multiple elements',
        width: '100%'
    });
});
/*************************************************************************/
