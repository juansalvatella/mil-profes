/**
 * Created by Mitxel on 14/05/2015.
 */
$(document).ready(function() {

    function getUrlParameter(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++)
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam)
            {
                return sParameterName[1];
            }
        }
    }

    $('.trigger-all-reviews').click(function() {
        var lessonId = $(this).attr('data-lessonId');
        $('#modal-all-reviews-lesson-'+lessonId).modal('show');
    });

    $('#teacher-stars').raty({
        readOnly: true,
        half: true,
        score: $('#teacher-rating').val()
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
        $.post('/review/lesson', {
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
                setTimeout(function(){
                    location.reload();
                },1000);
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
        var teacherId =  $('#teacherId').val();
        var token = $('#_token').val();
        var lesson = getUrlParameter('clase');

        $.get('/request/persData/teacher', {
            dataType: 'json',
            teacherId: teacherId
        }, function(response){
            $('.info-loader').hide();
            if(response.telephone)
                $('span.tlf-number').text(response.telephone);
            $('a.e-mail').attr("href", response.mailto).text(response.email);
        });

        $.post('/request/info/teacher', {
            dataType: 'json',
            teacherId: teacherId,
            lessonId: lesson,
            _token: token
        }, function(data){
            //console.log(data);
        });
    });

    var plusMinusOne = (function(obj, mode) {
        var objVal = parseInt(obj.first().text());
        if(objVal != 0 && objVal != 1) { //avoid changing sign conflict
            if (mode == 'plus')
                objVal++;
            if (mode == 'minus')
                objVal--;
        }
        obj.empty().text(objVal.toString());
        return false;
    });

    $('.itwashelpful').click(function(e) {
        e.preventDefault();
        var reviewId = $(this).attr('data-reviewId');
        var token = $('#_token').val();
        $.post('/review/was/helpful/'+reviewId, {
            dataType: 'json',
            _token: token
        }, function(data){
            if(data.success == 'success') {
                $('.btn-yes[data-reviewId='+reviewId+']').hide();
                $('.btn-no[data-reviewId='+reviewId+']').hide();
                $('.reviewed-thanks[data-reviewId='+reviewId+']').removeClass('hidden');
                var helpSum = $('.helpSum[data-reviewId='+reviewId+']');
                if(helpSum.closest('div').find('i').hasClass('fa-plus'))
                    plusMinusOne(helpSum,'plus');
                if(helpSum.closest('div').find('i').hasClass('fa-minus'))
                    plusMinusOne(helpSum,'minus');
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
        $.post('/review/not/helpful/'+reviewId, {
            dataType: 'json',
            _token: token
        }, function(data){
            if(data.success == 'success') {
                $('.btn-yes[data-reviewId='+reviewId+']').hide();
                $('.btn-no[data-reviewId='+reviewId+']').hide();
                $('.reviewed-thanks[data-reviewId='+reviewId+']').removeClass('hidden');
                var helpSum = $('.helpSum[data-reviewId='+reviewId+']');
                if(helpSum.closest('div').find('i').hasClass('fa-plus'))
                    plusMinusOne(helpSum,'minus');
                if(helpSum.closest('div').find('i').hasClass('fa-minus'))
                    plusMinusOne(helpSum,'plus');
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

    $('.trigger-itsme').click(function(e) {
        e.preventDefault();
        toastr['warning']('No es posible valorar las propias clases.', 'Acción no permitida', {
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
    });

});