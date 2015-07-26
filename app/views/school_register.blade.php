@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')

    <div class="container">

    <div class="page-header">
        <h1>Nueva academia</h1>
    </div>

    <form class="form-horizontal" action="{{ action('AdminController@createSchool') }}" method="post" enctype="multipart/form-data" role="form">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="form-group">
            <label class="col-sm-2 control-label" for="logo">Logotipo</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="btn btn-default btn-file btn-file-1">
                        Examinar...<input type="file" name="logo"/>
                    </span> <span class="btn-file-1-label">No has seleccionado ningún logotipo</span>
                </div>
                <div class="row top-buffer-10">
                    <div class="col-xs-12" id="logopreview"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="pics">Imágenes para perfil (grandes)</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="btn btn-default btn-file btn-file-2">
                        Examinar...<input name="pics[]" id="pics" type="file" multiple="multiple" />
                    </span> <span class="btn-file-2-label">No hay imágenes de perfil seleccionadas</span>
                </div>
                <div class="row top-buffer-10">
                    <div class="col-xs-12" id="picspreview"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="video">Youtube video code</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="video" id="video" value=""/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">Dirección</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address" id="address"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="cif">CIF</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="cif" id="cif"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">E-Mail</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" id="email"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="phone">Teléfono</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="phone" id="phone"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="phone2">Teléfono (2)</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="phone2" id="phone2"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descripción</label>
            <div class="col-sm-10">
                <textarea rows="3" class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="origin">Origen</label>
            <div class="col-sm-10">
                <select class="form-control" id="origin" name="origin">
                    <option selected="selected" value="admin">Administradores</option>
                    <option value="agent">Comercial</option>
                    <option value="crawled">Crawled</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label">
                <label for="facebook">Facebook</label>
            </div>
            <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                <input class="form-control col-xs-10" placeholder="" type="url" name="facebook" id="facebook" value="" data-error="Introduce una dirección web válida. Ejemplo: http://facebook.com/milprofes">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label">
                <label for="twitter">Twitter</label>
            </div>
            <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                <input class="form-control col-xs-10" placeholder="" type="url" name="twitter" id="twitter" value="" data-error="Introduce una dirección web válida. Ejemplo: http://twitter.com/milprofes">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label">
                <label for="googleplus">Google+</label>
            </div>
            <div class="col-offset-sm-2 col-sm-10">
                <input class="form-control col-xs-10" placeholder="" type="url" name="googleplus" id="googleplus" value="" data-error="Introduce una dirección web válida. Ejemplo: http://plus.google.com/+MilProfes">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label">
                <label for="instagram">Instagram</label>
            </div>
            <div class="col-offset-sm-2 col-sm-10">
                <input class="form-control col-xs-10" placeholder="" type="url" name="instagram" id="instagram" value="" data-error="Introduce una dirección web válida. Ejemplo: http://instagram.com/milprofes">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label">
                <label for="linkedin">LinkedIn</label>
            </div>
            <div class="col-offset-sm-2 col-sm-10">
                <input class="form-control col-xs-10" placeholder="" type="url" name="linkedin" id="linkedin" value="" data-error="Introduce una dirección web válida. Ejemplo: http://es.linkedin.com/in/milprofes">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label">
                <label for="web">Página web</label>
            </div>
            <div class="col-offset-sm-2 col-sm-10">
                <input class="form-control col-xs-10" placeholder="" type="url" name="web" id="web" value="" data-error="Introduce una dirección web válida. Ejemplo: http://www.milprofes.com">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Crear" class="btn btn-primary"/>
                <a href="{{ url('admin/schools') }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>
    </form>

    </div>
@endsection

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function(){
            function resetFormElement(e) {
                e.wrap('<form>').closest('form').get(0).reset();
                e.unwrap();
            }
            function readLogoURL(file,index) {
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.logo-prev-'+index).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            }
            function readPicURL(file,index) {
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.pic-prev-'+index).attr('src', e.target.result);
                    }
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
                $('.btn-file-2-label').text('No hay imágenes de perfil seleccionadas');
            });

            $(document).on('change', '.btn-file-1 :file', function() {
                var input = $(this),
                        numFiles = input.get(0).files ? input.get(0).files.length : 1,
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
                displayLogoPreview(this);
            });
            $('.btn-file-1 :file').on('fileselect', function(event, numFiles, label) {
                $('.btn-file-1-label').text('Has seleccionado la imagen '+label+' como logotipo');
            });

            $(document).on('change', '.btn-file-2 :file', function() {
                var input = $(this),
                        numFiles = input.get(0).files ? input.get(0).files.length : 1,
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
                displayPicsPreview(this);
            });
            $('.btn-file-2 :file').on('fileselect', function(event, numFiles, label) {
                $('.btn-file-2-label').text('Has seleccionado '+numFiles+' imágenes para el perfil');
            });

        });
    </script>
@endsection
