@extends('outerWebsite.layouts.master')
@section('title', '- About')

@section('content')

@include('outerWebsite.pages.about.partials.header')
@include('outerWebsite.pages.about.partials.who-we-are')
@include('outerWebsite.pages.about.partials.our-values')
@include('outerWebsite.pages.about.partials.leadership')
@include('outerWebsite.pages.about.partials.investors')
@include('outerWebsite.partials.testimonial')
@include('outerWebsite.partials.video-modal')

@endsection