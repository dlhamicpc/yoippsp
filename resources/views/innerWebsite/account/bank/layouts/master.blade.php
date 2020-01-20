<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Yoip')</title>

  @include('innerWebsite.account.bank.assets.css')
  @yield('css')

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" id="body">

<div id="preloader" style="display: none;">
  <div data-loader="dual-ring"></div>
</div>

<div class="wrapper" id="app">

    @include('innerWebsite.account.bank.partials.navbar')

    @include('innerWebsite.account.bank.partials.left_sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content============================================= -->
        <div id="content" class="py-4">
            <div class="container">

                <ring-loader :loading="loading" :size="'100px'"></ring-loader>
                <router-view></router-view>

                <div id="not_single_page">
                  @yield('content')
                </div>
                
                
            </div>
        </div>
        <!-- Content end -->
    </div>
    <!-- /.content-wrapper -->

    @include('innerWebsite.account.bank.partials.footer')



</div>
<!-- ./wrapper -->
@auth
  <script type="text/javascript">

    
    window.user = @json(auth()->user());

    window.userDetails = @json($bankUser);

    window.settings = JSON.parse(window.userDetails.settings);

    window.transactions = @json($transactions);

  </script>
@endauth

@include('innerWebsite.account.bank.assets.js')
@yield('js')



</body>
</html>
