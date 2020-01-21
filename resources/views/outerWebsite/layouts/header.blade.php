  <!-- Header ============================================= -->
  <header id="header" class="bg-transparent header-text-light" 
  style="
  /* position:fixed;
  background-image:url('{{ asset('/images/outerWebsite/bg/image-3.jpg') }}'); */
  ">
    <div class="container">
      <div class="header-row">
        <div class="header-column justify-content-start"> 
          <!-- Logo ============================= -->
          <div class="logo text-10"> 
            <a class="d-flex" 
              href="{{ url('/') }}" 
              title="@appName">

              <img src="{{ asset('/images/logo.png') }}" 
                alt="@appName" 
                height="70" width="70">
            </a>

            <a href="{{ url('/') }}"  class=" text-white">
              Yoi<span class="" style="color:rgb(0,174,238)">y</span><span class="" style="color:rgb(0,157,78);">p</span>psp
              </a>
          </div>
          <!-- Logo end --> 
          <!-- Collapse Button ============================== -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav"> <span></span> <span></span> <span></span> </button>
          <!-- Collapse Button end --> 
          

      @include('outerWebsite.layouts.nav')


        <div class="header-column justify-content-end"> 
          <!-- Login & Signup Link ============================== -->
          <nav class="login-signup navbar navbar-expand">
            <ul class="navbar-nav">
            @if (Route::has('login'))

              @auth
                <li class="m-1">
                  <a href="http://account.yoippsp.com" class="btn btn-outline-light">
                  <span class="text-2 mr-3"><i class="fas fa-tachometer-alt"></i></span>
                    Back to DashBoard
                  </a> 
                </li>
              @else
                <li><a href="{{ url('http://account.yoippsp.com/login') }}" class="btn btn-outline-light">Login</a> </li>
                @if (Route::has('register'))
                <li class="align-items-center h-auto ml-sm-3">
                  <a class="btn btn-primary d-none d-sm-block text-white" 
                  data-toggle="modal" data-target="#registrationModal"
                  >
                  Sign Up
                  </a>
                </li>

                
                @endif
              @endauth
            @endif
            </ul>
          </nav>
          <!-- Login & Signup Link end --> 
        </div>
      </div>
    </div>
  </header>
  <!-- Header End --> 
