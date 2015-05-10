@extends('layout')
@section('content')

    {{--token needed for post ajax requests--}}
    <input id="token" type="hidden" name="_token" value="{{{ Session::getToken() }}}"/>

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h1>Academias <small>Panel de control</small></h1>
                </div>
                <div class="pull-right">
                    <a href="{{ url('userpanel/dashboard') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('buttons.back')</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('failure'))
        <div class="alert alert-warning" role="alert">{{ Session::get('failure') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-warning" role="alert">{{ Session::get('error') }}</div>
    @endif

    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ url('/admin/create/school') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('buttons.new_school')</a>
        </div>
    </div>

    @if ($schools->isEmpty())
        <p>There are no schools... yet?</p>
    @else
        {{ $schools->links() }}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th class="hidden-xs">Dir</th>
                    <th class="hidden-xs">CIF</th>
                    <th class="hidden-xs">EMail</th>
                    <th class="hidden-xs">Tlf</th>
                    <th class="hidden-xs">Tlf2</th>
                    <th class="hidden-xs">Logo</th>
                    <th class="hidden-xs">Desc</th>
                    <th class="hidden-xs">Geo</th>
                    <th>Cursos</th>
                    <th>Perfil</th>
                    <th>Editar</th>
                    <th></th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody id="schools">
                @foreach($schools as $school)
                <tr>
                    <input type="hidden" class="school-id" value="{{ $school->id }}" />
                    <td>{{ $school->name }}</td>
                    <td class="status">
                        @if($school->status == 'Crawled')
                            <a class="hidden btn btn-sm btn-success status-active" href="#">
                                @lang('adminpanel.active')
                            </a>
                            <a class="btn btn-sm btn-warning status-crawled" href="#">
                                @lang('adminpanel.crawled')
                            </a>
                        @else
                            <a class="btn btn-sm btn-success status-active" href="#">
                                @lang('adminpanel.active')
                            </a>
                            <a class="hidden btn btn-sm btn-warning status-crawled" href="#">
                                @lang('adminpanel.crawled')
                            </a>
                        @endif
                    </td>
                    <td class="text-center hidden-xs">@if($school->address)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->address }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center hidden-xs">@if($school->cif)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->cif }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center hidden-xs">@if($school->email)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->email }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center hidden-xs">@if($school->phone)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->phone }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center hidden-xs">@if($school->phone2)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->phone2 }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center hidden-xs">@if($school->logo)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->logo }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center hidden-xs">@if($school->description)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->description }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center hidden-xs">@if($school->lon)<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->lat }},{{ $school->lon }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">{{ $school->nlessons }}</td>
                    <td>
                        <a href="{{ url('academia',array($school->slug)) }}" class="btn btn-sm btn-info"><i class="fa fa-link"></i>Ver<span class="hidden-xs"> perfil</span></a>
                    </td>
                    <td>
                        <a href="{{ url('admin/lessons',array($school->id)) }}" class="btn btn-sm btn-default"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar </span>cursos</a>
                    </td>
                    <td>
                        <a href="{{ url('admin/edit/school',array($school->id)) }}" class="btn btn-sm btn-default"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar </span>academia</a>
                    </td>
                    <td>
                        <a href="{{ url('admin/delete/school',array($school->id)) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> <span class="hidden-xs">Eliminar</span></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel panel-default">
            <div class="panel-body">
                Mostrando {{ $schools->getFrom() }}-{{ $schools->getTo() }} de un total de {{ $schools->getTotal() }} academias.
            </div>
        </div>
        {{ $schools->links() }}
    @endif

    </div>

@stop