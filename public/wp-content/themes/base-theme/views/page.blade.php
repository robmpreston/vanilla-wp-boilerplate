@extends('layouts.master')

@section('content')
    @wpposts
        <main id="main" class="content-article content-terms">
            <div class="container">
                <h1 class="content-title">{{ the_title() }}</h1>
                <div class="content-body">
                    {{ the_content() }}
                </div>
            </div>
        </main>
    @wpempty
    @wpend
@endsection
