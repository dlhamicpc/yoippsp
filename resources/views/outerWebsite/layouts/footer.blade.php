  <!-- Footer============================================= -->
  <footer id="footer" class="pb-4">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md mb-3 mb-md-0">
        <h4 class="text-3 text-muted text-uppercase font-weight-400 mb-3">Information</h4>
          <ul class="nav flex-column">

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/about') }}">About Us</a>
            </li>

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/partners') }}">Partners</a>
            </li>

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/fees') }}">Fees</a>
            </li>

          </ul>
        </div>
        <div class="col-sm-6 col-md mb-3 mb-md-0">
        <h4 class="text-3 text-muted text-uppercase font-weight-400 mb-3">Services</h4>
          <ul class="nav flex-column">

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/services') }}">Transfer Money</a>
            </li>

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/services') }}">Pay Bill</a>
            </li>

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/services') }}">So Much More...</a>
            </li>

          </ul>
        </div>
        <div class="col-sm-6 col-md mb-3 mb-md-0">
        <h4 class="text-3 text-muted text-uppercase font-weight-400 mb-3">Help Center</h4>
          <ul class="nav flex-column">

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/contact') }}">Contact Us</a>
            </li>

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/support') }}">Live Chat</a>
            </li>

            <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/help') }}">Help</a>
            </li>

          </ul>
        </div>
        <div class="col-sm-6 col-md mb-3 mb-md-0">
        <h4 class="text-3 text-muted text-uppercase font-weight-400 mb-3">Keep in touch</h4>
        
          @include('layouts.social-media')

        </div>
        <div class="col-12 col-lg-3">
        <h4 class="text-3 text-muted text-uppercase font-weight-400 mb-3">Subscribe</h4>
        <p>Subscribe to receive latest news and updates.</p>
        
        <form class="needs-validation {{
            $errors->first('email') == 'Please enter a valid Email Address!' ? 
            'was-validated':''
          }}" 
          novalidate="" 
          action="{{ url('/subscribe') }}" method="post">
        
          <div class="input-group newsletter">
              <input class="form-control" 
              placeholder="Your Email Address" 
              name="email" 
              id="email"
              type="email"
              required="">
              <span class="input-group-append">
              <button class="btn btn-secondary" type="submit" data-toggle="tooltip" data-original-title="Subscribe"  
              style="border-top-right-radius:5px;border-bottom-right-radius:5px">
              <i class="fas fa-paper-plane"></i>
              </button>
              </span> 

              <div class="invalid-feedback text-2">
                Please enter a valid Email Address !
              </div>    
          </div>
        @honeyPot
        @csrf
        </form>
        

        </div>
      </div>
      </div>
      
      @include('layouts.footer-copy-right')

  </footer>
  <!-- Footer end -->
