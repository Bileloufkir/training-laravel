@extends('backoffice.layouts.master')

@section('title','Add a movie')

@section('sidebar')
    @parent
@endsection

@section('content')

@section('main_title','Add a movie')

@include('backoffice.movies.partials._form')

<ul class="list-inline list-unstyled mt-5">
    <a href="{{ route('backoffice.movies.index') }}" class="btn btn-outline-secondary btn-sm btn-sm">Back to list</a>
</ul>

@endsection
