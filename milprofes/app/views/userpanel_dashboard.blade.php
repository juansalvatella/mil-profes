@extends('layout')
@section('content')

<div class="container bottom-buffer-35">

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h4><img src="{{ asset('img/avatars/'.$user->avatar) }}" class="img-thumbnail" style="min-height: 50px;height: 50px;min-width: 50px;width: 50px;">&nbsp;&nbsp;Bienvenid&#64;, {{ $user->name }}</h4>
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

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @elseif(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif

    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#teacher_tab" aria-controls="teacher_tab" role="tab" data-toggle="tab">Mis clases</a></li>
            <li role="presentation"><a href="#profile_tab" aria-controls="profile_tab" role="tab" data-toggle="tab">Mi Perfil</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="teacher_tab">
                {{ $content_teacher }}
            </div>
            <div role="tabpanel" class="tab-pane" id="profile_tab">
                <div class="container-fluid top-buffer-25">
                    <form class="form-horizontal" action="{{ action('UsersController@updateUser') }}" method="post" enctype="multipart/form-data" role="form">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="avatar">Mi imagen</label>
                            <div class="col-sm-10">
                                <input type="file" name="avatar"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">Nombre</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Tu nombre" type="text" name="name" id="name" value="{{{ $user->name }}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="lastname">Apellidos</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Tus apellidos" type="text" name="lastname" id="lastname" value="{{{ $user->lastname }}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="address">Dirección</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Mi calle, número, ciudad..." type="text" name="address" id="address" value="{{{ $user->address }}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Tu e-mail" type="text" name="email" id="email" value="{{{ $user->email }}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="phone">Teléfono</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Tu teléfono de contacto" type="text" name="phone" id="phone" value="{{{ $user->phone }}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="description">Descríbete</label>
                            <div class="col-sm-10">
                                <textarea rows="3" class="form-control" name="description" id="description">{{ $user->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="old_password">Viejo password</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Viejo password" type="password" name="old_password" id="old_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="new_password">Nuevo password</label>
                            <div class="col-sm-10">
                            <input class="form-control" placeholder="Nuevo password" type="password" name="new_password" id="new_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="new_password_confirmation">Confirmar nuevo password</label>
                            <div class="col-sm-10">
                            <input class="form-control" placeholder="Confirmar nuevo password" type="password" name="new_password_confirmation" id="new_password_confirmation">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Actualizar datos" class="btn btn-primary"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>

@stop