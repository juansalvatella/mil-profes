@extends('basic_template')
@section('content')

    <div class="page-header">
        <h1>Editar academia <small>{{ $school->name }}</small></h1>
    </div>

    <form class="form-horizontal" action="{{ action('AdminController@saveSchool') }}" method="post" enctype="multipart/form-data" role="form">
        <input type="hidden" name="id" value="{{ $school->id }}">
        <div class="form-group">
            <div class="col-sm-2 control-label">
                <img src="{{ asset('img/logos/'.$school->logo) }}" class="img-thumbnail" style="min-height: 50px;height: 50px;">
            </div>
            <div class="col-sm-10">&nbsp;</div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="logo">Cambiar logotipo</label>
            <div class="col-sm-10">
                <input type="file" name="logo"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" value="{{ $school->name }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">Dirección</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address" id="address" value="{{ $school->address }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="cif">CIF</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="cif" id="cif" value="{{ $school->cif }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">E-Mail</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" id="email" value="{{ $school->email }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="phone">Teléfono</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $school->phone }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="phone2">Teléfono (2)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="phone2" id="phone2" value="{{ $school->phone2 }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descripción</label>
            <div class="col-sm-10">
                <textarea rows="3" class="form-control" name="description" id="description">{{ $school->description }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Guardar cambios" class="btn btn-primary"/>
                <a href="{{ url('admin/schools') }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>
    </form>

@stop