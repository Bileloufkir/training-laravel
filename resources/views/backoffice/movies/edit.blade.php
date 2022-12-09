@extends('backoffice.layouts.master')

@section('title','Edit a movie | '.$movie->title. ' | '. $movie->year)

@section('sidebar')
    @parent
@endsection

@section('content')

@section('main_title','Edit a movie : '.$movie->title. ' ( '. $movie->year .' ) ')

@include('backoffice.movies.partials._form', [ 'movie' => $movie ])

<ul class="list-inline list-unstyled mt-5">
    <a href="{{ route('backoffice.movies.show', [ 'id' => $movie->id ]) }}" class="btn btn-outline-secondary btn-sm btn-sm">Show</a>
    <a href="{{ route('backoffice.movies.delete', [ 'id' => $movie->id ]) }}" class="btn btn-outline-secondary btn-sm btn-sm">Delete</a>
    <a href="{{ route('backoffice.movies.index') }}" class="btn btn-outline-secondary btn-sm btn-sm">Back to list</a>
</ul>

@endsection
