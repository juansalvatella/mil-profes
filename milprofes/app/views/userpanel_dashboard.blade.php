@extends('layout')
@section('content')

<div class="container-fluid top-padding-25 bottom-padding-150 background-lamp">

    <div class="profile-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">

                    <div class="profile-image"><img src="{{ asset('img/avatars/'.$user->avatar) }}" title="{{ $user->username }} logo" alt="{{ $user->username }}"></div>

                    <div class="profile-title">
                        <h3>Bienvenid&#64;, {{ $user->name }}</h3>
                        <div class="profile-subtitle">Panel de Control</div>
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
                <form class="form-horizontal" action="{{ action('UsersController@updateUser') }}" method="post" enctype="multipart/form-data" role="form" id="user-data">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">


                    <div class="col-xs-12 bottom-buffer-35"><span class="school-rating-span">Mis datos personales</span></div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="avatar">Mi imagen</label>
                        <div class="col-xs-10">
                            <input type="file" name="avatar"/>
                            <div class="help-block with-errors">Sube una foto de como máximo 200 Kb</div>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="control-label col-xs-2" for="name">Nombre (*)</label>
                        <div class="col-xs-10">
                            <input class="form-control col-xs-10" placeholder="Tu nombre" type="text" name="name" id="name" value="{{{ $user->name }}}" maxlength="50" required="required">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="control-label col-xs-2" for="lastname">Apellidos</label>
                        <div class="col-xs-10">
                            <input class="form-control col-xs-10" placeholder="Tus apellidos" type="text" name="lastname" id="lastname" value="{{{ $user->lastname }}}" maxlength="100">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="address">Dirección (*)</label>
                        <div class="col-xs-10">
                            <input class="form-control" placeholder="Mi calle, número, ciudad..." type="text" name="address" id="address" value="{{{ $user->address }}}" maxlength="200" required="required">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="email">{{{ @trans('messages.e_mail') }}} (*)</label>
                        <div class="col-xs-10">
                            <input class="form-control" placeholder="Tu e-mail" type="email" name="email" id="email" value="{{{ $user->email }}}" required="required">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="phone">Teléfono</label>
                        <div class="col-xs-10">
                            <input class="form-control" placeholder="Tu teléfono de contacto" type="text" name="phone" id="phone" value="{{{ $user->phone }}}" pattern="^([0-9]){5,}$" maxlength="20">
                            <div class="help-block with-errors">Sólo números, sin espacios</div>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="description">Mi descripción</label>
                        <div class="col-xs-10">
                            <textarea rows="3" placeholder="Descríbete..." class="form-control" name="description" id="description"  maxlength="450">{{ $user->description }}</textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-10">
                            <input type="submit" value="Actualizar datos" class="btn btn-primary"/>
                        </div>
                    </div>

                </form>


                <form class="form-horizontal" action="{{ action('UsersController@updateUserPasswd') }}" method="post" enctype="multipart/form-data" role="form" id="user-passwd">

                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 top-buffer-35 bottom-buffer-35"><span class="school-rating-span">Cambiar contraseña</span></div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="old_password">Contraseña actual</label>
                        <div class="col-xs-10">

                            <input class="form-control" placeholder="Contraseña actual" type="password" name="old_password" id="old_password" required="required" pattern=".{6,}">
                            <div class="help-block with-errors"></div>

                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="new_password">Nueva contraseña</label>
                        <div class="col-xs-10">

                                <input class="form-control reset-password" placeholder="Nueva contraseña" type="password" name="new_password" id="new_password" required="required" pattern=".{6,}">
                                <div class="help-block with-errors">Mínimo 6 caracteres de longitud</div>

                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="new_password_confirmation">Confirmar nueva contraseña</label>
                        <div class="col-xs-10">

                                <input class="form-control" placeholder="Repite la contraseña" type="password" name="new_password_confirmation" id="new_password_confirmation" required="required" data-match=".reset-password">
                                <div class="help-block with-errors"></div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-10">
                            <input type="submit" value="Cambiar contraseña" class="btn btn-primary"/>
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


@stop