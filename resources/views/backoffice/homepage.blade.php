@extends('backoffice.layouts.master')

@section('title','Dashboard')

@section('sidebar')
    @parent
@endsection

@section('content')

@section('main_title','Dashboard')

<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">MyImdb Dashboard</h1>
            <p class="lead text-muted">Myimdb is the best movie database in the World!</p>
        </div>
    </div>
</section>

@endsection
