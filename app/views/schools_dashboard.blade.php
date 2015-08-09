@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')
    {{ HTML::style('//cdn.datatables.net/1.10.7/css/jquery.dataTables.css') }}
@endsection

@section('content')

    {{--token needed for ajax POST requests--}}
    <input id="token" type="hidden" name="_token" value="{{{ Session::getToken() }}}"/>

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <h1>Academias <small>Panel de control</small></h1>
                </div>
                <div class="pull-right">
                    <a href="{{ route('userpanel.dashboard') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('buttons.back')</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-bottom: 100px;">

    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('show.create.school') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('buttons.new_school')</a>
        </div>
    </div>

    @if (!isset($schools) || $schools->isEmpty())
        <p>There are no schools... yet?</p>
    @else
        <table id="table_schools" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th width="30" class="hidden-xs">Dir</th>
                    <th width="30" class="hidden-xs">CIF</th>
                    <th width="30" class="hidden-xs">EMail</th>
                    <th width="30" class="hidden-xs">Tlf</th>
                    <th width="30" class="hidden-xs">Tlf2</th>
                    <th width="30" class="hidden-xs">Logo</th>
                    <th width="30" class="hidden-xs">Desc</th>
                    <th width="30" class="hidden-xs">Geo</th>
                    <th>Cursos</th>
                    <th width="200">Acciones</th>
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
                    <td class="text-center hidden-xs">@if($school->lon && $school->lon != '0.0000000')<i class="glyphicon glyphicon-ok" aria-hidden="true" title="{{ $school->lat }},{{ $school->lon }}"></i>@else <i class="glyphicon glyphicon-remove" aria-hidden="true" title="Faltan datos"></i> @endif</td>
                    <td class="text-center">{{ $school->nlessons }}</td>
                    <td>
                        <a href="{{ route('profiles-school',$school->slug) }}" class="btn btn-xs btn-info"><i class="fa fa-link"></i>Ver<span class="hidden-xs"> perfil</span></a>
                        <a href="{{ route('school.lessons',$school->id) }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar </span>cursos</a>
                        <a href="{{ route('show.delete.school',$school->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> <span class="hidden-xs">Eliminar</span></a>
                        <a href="{{ route('show.edit.school',$school->id) }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> <span class="hidden-xs">Editar </span>academia</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    </div>

@endsection

@section('page_js')
    {{ HTML::script('//cdn.datatables.net/1.10.7/js/jquery.dataTables.js') }}
    <script type="text/javascript">
        $(document).ready(function () {
            SchoolsDashboard.init();
        });
    </script>
@endsection
