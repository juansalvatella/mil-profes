@extends('layout')
@section('content')

    <div class="page-header">
        <h1>Nueva academia</h1>
    </div>

    <form class="form-horizontal" action="{{ action('AdminController@createSchool') }}" method="post" enctype="multipart/form-data" role="form">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="logo">Logotipo</label>
            <div class="col-sm-10">
                <input type="file" name="logo"/>
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

@stop