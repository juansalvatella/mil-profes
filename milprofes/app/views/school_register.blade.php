@extends('layout')
@section('content')

    <div class="container">

    <div class="page-header">
        <h1>Nueva academia</h1>
    </div>

        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('failure'))
            <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-warning" role="alert">{{ Session::get('error') }}</div>
        @endif

    <form class="form-horizontal" action="{{ action('AdminController@createSchool') }}" method="post" enctype="multipart/form-data" role="form">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="logo">Logotipo</label>
            <div class="col-sm-10">
                <span class="btn btn-default btn-file btn-file-1">
                    Examinar...<input type="file" name="logo"/>
                </span> <span class="btn-file-1-label">No has seleccionado ningún logotipo</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="pics">Imágenes para perfil (grandes)</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="btn btn-default btn-file btn-file-2">
                        Examinar...<input name="pics[]" id="pics" type="file" multiple="multiple" />
                    </span> <span class="btn-file-2-label">No hay imágenes de perfil seleccionadas</span>
                    <span class="input-group-btn left">
                        <button class="btn btn-danger" id="remove" type="button">Cancelar selección</button>
                    </span>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        function resetFormElement(e) {
                            e.wrap('<form>').closest('form').get(0).reset();
                            e.unwrap();
                        }
                        var control = $("#pics");
                        $("#remove").click(function() {
                            resetFormElement(control);
                            $('.btn-file-2-label').text('No hay imágenes de perfil seleccionadas');
                        });
                    });
                </script>
                <script type="text/javascript">
                    $(document).on('change', '.btn-file-1 :file', function() {
                        var input = $(this),
                            numFiles = input.get(0).files ? input.get(0).files.length : 1,
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                        input.trigger('fileselect', [numFiles, label]);
                    });
                    $(document).ready( function() {
                        $('.btn-file-1 :file').on('fileselect', function(event, numFiles, label) {
                            $('.btn-file-1-label').text('Has seleccionado la imagen '+label+' como logotipo');
                        });
                    });
                    $(document).on('change', '.btn-file-2 :file', function() {
                        var input = $(this),
                                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                        input.trigger('fileselect', [numFiles, label]);
                    });
                    $(document).ready( function() {
                        $('.btn-file-2 :file').on('fileselect', function(event, numFiles, label) {
                            $('.btn-file-2-label').text('Has seleccionado '+numFiles+' imágenes para el perfil');
                        });
                    });
                </script>
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
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Crear" class="btn btn-primary"/>
                <a href="{{ url('admin/schools') }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>
    </form>

    </div>

@stop