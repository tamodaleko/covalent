$(function () {
    $('#uploadFileModal').on('show.bs.modal', function () {
        var folder_id = $('#upload_file_button').data('id');
        $('#folder_id').val(folder_id);
    });

    $('#createFolderModal').on('show.bs.modal', function () {
        var folder_id = $('#create_folder_button').data('id');
        $('#parent_folder_id').val(folder_id);
    });

    $('#editStatusModal').on('show.bs.modal', function () {
        var folder_id = $('#edit_status_button').data('id');
        var url = '/folders/' + folder_id + '/status';
        $('#edit_status_form').attr('action', url);
    });

    $('#editTagModal').on('show.bs.modal', function () {
        var folder_id = $('#edit_tag_button').data('id');
        var url = '/folders/' + folder_id + '/tag';
        $('#edit_tag_form').attr('action', url);
    });

    $('.confirm').click(function (e) {
        return window.confirm('Are you sure?');
    });

    $('#company').on('change', function () {
        window.location.search = 'company_id=' + $(this).val();
    });

    $('#company_permissions').on('change', function () {
        window.location.href = '/companies/' + $(this).val() + '/permissions';
    });

    $('.arrow').click(function () {
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

    $('.name').click(function () {
        $('.name').removeClass('active');
        $(this).addClass('active');

        var folder_id = $(this).data('id');
        var folder_path = $(this).data('path');

        $('#upload_file_button').attr('data-id', folder_id);
        $('#create_folder_button').attr('data-id', folder_id);
        $('#edit_status_button').attr('data-id', folder_id);
        $('#edit_tag_button').attr('data-id', folder_id);

        $('#folder_path').html('/' + folder_path);
    });
});

$(document).on('change', '#upload_file_input', function () {
    $('#upload-file-info').html($(this).val());
    $('#file_upload_proceed').show();
});