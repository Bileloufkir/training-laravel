@extends('backoffice.layouts.master')

@section('title','List of movies')

@section('sidebar')
        @parent
@endsection

@section('content')

@section('main_title','List of movies')

@include('backoffice.movies.partials._search_form')

<table class="table table-striped table-sm">
        <thead>
        <tr>
                <th>{!! sortByColumn('id','Id', $input) !!}</th>
                <th>{!! sortByColumn('title','Title', $input) !!}</th>
                <th>{!! sortByColumn('year','Year', $input) !!}</th>
                <th>{!! sortByColumn('running_time','Running Time', $input) !!}</th>
                <th>{!! sortByColumn('rating','Rating', $input) !!}</th>
                <th>{!! sortByColumn('created_at','Created At', $input) !!}</th>
                <th>{!! sortByColumn('updated_at','Updated At', $input) !!}</th>
                <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $movies as $movie)
                <tr>
                        <td>{{ $movie->id }}</td>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->year }}</td>
                        <td>{{ $movie->running_time }}</td>
                        <td>{{ $movie->rating }}</td>
                        <td>{{ $movie->created_at }}</td>
                        <td>{{ $movie->updated_at }}</td>
                        <td>
                                <ul class="list-inline list-unstyled">
                                        <li class="list-inline-item"><a href="{{ route('backoffice.movies.show', ['id' => $movie->id]) }}">Show</a></li>
                                        <li class="list-inline-item"><a href="{{ route('backoffice.movies.edit', ['id' => $movie->id]) }}">Edit</a></li>
                                        <li class="list-inline-item"><a href="{{ route('backoffice.movies.delete', ['id' => $movie->id]) }}">Delete</a></li>
                                </ul>
                        </td>
                </tr>
        @endforeach
        </tbody>
</table>

<div class="row justify-content-start mb-2">
        <div class="col-4">
                @if ( $movies->total() )
                        Showing {{ $movies->firstItem() }} to {{ $movies->lastItem() }} of {{ $movies->total() }} entries
                @else
                        No entry
                @endif
        </div>
        <div class="col-4">
                {{ $movies->links() }}
        </div>
</div>

<ul class="list-inline list-unstyled">
        <a href="{{ route('backoffice.movies.create') }}" class="btn btn-outline-secondary btn-sm">Add</a>
</ul>

@endsection
