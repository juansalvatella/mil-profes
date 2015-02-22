@extends('layout')
@section('content')

{{ $teacher->avatar }} <br>
{{ $teacher->username }} <br>
{{ $teacher->description }} <br>
{{ $teacher->email }} <br>
{{ $teacher->address }} <br>
{{ $teacher->phone }} <br>
{{ $teacher->getTeacherAvgRating() }}

@foreach($lessons as $lesson)
    <br><br>
    {{ $lesson->description }} <br>
    {{ $lesson->subject->name }} <br>
    {{ $lesson->getLessonAvgRating() }} <br>
    {{ $lesson->price }} <br>
@endforeach

@endsection