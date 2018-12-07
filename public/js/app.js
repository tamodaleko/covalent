$(function () {
    $('#createFolderModal').on('show.bs.modal', function () {
        var url = '/folders/1';
        $('#edit_status_form').attr('action', url);
    });

    $('#editStatusModal').on('show.bs.modal', function () {
        var url = '/folders/1';
        $('#edit_status_form').attr('action', url);
    });

    $('#editTagModal').on('show.bs.modal', function () {
        var url = '/folders/1';
        $('#edit_tag_form').attr('action', url);
    });

    $('.confirm').click(function (e) {
        return window.confirm('Are you sure?');
    });

    $('#company').on('change', function () {
        window.location.search = 'company_id=' + $(this).val();
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
    });
});