var app = {};

var formData = new FormData;

$(document).ajaxStart(function() {
    $('body').css({cursor: 'progress'});
});

$(document).ajaxStop(function() {
    $('body').css({cursor: 'default'});
});