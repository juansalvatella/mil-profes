@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')
    {{ HTML::style('css/jquery.Jcrop.min.css') }}
@endsection

@section('content')

    <div class="container-fluid top-padding-25 bottom-padding-150 background-lamp">

    <div class="profile-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <div class="profile-image">
                        <img class="thumbnail" height="100" width="100" src="{{ asset('img/avatars/'.$user->avatar) }}" title="{{ $user->username }} logo" alt="{{ $user->username }}">
                    </div>
                    <div class="profile-title">
                        <div><h1 class="profile-maintitle">Mi panel de control</h1></div>
                        <div><h2 class="profile-subtitle">@if($user->hasRole('teacher'))Profe.@endif {{ $user->name }}</h2></div>
                    </div>
                </div>
                <div class="pull-right">
                    <a href="{{ url('profe/'.$user->slug) }}" class="btn btn-default"><i class="fa fa-user-plus"></i> Ver mi perfil</a>
                </div>
                @if($user->hasRole("admin"))
                    <div class="pull-right" style="width:150px;text-align:center;">
                        <a href="{{ url('admin/school/reviews') }}" class="btn btn-primary btn-xs inline-block">Valoración academias</a>
                        <a href="{{ url('admin/teacher/reviews') }}" class="btn btn-primary btn-xs inline-block top-buffer-4">Valoración profes.</a>
                        <a href="{{ url('admin/schools') }}" class="btn btn-warning btn-xs inline-block top-buffer-4">Administrar academias</a>
                        <a href="{{ url('admin/teachers') }}" class="btn btn-warning btn-xs inline-block top-buffer-4">Administrar profesores</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
