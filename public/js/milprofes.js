/**
 * Created by Mitxel on 28/07/2015.
 */

var Consent = function() {
    return {
        init: function() {
            var consentIsSet = "unknown";
            var cookieBanner = "#cookieBanner";
            var consentString = "cookieConsent=";

            // Sets a cookie granting/denying consent, and displays some text on console/banner
            function setCookie(consent) {
                $(cookieBanner).hide(); //hide instead of .fadeOut(5000);
                var d = new Date();
                var exdays = 30*12; //  1 year
                d.setTime(d.getTime()+(exdays*24*60*60*1000));
                var expires = "expires="+d.toGMTString();
                document.cookie = consentString + consent + "; " + expires + ";path=/";
                consentIsSet = consent;
            }

            function denyConsent() {
                setCookie("false");
            }

            function grantConsent() {
                if (consentIsSet == "true") return; // Don't grant twice
                setCookie("true");
                initAnalytics();
            }

            function initAnalytics() {
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                ga('create', 'UA-61042823-1', 'auto');
                ga('send', 'pageview');

                initAnalyticsEvents();
            }

            function initAnalyticsEvents() {
                $('#register-link').click(function(){
                    ga('send', 'event', 'attempts', 'registration','');
                });
                $('#register-submit-button').click(function(){
                    ga('send', 'event', 'actions', 'registration','submit');
                });
                $('#register-cancel-button').click(function(){
                    ga('send', 'event', 'actions', 'registration','cancel');
                });
            }

            // main routine
            // First, check if cookie is present
            var cookies = document.cookie.split(";");
            for (var i = 0; i < cookies.length; i++) {
                var c = cookies[i].trim();
                if (c.indexOf(consentString) == 0) {
                    consentIsSet = c.substring(consentString.length, c.length);
                }
            }

            if (consentIsSet == "unknown") {
                $(cookieBanner).fadeIn();
                //For now, consent is only granted when click on any link (unless it is the privacy terms link)
                $("a:not(.noconsent)").click(grantConsent);
                $(".denyConsent").click(denyConsent);
                //Allow cookies re-enabling
                $(".allowConsent").click(grantConsent);
            } else if (consentIsSet == "true") {
                initAnalytics();
            }
        }
    }
}();

var Milprofes = function() {
    return {
        init: function() {
            $("#login-form").validator();
            $("#register-form").validator();
        }
    }
}();

var ResetPassword = function() {
    return {
        init: function() {
            $("#reset-form").validator();
        }
    }
}();

var Contact = function() {
    return {
        init: function() {
            $("#contact").validator();
        }
    }
}();

var ForgotPassword = function() {
    return {
        init: function() {
            $("#forgot-form").validator();
        }
    }
}();

var Home = function() {
    return {
        init: function() {

            //Subject selector manager
            $('.subject-selector').click(function(e){
                e.preventDefault();
                var subjectId = $(this).attr('data-pk');
                $("#subject").val($('#subj-val-'+subjectId).val());
                $("#subject-name").text($('#subj-name-'+subjectId).val());
                $("#keywords").attr("placeholder", $('#subj-ph-'+subjectId).val());
            });

            //Search schools and teachers button handlers
            $('#btn-search-schools').click(function(){
                $("#prof_o_acad").val(trans('js.school'));
                return true;
            });
            $('#btn-search-teachers').click(function(){
                $("#prof_o_acad").val(trans('js.teacher'));
                return true;
            });

            //IP to GEO by Google
            var checknavgeo = navigator.geolocation;
            var couldntResolvePh = $('input[name=couldnt-resolve-ph]').val();
            if(checknavgeo)
                $("#mi-ubicacion").removeClass('hidden');
            $('#mi-ubicacion-link').click(function (e) {
                e.preventDefault();
                if (navigator && checknavgeo) {
                    navigator.geolocation.getCurrentPosition(geo_success, geo_error);
                } else {
                    $("#user_address").attr("placeholder", couldntResolvePh);
                }
            });
            function geo_success(position) {
                printAddress(position.coords.latitude, position.coords.longitude);
            }
            function geo_error() {
                $("#user_address").attr("placeholder", couldntResolvePh);
            }
            function printAddress(latitude, longitude) {
                var geocoder = new google.maps.Geocoder();
                var yourLocation = new google.maps.LatLng(latitude, longitude);
                geocoder.geocode({ 'latLng': yourLocation }, function (results, status) {
                    if(status == google.maps.GeocoderStatus.OK && results[0]) {
                        $('#user_address').val(''+results[0].formatted_address);
                    } else {
                        $("#user_address").attr("placeholder", couldntResolvePh);
                    }
                });
            }

            //init schools carousel
            var carousel = $("#schools-carousel");
            carousel.owlCarousel({
                items: 3,
                loop: true,
                autoWidth: false,
                nav: true,
                navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                dots: false,
                navSpeed: 500,
                autoplaySpeed: 500,
                mouseDrag: false,
                touchDrag: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });

            //init ratings to stars
            $('.stars-container').raty({
                readOnly: true,
                half: true,
                size: 15,
                starHalf: '/img/star-half-small.png',
                starOff : '/img/star-off-small.png',
                starOn  : '/img/star-on-small.png',
                score: function(){return $(this).attr('data-score');}
            });

        }
    }
}();

