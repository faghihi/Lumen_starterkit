@extends('course::layouts.master')

@section('content')
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('course.name') !!}
    </p>

    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
        </tr>
        @foreach($courses as $course)
            <tr>
                <td>{{$course->name}}</td>
                <td>{{$course->description}}</td>
                <td>{{$course->image}}</td>
            </tr>
        @endforeach
    </table>

@stop
