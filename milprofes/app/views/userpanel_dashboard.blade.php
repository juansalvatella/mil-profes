@extends('layout')
@section('content')

<div class="container-fluid top-padding-25 bottom-padding-150 background-lamp">

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @elseif(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif

    <div class="profile-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">

                    <div class="profile-image"><img src="{{ asset('img/avatars/'.$user->avatar) }}" title="{{ $user->username }} logo" alt="{{ $user->username }}"></div>

                    <div class="profile-title">
                        <h3>Bienvenid&#64;, {{ $user->name }}</h3>
                        <div class="profile-subtitle">Panel de Control</div>
                    </div>

                    {{--<h4><img src="{{ asset('img/avatars/'.$user->avatar) }}" class="userpanel-img">&nbsp;&nbsp;Bienvenid&#64;, {{ $user->name }}</h4>--}}
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

    <div class="tab-content container profile-box top-padding-50 bottom-padding-50" role="tabpanel">

        <div role="tabpanel" class="tab-pane active" id="teacher_tab">

            {{ $content_teacher }}

        </div>
        <div role="tabpanel" class="tab-pane" id="profile_tab">

            <div class="container-fluid top-padding-25 bottom-padding-25">
                <form class="form-horizontal" action="{{ action('UsersController@updateUser') }}" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="avatar">Mi imagen</label>
                        <div class="col-xs-10">
                            <input type="file" name="avatar"/>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="control-label col-xs-2" for="name">Nombre</label>
                        <div class="col-xs-10">
                            <input class="form-control col-xs-10" placeholder="Tu nombre" type="text" name="name" id="name" value="{{{ $user->name }}}">
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="control-label col-xs-2" for="lastname">Apellidos</label>
                        <div class="col-xs-10">
                            <input class="form-control col-xs-10" placeholder="Tus apellidos" type="text" name="lastname" id="lastname" value="{{{ $user->lastname }}}">
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="address">Dirección</label>
                        <div class="col-xs-10">
                            <input class="form-control" placeholder="Mi calle, número, ciudad..." type="text" name="address" id="address" value="{{{ $user->address }}}">
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="email">{{{ @trans('messages.e_mail') }}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" placeholder="Tu e-mail" type="text" name="email" id="email" value="{{{ $user->email }}}">
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="phone">Teléfono</label>
                        <div class="col-xs-10">
                            <input class="form-control" placeholder="Tu teléfono de contacto" type="text" name="phone" id="phone" value="{{{ $user->phone }}}">
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="description">Mi descripción</label>
                        <div class="col-xs-10">
                            <textarea rows="3" placeholder="Descríbete..." class="form-control" name="description" id="description">{{ $user->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="old_password">Viejo password</label>
                        <div class="col-xs-10">
                            <input class="form-control" placeholder="Viejo password" type="password" name="old_password" id="old_password">
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="new_password">Nuevo password</label>
                        <div class="col-xs-10">
                        <input class="form-control" placeholder="Nuevo password" type="password" name="new_password" id="new_password">
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="col-xs-2 control-label" for="new_password_confirmation">Confirmar nuevo password</label>
                        <div class="col-xs-10">
                        <input class="form-control" placeholder="Confirmar nuevo password" type="password" name="new_password_confirmation" id="new_password_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-10">
                            <input type="submit" value="Actualizar datos" class="btn btn-primary"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>


@stop