var TeacherLessonCreate = function() {
    return {
        init: function() {
            $("#create-l-form").validator();

            var text_max = 200;
            var tbox = $('#description');
            var text_length = tbox.val().length;
            var text_remaining = text_max - text_length;
            $('#chars_feedback').html('(' + text_remaining + ' ' + trans('js.remaining-chars') + ')');
            tbox.keyup(function() {
                var text_length = $('#description').val().length;
                var text_remaining = text_max - text_length;
                $('#chars_feedback').html('(' + text_remaining + ' ' + trans('js.remaining-chars') + ')');
            });
        }
    }
}();

var TeacherLessonEdit = function() {
    return {
        init: function() {
            $("#edit-l-form").validator();

            var text_max = 200;
            var tbox = $('#description');
            var text_length = tbox.val().length;
            var text_remaining = text_max - text_length;
            $('#chars_feedback').html('(' + text_remaining + ' ' + trans('js.remaining-chars') + ')');
            tbox.keyup(function() {
                var text_length = $('#description').val().length;
                var text_remaining = text_max - text_length;
                $('#chars_feedback').html('(' + text_remaining + ' ' + trans('js.remaining-chars') + ')');
            });
        }
    }
}();

var MyProfileDashboard = function() {
    return {
        init: function() {

            //Cropping related JS
            var xsize = 160, ysize = 160, imgSlc, boundx, boundy;
            function checkCoords() {
                return !!parseInt($('#w').val());
            }
            //Handle preview "zooming"
            function updatePreview(c) {
                if (parseInt(c.w) > 0) {
                    var rx = xsize / c.w;
                    var ry = ysize / c.h;
                    imgSlc.css({
                        width: Math.round(rx * boundx) + 'px',
                        height: Math.round(ry * boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                    //update form coords
                    $('#x').val(c.x);
                    $('#y').val(c.y);
                    $('#w').val(c.w);
                    $('#h').val(c.h);
                }
            }
            //Generate new canvas, preview and init jcrop
            function readURL(input) {
                if (input.files && input.files[0] && input.files[0].size < 1048576) {
                    $('#file-input').removeClass('has-error');
                    $('#file-input-error').html(trans('js.file-input-info'));
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        //Remove previous content
                        jcrop_api = null;
                        $(".imgCanvas").remove();
                        $(".jcrop-preview").remove();
                        $(".jcrop-holder").remove();
                        //New content
                        var src = e.target.result;
                        var cContainer = $('#canvasContainer');
                        var pContainer = $('#previewContainer');
                        var jcrop_api;
                        cContainer.append('<img src="'+ src +'" class="imgCanvas" alt="' + trans('js.my-new-avatar') + '" />');
                        pContainer.append('<img src="'+ src +'" class="jcrop-preview" alt="' + trans('js.preview') + '" />');
                        //Set new value for the file input
                        $('#cropAvatar').val(src);
                        //Init JCrop
                        var imgCan = $('.imgCanvas');
                        imgSlc = $('.jcrop-preview');
                        //modify jcrop canvas width depending of modal width <=> screen width
                        var wW = $(window).width();
                        var cropModalWidth;
                        if(wW < 768) {
                            cropModalWidth = wW - 93;
                        } else {
                            cropModalWidth = 600 - 60;
                        }
                        imgCan.Jcrop({
                            onChange: updatePreview,
                            onSelect: updatePreview,
                            boxWidth: cropModalWidth,
                            boxHeight: 300,
                            aspectRatio: 1
                        }, function () {
                            // Use the API to get the real image size
                            var bounds = this.getBounds();
                            boundx = bounds[0];
                            boundy = bounds[1];
                            // Store the API in the jcrop_api variable
                            jcrop_api = this;

                            var holderH = $(".jcrop-holder").height();
                            if(holderH<300) {
                                $('#canvasContainer').height(trackerH);
                            }
                        });
                    };
                    reader.readAsDataURL(input.files[0]);
                    $('#cropModal').modal('show');
                } else if(! input.files[0].size < 1048576) {
                    $('#file-input').addClass('has-error');
                    $('#file-input-error').html(trans('js.file-input-error'));
                }
            }
            $("#avatar").change(function(){
                readURL(this);
            });

            //Textboxes char limit feedback
            var text_max = 450;
            var tbox = $('#description');
            var text_length = tbox.val().length;
            var text_remaining = text_max - text_length;
            $('#chars_feedback').html('(' + text_remaining + ' ' + trans('js.remaining-chars') + ')');
            tbox.keyup(function() {
                var text_length = $('#description').val().length;
                var text_remaining = text_max - text_length;
                $('#chars_feedback').html('(' + text_remaining + ' ' + trans('js.remaining-chars') + ')');
            });

            //Forms validation
            $("#user-data").validator();
            $("#user-social").validator();
            $("#user-passwd").validator();

        }
    }
}();

var Availabilities = function() {
    return {
        init: function() {

            var addAvailBtn = $("#avail-control-add"), delAvailBtn = $("#avail-control-del");

            function toggleControlsVisibility(prevPos, nextPos) {
                if(prevPos==8 && nextPos==9)
                    addAvailBtn.addClass("hidden");
                else if(prevPos==2 && nextPos==1)
                    delAvailBtn.addClass("hidden");
                else if(prevPos==1 && nextPos==2)
                    delAvailBtn.removeClass("hidden");
                else if(prevPos==9 && nextPos==8)
                    addAvailBtn.removeClass("hidden");
                else
                if(addAvailBtn.hasClass('hidden'))
                    addAvailBtn.removeClass("hidden");
                if(delAvailBtn.hasClass('hidden'))
                    delAvailBtn.removeClass("hidden");
            }

            function toggleAvailabilityVisibility(prevPos, mode) {
                var nextPos = 0;
                if (mode == 'add') {
                    nextPos = prevPos + 1;
                    $('.availability[data-pos=' + nextPos + ']').removeClass('hidden');
                }else { //mode=='del'
                    $('.availability[data-pos=' + prevPos + ']').addClass('hidden').find('select').val('');
                }
            }

            addAvailBtn.click(function(e){
                e.preventDefault();
                //get prev pos, get next pos
                var nextPos = $('.availability.hidden:first').attr('data-pos');
                if(!nextPos)
                    return false;
                var prevPos = nextPos - 1;
                toggleControlsVisibility(prevPos, nextPos);
                toggleAvailabilityVisibility(prevPos, 'add');
            });

            delAvailBtn.click(function(e){
                e.preventDefault();
                //get prev pos, get next pos
                var firstHidden = $('.availability.hidden:first').attr('data-pos');
                if(firstHidden == 2)
                    return false;
                else if(!firstHidden)
                    firstHidden = 10;
                var prevPos = firstHidden - 1;
                var nextPos = prevPos - 1;
                toggleControlsVisibility(prevPos, nextPos);
                toggleAvailabilityVisibility(prevPos, 'del');
            });

        }
    }
}();

var SchoolEdit = function() {
    return {
        init: function() {

            function resetFormElement(e) {
                e.wrap('<form>').closest('form').get(0).reset();
                e.unwrap();
            }
            function readLogoURL(file,index) {
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.logo-prev-'+index).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
            function readPicURL(file,index) {
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.pic-prev-'+index).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
            function displayLogoPreview(input) {
                if (input.files && input.files[0]) {
                    $('#logopreview').empty();
                    $.each(input.files, function (index, file) {
                        var preview = $('<div class="col-xs-6 col-sm-4 col-md-3">');
                        preview.appendTo('#logopreview');
                        var node = $('<p class="text-left">')
                            .append($('<img height="100" class="thumbnail logo-prev-'+index+'" src="">'))
                            .append($('<span/>').text(file.name));
                        node.appendTo(preview);
                        readLogoURL(file,index);
                    });
                }
            }
            function displayPicsPreview(input) {
                if (input.files && input.files[0]) {
                    $('#picspreview').empty();
                    $.each(input.files, function (index, file) {
                        var preview = $('<div class="col-xs-6 col-sm-4 col-md-3">');
                        preview.appendTo('#picspreview');
                        var node = $('<p class="text-left">')
                            .append($('<img height="100" class="thumbnail pic-prev-'+index+'" src="">'))
                            .append($('<span/>').text(file.name));
                        node.appendTo(preview);
                        readPicURL(file,index);
                    });
                }
            }

            var control = $("#pics");
            $("#remove").click(function() {
                resetFormElement(control);
                $('.btn-file-2-label').text(trans('js.no-pictures-selected'));
            });

            $(document).on('change', '.btn-file-1 :file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
                displayLogoPreview(this);
            });
            $('.btn-file-1 :file').on('fileselect', function(event, numFiles, label) {
                $('.btn-file-1-label').text('' + trans('js.youve-selected-pic') + ' ' + label + ' ' + trans('as-new-logo'));
            });

            $(document).on('change', '.btn-file-2 :file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
                displayPicsPreview(this);
            });
            $('.btn-file-2 :file').on('fileselect', function(event, numFiles, label) {
                $('.btn-file-2-label').text('' + trans('js.youve-selected') + ' ' + numFiles + ' ' + trans('js.new-profile-pics'));
            });

        }
    }
}();

var SchoolsDashboard = function() {
    return {
        init: function() {

            //update schools
            var schools_tbody = $("tbody#schools");
            schools_tbody.on("click", "a[class*='status-']", function (e) {
                e.preventDefault();
                var btn = $(this);
                var schoolId = btn.closest('tr').find('.school-id').val();
                var activeStatus;
                btn.addClass('hidden');
                if (btn.hasClass('status-active')) {
                    btn.next().removeClass('hidden');
                    activeStatus = false;
                } else {
                    btn.prev().removeClass('hidden');
                    activeStatus = true;
                }
                $.post('/admin/updateSchoolStatus',
                    {
                        '_token': $('#token').val(),
                        schoolId: schoolId,
                        activeStatus: activeStatus
                    },
                    function (data) { //controller response
                        //console.log(data);
                    }
                );
            });

            //Schools dashboard datatables config
            $('#table_schools').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json"
                },
                "pagingType": "full_numbers",
                "order": [[ 0, 'asc' ]],
                "pageLength": 10,
                "columns": [
                    { "orderDataType": "dom-text" },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderDataType": "dom-text", "type": "numeric" },
                    { "orderable": false, "searchable": false }
                ]
            });
        }
    }
}();

