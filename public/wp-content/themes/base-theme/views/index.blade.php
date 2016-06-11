@extends('layouts.master')

@section('sidebar')
    @parent

    <p>Test</p>
@endsection

@section('content')
    <div class="container">
        <div class="content">
            {!! <p>This is html</p><h1>Test</h1> !!}
            {{ test }}
            <div class="title">It works</div>
        </div>
    </div>
@stop
