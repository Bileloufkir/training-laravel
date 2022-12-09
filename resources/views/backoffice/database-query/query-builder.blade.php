@extends('backoffice.layouts.master')

@section('title','Database QueryBuilder')

@section('sidebar')
    @parent
@endsection

@section('content')

@section('main_title','Database QueryBbuilder')

<div class="row">
    <div class="col-3">
        <ul class="nav flex-column">
            @foreach($menu as $item)
                <li class="nav-item">
                    <h6>{{ $item['title'] }}</h6>
                    <ul class="nav flex-column ms-2">
                        @if (isset($item['items']))
                            @foreach($item['items'] as $sub_item)
                                <li class="nav-item lh-sm">
                                    <a class="nav-link pt-0 pb-2" aria-current="page"
                                       href="{!! $sub_item['link'] !!}">
                                        {{ $sub_item['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-9">

        <h3>{{ $title }}</h3>
        @if (!empty($sql))
            <p><strong>Sql</strong> :  {{ $sql  }}</p>
        @endif
        @if (!empty($method))
            <strong>Method : {{ $method }}</strong>
        @endif


        @if ( !empty($data) )
            <br><strong>Result</strong>
            <pre>
            {!!$data !!}
        </pre>
        @endif

    </div>
</div>
@endsection