var SearchResults = function() {
    return {
        init: function() {

            function initRatingStars() {
                $('.lesson-stars').raty({
                    readOnly: true,
                    half: true,
                    starHalf: '/img/star-half.png',
                    starOff : '/img/star-off.png',
                    starOn  : '/img/star-on.png',
                    score: function () { return $(this).attr('data-score'); }
                });
            }
            initRatingStars(); //onload page init rating stars

            function initHandlers() {
                $(".radio").change(function(e) {
                    e.stopImmediatePropagation();
                    async_search(0);
                });
            }
            initHandlers();

            //trigger infinite scrolling/loading of more results
            var triggerScrollingFlag = true;
            $(window).scroll(function() {
                // -(240+352*2) because that's the footer height + two last results height (we trigger this before users reaches the bottom)
                if(($(window).scrollTop() + $(window).height() >= $(document).height() - (240+352*2)) && triggerScrollingFlag && ($('#show-more').val() == 'yes')) {
                    triggerScrollingFlag = false;
                    async_search(parseInt($('#current-slices-showing').val()));
                }
            });

            function async_search(slicesShowing) {
                if(slicesShowing == 0) {
                    $('.search-results-list').empty();
                }
                $('#loading-more-img').removeClass('hidden');
                var soForm = $('form#newSearchForm');
                $.post('/resultados',
                    {
                        _token: soForm.find('input[name=_token]').val(),
                        user_lat: soForm.find('input[name=user_lat]').val(),
                        user_lon: soForm.find('input[name=user_lon]').val(),
                        keywords: soForm.find('input[name=keywords]').val(),
                        user_address: soForm.find('input[name=user_address]').val(),
                        prof_o_acad: $('input[name=prof_o_acad]:checked', '#newSearchForm').val(),
                        search_distance: $('input[name=search_distance]:checked', '#newSearchForm').val(),
                        subject: $('input[name=subject]:checked', '#newSearchForm').val(),
                        price: $('input[name=price]:checked', '#newSearchForm').val(),
                        slices_showing: slicesShowing
                    },
                    function(data) { //handle the controller response
                        $('#price-tags').replaceWith($(data).find('#price-tags'));
                        initHandlers();
                        $('#gmapDiv').replaceWith($(data).find('#gmapDiv'));
                        $('#results-info').replaceWith($(data).find('#results-info'));
                        $(data).find('.search-results-list').children().appendTo(".search-results-list");
                        $('#current-slices-showing').val(slicesShowing+1);
                        $('#show-more').val($(data).find('#show-more').val());
                        initRatingStars();
                        initialize_map();
                    }
                ).always(function(){
                    $('#loading-more-img').addClass('hidden');
                    triggerScrollingFlag = true;
                });
            }

            $("#btn-submit-search").click(function() {
                $('#current-slices-showing').val(0);
                return true;
            });

            $(document).on("click", ".staticMapImg", function() {
                $('.staticMap').hide();
                $('.dynMap').removeClass('hidden');
                initialize_map();
            });

        }
    }
}();

