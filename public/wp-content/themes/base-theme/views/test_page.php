@extends('layouts.master')
<?php /* Template Name: Test Page Template */ ?>
@section('content')
<?php while ( have_posts() ) : the_post(); ?>
<main id="main">
    {{ date('l') }}
</main>
<?php endwhile; ?>
@endsection
