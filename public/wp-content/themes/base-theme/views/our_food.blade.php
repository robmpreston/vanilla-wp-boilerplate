@extends('layouts.master')
<?php /* Template Name: Our Food */ ?>
@section('content')
<?php while ( have_posts() ) : the_post(); ?>
<main id="main">
    {{ date('l') }}
</main>
<?php endwhile; ?>
@endsection