var Profile = function() {
    return {
        init: function() {

            $('.trigger-all-reviews').click(function() {
                var lessonId = $(this).attr('data-lessonId');
                $('#modal-all-reviews-lesson-'+lessonId).modal('show');
            });
            $('.stars-container').raty({
                readOnly: true,
                half: true,
                size: 15,
                starHalf: '/img/star-half-small.png',
                starOff : '/img/star-off-small.png',
                starOn  : '/img/star-on-small.png',
                score: function(){return $(this).attr('data-score');}
            });
            $('.ratings-stars').raty({
                readOnly: true,
                half: true,
                size: 15,
                starHalf: '/img/star-half-small.png',
                starOff : '/img/star-off-small.png',
                starOn  : '/img/star-on-small.png',
                score: function(){return $(this).attr('data-score');}
            });
            $('#review-stars').raty({
                readOnly: false,
                half: true,
                size: 23,
                starHalf: '/img/star-half.png',
                starOff : '/img/star-off.png',
                starOn  : '/img/star-on.png',
                score: function(){return $(this).attr('data-score');}
            });
            var rtext_max = 255;
            var rtbox = $('#review-comment');
            var rtext_length = rtbox.val().length;
            var rtext_remaining = rtext_max - rtext_length;
            $('#rchars_feedback').html('(' + rtext_remaining + ' ' + trans('js.remaining-chars') + ')');
            rtbox.keyup(function() {
                var rtext_length = rtbox.val().length;
                var rtext_remaining = rtext_max - rtext_length;
                $('#rchars_feedback').html('(' + rtext_remaining + ' ' + trans('js.remaining-chars') + ')');
            });

            $('#modal-review').on('hidden.bs.modal', function () {
                formReview.find('input[name=lessonId]').val('-1');
                formReview.find('input[name=score]').val('3');
                formReview.find('textarea[name=comment]').val('');
                $('#rchars_feedback').html('(' + trans('js.255-chars-remaining') + ')');
                $('#review-stars').raty({
                    readOnly: false,
                    half: true,
                    size: 23,
                    starHalf: '/img/star-half.png',
                    starOff : '/img/star-off.png',
                    starOn  : '/img/star-on.png',
                    score: function(){return $(this).attr('data-score');}
                });
            });

            $('.trigger-review').click(function(e){
                e.preventDefault();
                var lessonId = $(this).attr('data-lessonId');
                $('#form-lessonId').val(lessonId);
                $('#modal-review').modal('show');
            });

            $('.trigger-login').click(function(e) {
                e.preventDefault();
                var dynAlert = $('#dynalert');
                dynAlert.removeClass('hidden').show().append('' +
                    '' + trans('js.login-to-comment') +
                    '' + trans('js.no-account-yet') + ' <a href="javascript:" class="trigger-register">' + trans('js.register-for-free') + '</a>' +
                    '');
                $('#modal-login').modal('show');
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

        }
    }
}();

var TeacherProfile = function() {
    return {
        init: function() {

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

            //Teacher profile info related JS
            $('#teacher-stars').raty({
                starHalf: '/img/star-half.png',
                starOff : '/img/star-off.png',
                starOn  : '/img/star-on.png',
                readOnly: true,
                half: true,
                score: $('#teacher-rating').val()
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
                        toastr['success'](''+data.msg, trans('js.review-sent'), {
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
                        toastr['warning'](''+data.msg, trans('js.warning'), {
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
                        toastr['error'](''+data.msg, trans('js.error'), {
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
                        toastr['success'](''+data.msg, trans('js.review-sent'), {
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
                        toastr['warning'](''+data.msg, trans('js.warning'), {
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
                        toastr['error'](''+data.msg, trans('js.error'), {
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
                        toastr['success'](''+data.msg, trans('js.review-sent'), {
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
                        toastr['warning'](''+data.msg, trans('js.warning'), {
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
                        toastr['error'](''+data.msg, trans('js.error'), {
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

            $('.trigger-itsme').click(function(e) {
                e.preventDefault();
                toastr['warning'](trans('js.review-own-not-possible'), trans('js.action-disallowed'), {
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

        }
    }
}();

var SchoolProfile = function() {
    return {
        init: function() {

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

            //School profile info related JS
            $('#school-stars').raty({
                starHalf: '/img/star-half.png',
                starOff : '/img/star-off.png',
                starOn  : '/img/star-on.png',
                readOnly: true,
                half: true,
                score: $('#school-rating').val()
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
                        toastr['success'](''+data.msg, trans('js.review-sent'), {
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
                        toastr['warning'](''+data.msg, trans('js.warning'), {
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
                        toastr['error'](''+data.msg, trans('js.error'), {
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

            $("#contact-me").one("click", function(e) {
                e.preventDefault();
                var schoolId =  $('#schoolId').val();
                var token = $('#_token').val();
                var curso = getUrlParameter('curso');
                $.post('/request/info/school', {
                    dataType: 'json',
                    schoolId: schoolId,
                    courseId: curso,
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
                $.post('/review/school/was/helpful/'+reviewId, {
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
                        toastr['success'](''+data.msg, trans('js.review-sent'), {
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
                        toastr['warning'](''+data.msg, trans('js.warning'), {
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
                        toastr['error'](''+data.msg, trans('js.error'), {
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
                        $('.btn-yes[data-reviewId='+reviewId+']').hide();
                        $('.btn-no[data-reviewId='+reviewId+']').hide();
                        $('.reviewed-thanks[data-reviewId='+reviewId+']').removeClass('hidden');
                        var helpSum = $('.helpSum[data-reviewId='+reviewId+']');
                        if(helpSum.closest('div').find('i').hasClass('fa-plus'))
                            plusMinusOne(helpSum,'minus');
                        if(helpSum.closest('div').find('i').hasClass('fa-minus'))
                            plusMinusOne(helpSum,'plus');
                        toastr['success'](''+data.msg, trans('js.review-sent'), {
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
                        toastr['warning'](''+data.msg, trans('js.warning'), {
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
                        toastr['error'](''+data.msg, trans('js.error'), {
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

        }
    }
}();