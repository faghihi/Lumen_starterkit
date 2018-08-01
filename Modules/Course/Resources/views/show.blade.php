@extends('course::layouts.master')

@section('content')

    <ul>
        <li>{{$course->name}}</li>
        <li>{{$course->description}}</li>
        <li>{{$course->image}}</li>
    </ul>

@stop
