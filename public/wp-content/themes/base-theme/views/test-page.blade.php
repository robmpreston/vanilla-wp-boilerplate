@extends('layouts.master')
<?php /* Template Name: Test Page Template */ ?>
@section('content')
    @wpposts
        <h1>{{ the_title() }}</h1>
        <p>{{ the_content() }}</p>
    @wpempty
        <h1>No posts found</h1>
    @wpend
@endsection
