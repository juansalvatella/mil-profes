@extends('basic_template')
@section('content')

    {{ Confide::makeLoginForm()->render(); }}

@stop