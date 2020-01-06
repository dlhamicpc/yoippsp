<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">
<title>
@appName 
@yield('title', 'Yoippsp')
</title>
<link href="{{asset('/images/logo.png')}}" rel="icon">
<meta name="description" content="Ethiopian Money Transfer and online payments website.">
<meta name="author" content="dlham.com">

{{--@include('outerWebsite.layouts.fonts')--}}

@include('outerWebsite.layouts.css')
@yield('css')

</head>
<body>

<!-- Preloader -->
<div id="preloader">
  <div data-loader="dual-ring"></div>
</div>
<!-- Preloader End --> 

<!-- Document Wrapper============================================= -->
<div id="main-wrapper"> 
  @include('outerWebsite.layouts.header')
<!-- Content============================================= -->
  <div id="content">

    @yield('content')

  </div>
  <!-- Content end -->
  @include('outerWebsite.layouts.footer')
  @include('partials.choose-signup')

</div>
<!-- Document Wrapper end -->
<!-- Back to Top============================================= --> 
<a id="back-to-top" data-toggle="tooltip" title="Back to Top" href="javascript:void(0)"><i class="fa fa-chevron-up"></i></a>

@include('outerWebsite.layouts.js')
@yield('js')

</body>
</html>

