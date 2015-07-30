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
            function setCookie(console_log, banner_text, consent) {
                $(cookieBanner).text(banner_text);
                $(cookieBanner).hide(); //hide instead of .fadeOut(5000);
                var d = new Date();
                var exdays = 30*12; //  1 year
                d.setTime(d.getTime()+(exdays*24*60*60*1000));
                var expires = "expires="+d.toGMTString();
                document.cookie = consentString + consent + "; " + expires + ";path=/";
                consentIsSet = consent;
            }

            function denyConsent() {
                setCookie("Consent denied", "No consientes el uso de cookies en milProfes.", "false");
            }

            function grantConsent() {
                if (consentIsSet == "true") return; // Don't grant twice
                setCookie("Consent granted", "Gracias por consentir el uso de cookies en milProfes.", "true");
                doConsent();
            }

            // Run the consent code. We may be called either from grantConsent() or
            // from the main routine
            function doConsent() {
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
                doConsent();
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
                $("#prof_o_acad").val('academia');
                return true;
            });
            $('#btn-search-teachers').click(function(){
                $("#prof_o_acad").val('profesor');
                return true;
            });

            //IP to GEO by Google
            var checknavgeo = navigator.geolocation;
            if(checknavgeo)
                $("#mi-ubicacion").removeClass('hidden');
            $('#mi-ubicacion-link').click(function (e) {
                e.preventDefault();
                if (navigator && checknavgeo) {
                    navigator.geolocation.getCurrentPosition(geo_success, geo_error);
                } else {
                    $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente"); //TODO!
                }
            });
            function geo_success(position) {
                printAddress(position.coords.latitude, position.coords.longitude);
            }
            function geo_error() {
                $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente"); //TODO!
            }
            function printAddress(latitude, longitude) {
                var geocoder = new google.maps.Geocoder();
                var yourLocation = new google.maps.LatLng(latitude, longitude);
                geocoder.geocode({ 'latLng': yourLocation }, function (results, status) {
                    if(status == google.maps.GeocoderStatus.OK) {
                        if(results[0]) {
                            $('#user_address').val(''+results[0].formatted_address);
                        } else {
                            $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente"); //TODO!
                        }
                    } else {
                        $("#user_address").attr("placeholder", "No se pudo resolver tu dirección, introdúcela manualmente"); //TODO!
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
                starHalf: '../img/star-half-small.png',
                starOff : '../img/star-off-small.png',
                starOn  : '../img/star-on-small.png',
                score: function(){return $(this).attr('data-score');}
            });

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
                $('.btn-file-2-label').text('No hay imágenes de perfil seleccionadas'); //TODO!
            });

            $(document).on('change', '.btn-file-1 :file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
                displayLogoPreview(this);
            });
            $('.btn-file-1 :file').on('fileselect', function(event, numFiles, label) {
                $('.btn-file-1-label').text('Has seleccionado la imagen '+label+' como nuevo logotipo'); //TODO!
            });

            $(document).on('change', '.btn-file-2 :file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
                displayPicsPreview(this);
            });
            $('.btn-file-2 :file').on('fileselect', function(event, numFiles, label) {
                $('.btn-file-2-label').text('Has seleccionado '+numFiles+' imágenes nuevas para el perfil');
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
                        console.log(data);
                    }
                );
            });

            //Schools dashboard datatables config
            $('#table_schools').DataTable({
                "language": {
                    "sProcessing":     "Procesando...", //TODO! 273-293
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
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
                // -240 because that's the footer height, more or less, so we trigger it sooner
                if(($(window).scrollTop() + $(window).height() >= $(document).height() - 240) && triggerScrollingFlag && ($('#show-more').val() == 'yes')) {
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

            $(document).on("click", "#btn-submit-search", function() {
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