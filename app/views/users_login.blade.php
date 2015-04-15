@extends('layout')
@section('content')

    {{ Confide::makeLoginForm()->render(); }}

@stop