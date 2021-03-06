/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // forceIframeTransport: true,
        url: $(this).attr('action')
    })
    .bind('fileuploaddone', function (e, data) {
        if (data.result.files[0].folder_id) {
            $('span#files-' + data.result.files[0].folder_id + ' ul').append(data.result.files[0].html);
            $('#nosub-' + data.result.files[0].folder_id).hide();
            $('#arrow-' + data.result.files[0].folder_id).html('<span><i class="fa fa-caret-down"></i></span>');
            $('#arrow-' + data.result.files[0].folder_id).show();
        }
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option'
    );

    $('#fileupload').fileupload('option', {
        maxFileSize: 10737418240
    });

    // Load existing files:
    $('#fileupload').addClass('fileupload-processing');
    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#fileupload').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, $.Event('done'), {result: result});
    });
});