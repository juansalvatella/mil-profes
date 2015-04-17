@extends('layout')
@section('content')

<div class="container-fluid top-padding-25 bottom-padding-150 background-lamp">

    <div class="profile-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">

                    <div class="profile-image"><img src="{{ asset('img/avatars/'.$user->avatar) }}" title="{{ $user->username }} logo" alt="{{ $user->username }}"></div>

                    <div class="profile-title">
                        <div><h1 class="profile-maintitle">Mi panel de control</h1></div>
                        <div><h2 class="profile-subtitle">Profe. {{ $user->name }}</h2></div>
                    </div>

                </div>
                <div class="pull-right">
                    @if($user->hasRole("admin"))
                        <a href="{{ url('admin/reviews') }}" class="btn btn-primary">Administrar valoraciones</a>
                        <a href="{{ url('admin/schools') }}" class="btn btn-warning">Administrar academias</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
<div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-tabs-profile magic-align-2 container" role="tablist">
        <li role="presentation" class="active"><a href="#teacher_tab" aria-controls="teacher_tab" role="tab" data-toggle="tab">Mis clases</a></li>
        <li role="presentation"><a href="#profile_tab" aria-controls="profile_tab" role="tab" data-toggle="tab">Mi Perfil</a></li>
    </ul>

    <div class="tab-content container user-box top-padding-50 bottom-padding-50" role="tabpanel">
        <div role="tabpanel" class="tab-pane active" id="teacher_tab">

            <div class="col-xs-12">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
                @elseif(Session::has('failure'))
                    <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
                @endif
            </div>

            {{ $content_teacher }}

        </div>
        <div role="tabpanel" class="tab-pane" id="profile_tab">

            <div class="container-fluid top-padding-25 bottom-padding-25">

                <div class="col-xs-12 bottom-buffer-35">
                    <span class="school-rating-span">Mi imagen de perfil</span>
                </div>

                <form class="form-horizontal">
                    <div class="col-xs-12 form-group" id="file-input">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="avatar">Mi imagen de perfil</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <span class="btn btn-default btn-file btn-file-user1">
                            Nueva imagen<input type="file" name="avatar" id="avatar" />
                            </span>
                            <div class="help-block with-errors"><small id="file-input-error">Puedes utilizar imágenes del tipo JPG, PNG o GIF y tamaño inferior a 1 MB.</small></div>
                        </div>
                    </div>
                </form>



                <form class="form-horizontal" action="{{ action('UsersController@updateUser') }}" method="post" enctype="multipart/form-data" role="form" id="user-data">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 bottom-buffer-35">
                        <span class="school-rating-span">Mis datos personales</span>
                    </div>

                    {{--<div class="col-xs-12 form-group">--}}
                        {{--<div class="col-xs-12 col-sm-2 control-label">--}}
                            {{--<label class="" for="avatar">Mi imagen de perfil</label>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-12 col-offset-sm-2 col-sm-10">--}}
                            {{--<span class="btn btn-default btn-file btn-file-user1">--}}
                            {{--Nueva imagen<input type="file" name="avatar" id="avatar"/>--}}
                            {{--</span>--}}
                            {{--<div class="help-block with-errors"><small>Puedes utilizar imágenes del tipo JPG, PNG o GIF</small></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="name">Nombre (*)</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tu nombre" type="text" name="name" id="name" value="{{{ $user->name }}}" maxlength="50" required="required" data-error="Rellena este campo.">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="lastname">Apellidos</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tus apellidos" type="text" name="lastname" id="lastname" value="{{{ $user->lastname }}}" maxlength="100">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="address">Dirección (*)</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="Mi calle, número, ciudad..." type="text" name="address" id="address" value="{{{ $user->address }}}" maxlength="200" required="required" data-error="Rellena este campo.">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="email">{{{ @trans('messages.e_mail') }}} (*)</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="Tu e-mail" type="email" name="email" id="email" value="{{{ $user->email }}}" required="required" data-error="Introduce una dirección válida de correo electrónico.">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="phone">Teléfono</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="Tu teléfono de contacto" type="text" name="phone" id="phone" value="{{{ $user->phone }}}" pattern="^([0-9]){5,}$" maxlength="20">
                            <small><div class="help-block with-errors">Sólo números, sin espacios</div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="description">Mi descripción</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <textarea rows="3" placeholder="Descríbete..." class="form-control" name="description" id="description"  maxlength="450">{{ $user->description }}</textarea>
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-10">
                                <div class="col-xs-12">
                                    <span class="hidden-sm hidden-md hidden-lg left-buffer-15"></span><input type="submit" value="Actualizar datos" class="btn btn-primary"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <form class="form-horizontal" action="{{ action('UsersController@updateUserPasswd') }}" method="post" enctype="multipart/form-data" role="form" id="user-passwd">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 top-buffer-35 bottom-buffer-35">
                        <span class="school-rating-span">Cambiar contraseña</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="old_password">Contraseña actual</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="Contraseña actual" type="password" name="old_password" id="old_password" required="required" pattern=".{6,}" data-error="Introduce tu contraseña actual.">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="new_password">Nueva contraseña</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control reset-password" placeholder="Nueva contraseña" type="password" name="new_password" id="new_password" required="required" pattern=".{6,}" data-error="Introduce una contraseña de al menos 6 caracteres.">
                            <small><div class="help-block with-errors">Mínimo 6 caracteres de longitud</div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="new_password_confirmation">Confirmar nueva contraseña</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control" placeholder="Repite la contraseña" type="password" name="new_password_confirmation" id="new_password_confirmation" required="required" data-match=".reset-password" data-error="Rellena este campo." data-match-error="No coincide.">
                            <small><div class="help-block with-errors"></div></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-10">
                                <div class="col-xs-12">
                                    <span class="hidden-sm hidden-md hidden-lg left-buffer-15"></span><input type="submit" value="Cambiar contraseña" class="btn btn-primary"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#user-data").validator();
                        $("#user-passwd").validator();
                    });
                </script>

            </div>
        </div>
    </div>
</div>

{{--Modal to crop images--}}
<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Recortar mi imagen de perfil</h4>
            </div>
            <div class="modal-body container-fluid">
                <div id="canvasContainer" class="col-xs-12 text-center"></div>
                <div id="funcsContainer" class="col-xs-12">
                    <div id="previewTitle">Vista previa:</div>
                    <div id="previewContainer"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <form style="display: inline;" action="{{ action('UsersController@updateAvatar') }}" method="post" onsubmit="return checkCoords();">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    <input type="hidden" name="avatar" id="cropAvatar"/>
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <input type="submit" class="btn btn-milprofes" value="Guardar selección" />
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--Cropping related JS--}}
<script type="text/javascript">
    var xsize = 160,
        ysize = 160,
        imgSlc,
        boundx,
        boundy;

    function checkCoords() {
        if (parseInt($('#w').val())) return true;
        return false;
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
            $('#file-input-error').html('Puedes utilizar imágenes del tipo JPG, PNG o GIF y tamaño inferior a 1 MB.');
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
                cContainer.append('<img src="'+ src +'" class="imgCanvas" alt="Mi nueva imagen de perfil" />');
                pContainer.append('<img src="'+ src +'" class="jcrop-preview" alt="Vista previa" />');
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
            $('#file-input-error').html('La imagen elegida supera el tamaño máximo de 1 MB.');
        }
    }

    $("#avatar").change(function(){
        readURL(this);
    });
</script>

@stop