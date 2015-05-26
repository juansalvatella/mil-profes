/**
 * Created by Mitxel on 14/05/2015.
 */
$(document).ready(function() {

    $('.trigger-all-reviews').click(function() {
        var lessonId = $(this).attr('data-lessonId');
        $('#modal-all-reviews-lesson-'+lessonId).modal('show');
    });

    $('#teacher-stars').raty({
        readOnly: true,
        half: true,
        score: $('#school-rating').val()
    });

    $('.stars-container').raty({
        readOnly: true,
        half: true,
        size: 15,
        starHalf: '../img/star-half-small.png',
        starOff : '../img/star-off-small.png',
        starOn  : '../img/star-on-small.png',
        score: function(){return $(this).attr('data-score');}
    });

    $('.ratings-stars').raty({
        readOnly: true,
        half: true,
        size: 15,
        starHalf: '../img/star-half-small.png',
        starOff : '../img/star-off-small.png',
        starOn  : '../img/star-on-small.png',
        score: function(){return $(this).attr('data-score');}
    });

    $('#review-stars').raty({
        readOnly: false,
        half: true,
        size: 23,
        starHalf: '../img/star-half.png',
        starOff : '../img/star-off.png',
        starOn  : '../img/star-on.png',
        score: function(){return $(this).attr('data-score');}
    });

    var rtext_max = 255;
    var rtbox = $('#review-comment');
    var rtext_length = rtbox.val().length;
    var rtext_remaining = rtext_max - rtext_length;
    $('#rchars_feedback').html('(' + rtext_remaining + ' caracteres disponibles)');
    rtbox.keyup(function() {
        var rtext_length = rtbox.val().length;
        var rtext_remaining = rtext_max - rtext_length;
        $('#rchars_feedback').html('(' + rtext_remaining + ' caracteres disponibles)');
    });

    var formReview = $("#form-review");
    formReview.validator();
    formReview.on("click", "#send-review", function(e) {
        e.preventDefault();
        if($('#send-review').hasClass("disabled"))
            return false;
        var form = $('#form-review');
        var token = form.find('input[name=_token]').val();
        var lessonId = form.find('input[name=lessonId]').val();
        var score = form.find('input[name=score]').val();
        var comment = form.find('textarea[name=comment]').val();
        $.post('/review/school/lesson', {
            dataType: 'json',
            _token: token,
            lessonId: lessonId,
            score: score,
            comment: comment
        }, function (data) {
            $('#modal-review').modal('hide');
            //notify fail/success
            if(data.success == 'success') {
                toastr['success'](''+data.msg, 'Valoración enviada', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else if (data.success == 'warning') {
                toastr['warning'](''+data.msg, 'Aviso', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else if (data.success == 'error') {
                toastr['error'](''+data.msg, 'Error', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        });
    });

    $('#modal-review').on('hidden.bs.modal', function () {
        formReview.find('input[name=lessonId]').val('-1');
        formReview.find('input[name=score]').val('3');
        formReview.find('textarea[name=comment]').val('');
        $('#rchars_feedback').html('(255 caracteres disponibles)');
        $('#review-stars').raty({
            readOnly: false,
            half: true,
            size: 23,
            starHalf: '../img/star-half.png',
            starOff : '../img/star-off.png',
            starOn  : '../img/star-on.png',
            score: function(){return $(this).attr('data-score');}
        });
    });


    $('.trigger-review').click(function(e){
        e.preventDefault();
        var lessonId = $(this).attr('data-lessonId');
        $('#form-lessonId').val(lessonId);
        $('#modal-review').modal('show');
    });

    $("#contact-me").one("click", function(e) {
        e.preventDefault();
        var schoolId =  $('#schoolId').val();
        var token = $('#_token').val();
        $.post('/request/info/school/all/'+schoolId, {
            dataType: 'json',
            _token: token
        }, function(data){
            //console.log(data);
        });
    });

    $('.itwashelpful').click(function(e) {
        e.preventDefault();
        var reviewId = $(this).attr('data-reviewId');
        var token = $('#_token').val();
        $.post('/review/school/was/helpful/'+reviewId, {
            dataType: 'json',
            _token: token
        }, function(data){
            if(data.success == 'success') {
                toastr['success'](''+data.msg, 'Valoración enviada', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else if (data.success == 'warning') {
                toastr['warning'](''+data.msg, 'Aviso', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else if (data.success == 'error') {
                toastr['error'](''+data.msg, 'Error', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        });
    });

    $('.nothelpful').click(function(e) {
        e.preventDefault();
        var reviewId = $(this).attr('data-reviewId');
        var token = $('#_token').val();
        $.post('/review/school/not/helpful/'+reviewId, {
            dataType: 'json',
            _token: token
        }, function(data){
            if(data.success == 'success') {
                toastr['success'](''+data.msg, 'Valoración enviada', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else if (data.success == 'warning') {
                toastr['warning'](''+data.msg, 'Aviso', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else if (data.success == 'error') {
                toastr['error'](''+data.msg, 'Error', {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        });
    });

    var modalLogin = $('#modal-login');
    modalLogin.on('click', '.trigger-register', function (e) {
        e.preventDefault();
        $('#modal-login').modal('hide');
        $('#modal-register').modal('show');
    });

    modalLogin.on('hidden.bs.modal', function () {
        $('#dynalert').empty().hide();
    });

    $('.trigger-login').click(function(e) {
        e.preventDefault();
        var dynAlert = $('#dynalert');
        $('#dynalert').removeClass('hidden');
        dynAlert.show();
        dynAlert.append('' +
            'Accede a milProfes. para realizar valoraciones. ' +
            '¿Aún no tienes cuenta? <a href="javascript:" class="trigger-register">¡Regístrate gratis!</a>' +
        '');
        $('#modal-login').modal('show');
    });

});