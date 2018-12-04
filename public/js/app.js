$(function() {
    $('#editStatusModal').on('show.bs.modal', function () {
        var url = '/folders/1';
        
        $('#edit_status_form').attr('action', url);
    });

    $('#editTagModal').on('show.bs.modal', function () {
        var url = '/folders/1';
        
        $('#edit_tag_form').attr('action', url);
    });

    $('#company').on('change', function () {
        window.location.search = 'company_id=' + $(this).val();
    });

    $('.arrow').click(function () {
        var parent_id = $(this).data('id');
        
        if ($(this).find('i').hasClass('fa-caret-down')) {
            $(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-right');
            $('#sub-' + parent_id).hide();
        } else {
            $(this).find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
            $('#sub-' + parent_id).show();
        }
    });

    $('.name-prefix').click(function () {
        $('.name-prefix').removeClass('active');
        $(this).addClass('active');

        var folder_id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: '/folders/' + folder_id + '/files',
            success: function (data) {
                var result = '<tr><td colspan="6">There are no files in this folder.</td></tr>';

                if (!jQuery.isEmptyObject(data)) {
                    var result = '';

                    $.each(data, function (key, val) {
                        result += '<tr><td style="padding-left: 11px;"><input id="del-1"  type="checkbox" class="flatchk file-checkbox" name="table_records"><input id="download-1" class="chk" type="checkbox" name="files[]"></td></td>';
                        result += '<td><a href="javascript:;" class="img-popup" data-toggle="modal"></a></td>';
                        result += '<td><i class="fa fa-file-image-o"></i><a href="" title="" target="_blank">'+val['name']+'.png</a></td>';
                        result += '<td>Sep 25,2018. 07:08:56</td>';
                        result += '<td><span>26,1 Kb</span></td>';
                        result += '<td><a href="javascript:;"><i class="fa fa-cloud-download" ></i> Download</a><a href="javascript:;"><i class="fa fa-trash"></i> Delete</a></td></tr>';
                    });
                }

                $('tbody.content-file').html(result);
            }
        });
    });
});