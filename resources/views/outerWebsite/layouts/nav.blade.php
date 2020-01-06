    <!-- Primary Navigation ============================== -->
    <nav class="primary-menu navbar navbar-expand-lg">
            <div id="header-nav" class="collapse navbar-collapse">
              <ul class="navbar-nav mr-auto">
                <li><a href="{{ url('/') }}">HOME</a></li>

                <li><a href="{{ url('/services') }}">SERVICES</a></li>

				        <li><a href="{{ url('/docs') }}">DOCS</a></li>
                

                <li><a href="{{ url('/contact') }}">CONTACT</a></li>

                <li><a href="{{ url('/about') }}">ABOUT US</a></li>

                <li class="dropdown"> 
                  <a class="dropdown-toggle" href="#">Download</a>
                  <ul class="dropdown-menu">
                  
                    <li>
                        <a class="dropdown-item" href="feature-layout-boxed.html">
                        <img class="img-fluid" alt="" 
                        src="{{ asset('/images/outerWebsite/google-play-store.png') }}">
                        <span class="w-100 text-5 font-weight-500 ml-2">
                        <i class="fas fa-download"></i>
                        </span>
                        </a>
                    </li>
                    
                    <li>
                        <a class="dropdown-item" href="feature-layout-boxed.html">
                        <img class="img-fluid" alt="" 
                        src="{{ asset('/images/outerWebsite/app-store.png') }}">
                        <span class="w-100 text-5 font-weight-500 ml-2">
                        <i class="fas fa-download"></i>
                        </span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="feature-layout-boxed.html">
                        <img class="img-fluid" alt="" 
                        src="{{asset('/images/outerWebsite/google-play-store.png') }}">
                        <span class="w-100 text-5 font-weight-500 ml-2">
                        <i class="fas fa-download"></i>
                        </span>
                        </a>
                    </li>

                  </ul>
                </li>


              </ul>
            </div>
          </nav>
          <!-- Primary Navigation end --> 
        </div>