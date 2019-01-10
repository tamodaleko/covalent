$(function () {
    // Modals
    /*************************************************************************/
    $('#uploadFileModal').on('show.bs.modal', function () {
        var folder_id = $('#upload_file_button').data('id');
        $('#folder_id').val(folder_id);
    });

    $('#uploadFileModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    $('#storeFolderModal').on('show.bs.modal', function () {
        var folder_id = $('#create_folder_button').data('id');
        var company_id = $('#create_folder_button').data('company_id');

        $('#company_id').val(company_id);
        $('#parent_folder_id').val(folder_id);
    });

    $('#createFolderModal').on('shown.bs.modal', function (e) {
        var folder_id = $('#create_folder_button').attr('data-id');
        var company_id = $('#create_folder_button').attr('data-company_id');

        $('#input_company_id').val(company_id);
        $('#input_parent_folder_id').val(folder_id);
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
        var url = '/folders/' + id + '/copy';
        $('#copy_folder_form').attr('action', url);
    });

    $('#moveFolderModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var url = '/folders/' + id + '/move';
        $('#move_folder_form').attr('action', url);
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
    /*************************************************************************/

    $('.confirm').click(function (e) {
        return window.confirm('Are you sure?');
    });

    $('#company').on('change', function () {
        window.location.search = 'company_id=' + $(this).val();
    });

    $('#permissions').on('change', function () {
        window.location.href = '/permissions/' + $(this).val();
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

        $('#arrow-' + folder_id + ' i').removeClass('fa-caret-right').addClass('fa-caret-down');
        $('#sub-' + folder_id).show();
        $('#files-' + folder_id).show();

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

function confSubmit(form) {
    if (!confirm('Are you sure?')) {
        return false;
    }

    form.submit();
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function getFolders(company_id) {
    if (!company_id) {
        $('#folders_ajax_container span').html('');
        $('#folders_ajax_container button').hide();
    }

    $.ajax({
        url: '/companies/' + company_id + '/folders',
        cache: false,
        success: function(result) {
            if (result) {
                $('#folders_ajax_container span').html(result);
                $('#folders_ajax_container button').attr('data-id', $('.folder_name').first().data('id'));
                $('#folders_ajax_container button').attr('data-company_id', company_id);
                $('#folders_ajax_container button').show();
            } else {
                $('#folders_ajax_container span').html('');
                $('#folders_ajax_container button').hide();
            }
        }
    });
}

jQuery(function($) {
    $.fn.select2.amd.require([
        'select2/selection/single',
        'select2/selection/placeholder',
        'select2/selection/allowClear',
        'select2/dropdown',
        'select2/dropdown/search',
        'select2/dropdown/attachBody',
        'select2/utils'
    ], function (SingleSelection, Placeholder, AllowClear, Dropdown, DropdownSearch, AttachBody, Utils) {
        var SelectionAdapter = Utils.Decorate(
            SingleSelection,
            Placeholder
        );

        SelectionAdapter = Utils.Decorate(
            SelectionAdapter,
            AllowClear
        );

        var DropdownAdapter = Utils.Decorate(
            Utils.Decorate(
                Dropdown,
                DropdownSearch
            ),
            AttachBody
        );

        var base_element = $('.select2-multiple2')

        $(base_element).select2({
            placeholder: 'Select users',
            selectionAdapter: SelectionAdapter,
            dropdownAdapter: DropdownAdapter,
            theme: "classic",
            allowClear: true,
            templateResult: function (data) {
                if (!data.id) { return data.text; }
                var $res = $('<div></div>');
                $res.text(data.text);
                $res.addClass('wrap');

                return $res;
            },
            templateSelection: function (data) {
                if (!data.id) { return data.text; }
                var selected = ($(base_element).val() || []).length;
                var total = $('option', $(base_element)).length;
                return "Selected " + selected + " of " + total;
            }
        });
    });
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

$('.main_container').on('click', '.folder_name', function () {
    var folder_id = $(this).data('id');

    $('.folder_name').removeClass('active');
    $(this).addClass('active');

    $('#create_folder_button').attr('data-id', folder_id);
});
