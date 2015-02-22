@extends('layout')
@section('content')

{{ $school->logo }} <br>
{{ $school->name }} <br>
{{ $school->description }} <br>
{{ $school->email }} <br>
{{ $school->address }} <br>
{{ $school->phone }} <br>
{{ $school->getSchoolAvgRating() }}

@foreach($lessons as $lesson)
    <br><br>
    {{ $lesson->description }} <br>
    {{ $lesson->subject->name }} <br>
    {{ $lesson->getLessonAvgRating() }} <br>
    {{ $lesson->price }} <br>
@endforeach

@endsection