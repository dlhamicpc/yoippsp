@extends('outerWebsite.layouts.master')
@section('title', '- Help')

@section('content')

@include('outerWebsite.pages.help.partials.header')
@include('outerWebsite.pages.help.partials.main-topic')
@include('outerWebsite.pages.help.partials.popular-topic')
@include('outerWebsite.pages.help.partials.cannot-find')


@endsection