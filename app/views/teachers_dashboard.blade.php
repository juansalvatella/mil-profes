@extends('layout')
@section('content')

{{--token needed for ajax POST requests--}}
<input id="token" type="hidden" name="_token" value="{{{ Session::getToken() }}}"/>

<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="pull-left">
                <h1>Profes. <small>Panel de control</small></h1>
            </div>
            <div class="pull-right">
                <a href="{{ url('userpanel/dashboard') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('buttons.back')</a>
            </div>
        </div>
    </div>
</div>

<div class="container">

    @if ($users->isEmpty())
    <p>There are no teachers... yet?</p>
    @else
    {{ $users->links() }}
    <table class="table table-striped">
        <thead>
        <tr>
            <th width="80">Imagen</th>
            <th>Nombre</th>
            <th>E-mail</th>
            <th>Created at</th>
            <th width="80">Perfil</th>
            <th width="80">Eliminar</th>
        </tr>
        </thead>
        <tbody id="teachers">
        @foreach($users as $user)
        <tr>
            <input type="hidden" class="user-id" value="{{ $user->id }}" />
            <td>
                <img src="{{ asset('img/avatars/'.$user->avatar) }}" height="40" width="40"/>
            </td>
            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
                {{ $user->created_at }}
            </td>
            <td>
            <?php $eloqUser = User::findOrFail($user->id); ?>
                @if($eloqUser->hasRole("teacher"))
                <a href="{{ url('profe',array($user->slug)) }}" class="btn btn-sm btn-info"><i class="fa fa-link"></i>Ver<span class="hidden-xs"> perfil</span></a>
            @endif
            </td>
            <td>
                <a href="{{ url('admin/delete/teacher',array($user->id)) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> <span class="hidden-xs">Eliminar</span></a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="panel panel-default">
        <div class="panel-body">
            Mostrando {{ $users->getFrom() }}-{{ $users->getTo() }} de un total de {{ $users->getTotal() }} profes.
        </div>
    </div>
    {{ $users->links() }}
    @endif

</div>

@endsection