<div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-tabs-profile magic-align-2 container" role="tablist">
        <li role="presentation" class="active"><a href="#teacher_tab" aria-controls="teacher_tab" role="tab" data-toggle="tab">Mis clases</a></li>
        <li role="presentation"><a href="#profile_tab" aria-controls="profile_tab" role="tab" data-toggle="tab">Mis datos</a></li>
    </ul>
    <div class="tab-content container user-box top-padding-50 bottom-padding-50" role="tabpanel">
        <div role="tabpanel" class="tab-pane active" id="teacher_tab">
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

                <form class="form-horizontal" action="{{ action('UsersController@updateUser') }}" method="post" role="form" id="user-data">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 bottom-buffer-35">
                        <span class="school-rating-span">Mis datos personales</span>
                    </div>

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
                            <label for="gender">Sexo</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <select class="form-control" id="gender" name="gender">
                                <option value="" @if(!$user->gender || ($user->gender!='male' && $user->gender!='female' && $user->gender!='other')) selected="selected" @endif >&nbsp;</option>
                                <option value="male" @if($user->gender=='male') selected @endif >Hombre</option>
                                <option value="female" @if($user->gender=='female') selected @endif >Mujer</option>
                                <option value="other" @if($user->gender=='other') selected @endif >Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="date_of_birth">Fecha de nacimiento</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label for="day"><small>Día</small></label>
                                    <select autocomplete="off" class="form-control" id="day" name="day">
                                        <?php
                                            $defaultDay = ($user->date_of_birth) ? date("d",strtotime($user->date_of_birth)) : 1;
                                        ?>
                                        @for($i=1;$i<32;++$i)
                                            <option @if($i==$defaultDay) selected="selected" @endif value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label for="month"><small>Mes</small></label>
                                    <?php
                                        $defaultMonth = ($user->date_of_birth) ? date("m",strtotime($user->date_of_birth)) : 1;
                                    ?>
                                    <select autocomplete="off" class="form-control" id="month" name="month">
                                        <option value="1" @if($defaultMonth==1) selected="selected" @endif >Enero</option>
                                        <option value="2" @if($defaultMonth==2) selected="selected" @endif >Febrero</option>
                                        <option value="3" @if($defaultMonth==3) selected="selected" @endif >Marzo</option>
                                        <option value="4" @if($defaultMonth==4) selected="selected" @endif >Abril</option>
                                        <option value="5" @if($defaultMonth==5) selected="selected" @endif >Mayo</option>
                                        <option value="6" @if($defaultMonth==6) selected="selected" @endif >Junio</option>
                                        <option value="7" @if($defaultMonth==7) selected="selected" @endif >Julio</option>
                                        <option value="8" @if($defaultMonth==8) selected="selected" @endif >Agosto</option>
                                        <option value="9" @if($defaultMonth==9) selected="selected" @endif >Septiembre</option>
                                        <option value="10" @if($defaultMonth==10) selected="selected" @endif >Octubre</option>
                                        <option value="11" @if($defaultMonth==11) selected="selected" @endif >Noviembre</option>
                                        <option value="12" @if($defaultMonth==12) selected="selected" @endif >Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label for="year"><small>A&ntilde;o</small></label>
                                    {{--Form SELECT year of birth--}}
                                    <?php
                                        $currentYear = date("Y");
                                        $aCenturyAgo = date("Y", strtotime($currentYear)-(60*60*24*365.242*110));
                                        $defaultYear = ($user->date_of_birth) ? date("Y", strtotime($user->date_of_birth)) : $currentYear;
                                    ?>
                                    {{ Form::selectYear('year', $currentYear, $aCenturyAgo, $defaultYear,['autocomplete'=>'off','class'=>'form-control']) }}
                                </div>
                            </div>
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
                            <label class="" for="email">{{{ trans('messages.e_mail') }}} (*)</label>
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
                            <input class="form-control" placeholder="Tu teléfono de contacto" type="text" name="phone" id="phone" value="{{{ $user->phone }}}" pattern="^([0-9]){5,}$" maxlength="20" data-error="Introduce sólo números, sin espacios.">
                            <small><div class="help-block with-errors">Sólo números, sin espacios</div></small>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label class="" for="description">Mi descripción</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <textarea rows="3" placeholder="Descríbete..." class="form-control" name="description" id="description" maxlength="450">{{ $user->description }}</textarea>
                            <small><div class="help-block with-errors"></div></small>
                            <div id="chars_feedback"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-10">
                                <div class="col-xs-12">
                                    <span class="hidden-sm hidden-md hidden-lg left-buffer-15"></span><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <br/>

                <form class="form-horizontal" action="{{ action('UsersController@updateSocial') }}" method="post" role="form" id="user-social">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 bottom-buffer-35">
                        <span class="school-rating-span">Web y redes sociales</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="facebook">Facebook</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tu página de Facebook" type="url" name="facebook" id="facebook" value="{{{ $user->link_facebook }}}" data-error="Introduce una dirección web válida. Ejemplo: http://facebook.com/milprofes">
                            <div class="help-block with-errors"><small>Introduce la dirección web de tu perfil de Facebook. Ejemplo: http://facebook.com/milprofes</small></div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="twitter">Twitter</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tu página de Twitter" type="url" name="twitter" id="twitter" value="{{{ $user->link_twitter }}}" data-error="Introduce una dirección web válida. Ejemplo: http://twitter.com/milprofes">
                            <div class="help-block with-errors"><small>Introduce la dirección web de tu perfil de Twitter. Ejemplo: http://twitter.com/milprofes</small></div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="googleplus">Google+</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tu página de Google+" type="url" name="googleplus" id="googleplus" value="{{{ $user->link_googleplus }}}" data-error="Introduce una dirección web válida. Ejemplo: http://plus.google.com/+MilProfes">
                            <div class="help-block with-errors"><small>Introduce la dirección web de tu perfil de Google+. Ejemplo: http://plus.google.com/+MilProfes/</small></div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="instagram">Instagram</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tu página de Instagram" type="url" name="instagram" id="instagram" value="{{{ $user->link_instagram }}}" data-error="Introduce una dirección web válida. Ejemplo: http://instagram.com/milprofes">
                            <small><div class="help-block with-errors">Introduce la dirección web de tu perfil de Instragram. Ejemplo: http://instagram.com/milprofes</div></small>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="linkedin">LinkedIn</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tu página de LinkedIn" type="url" name="linkedin" id="linkedin" value="{{{ $user->link_linkedin }}}" data-error="Introduce una dirección web válida. Ejemplo: http://es.linkedin.com/in/milprofes">
                            <small><div class="help-block with-errors">Introduce la dirección web de tu perfil de LinkedIn. Ejemplo: http://es.linkedin.com/in/milprofes</div></small>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group">
                        <div class="col-xs-12 col-sm-2 control-label">
                            <label for="web">Mi página web</label>
                        </div>
                        <div class="col-xs-12 col-offset-sm-2 col-sm-10">
                            <input class="form-control col-xs-10" placeholder="Tu página web personal" type="url" name="web" id="web" value="{{{ $user->link_web }}}" data-error="Introduce una dirección web válida. Ejemplo: http://www.milprofes.com">
                            <small><div class="help-block with-errors">Introduce la dirección web de tu página web personal. Ejemplo: http://www.milprofes.com</div></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-10">
                                <div class="col-xs-12">
                                    <span class="hidden-sm hidden-md hidden-lg left-buffer-15"></span><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <form class="form-horizontal" action="{{ action('UsersController@updateUserPasswd') }}" method="post" role="form" id="user-passwd">

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

@endsection

@section('page_js')
    {{ HTML::script('js/jquery.Jcrop.min.js') }}
    <script type="text/javascript">
        $(document).ready(function(){
            var text_max = 450;
            var tbox = $('#description');
            var text_length = tbox.val().length;
            var text_remaining = text_max - text_length;
            $('#chars_feedback').html('(' + text_remaining + ' caracteres disponibles)');
            tbox.keyup(function() {
                var text_length = $('#description').val().length;
                var text_remaining = text_max - text_length;
                $('#chars_feedback').html('(' + text_remaining + ' caracteres disponibles)');
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#user-data").validator();
            $("#user-social").validator();
            $("#user-passwd").validator();
        });
    </script>
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
    <script type="text/javascript">
        $(document).ready(function(){
            @for($i=1;$i<9;++$i)
                $(document).on("click","#avail-control-add{{$i}}",function(e){
                        e.preventDefault();
                        $("#avail"+"{{$i+1}}").removeClass("hidden");
                        $("#avail-controls"+"{{$i+1}}").removeClass("hidden");
                        $("#avail-controls"+"{{$i}}").addClass("hidden");
                    });

            $(document).on("click","#avail-control-del"+"{{$i+1}}",function(e){
                e.preventDefault();
                $("#avail"+"{{$i+1}}").addClass("hidden");
                $("[name=day"+"{{$i+1}}]").val("");
                $("#avail-controls"+"{{$i}}").removeClass("hidden");
                $("#avail-controls"+"{{$i+1}}").addClass("hidden");
            });
            @endfor
        });
    </script>

@endsection
