<div class="footer-copyright pt-4 mt-4">
      
      <div class="container">
        <div class="row">
          <div class="col-lg">
            <p class="text-center text-lg-left mb-2 mb-lg-0">Copyright &copy; 2019 
              <a href="{{ url('/') }}">
              @appName
              </a>. All Rights Reserved.
            </p>
          </div>
          @yield('social-media')
          
          <div class="col-lg d-lg-flex align-items-center justify-content-lg-end">
          
            <ul class="nav justify-content-center">
              
              <li class="nav-item"> 
                <a class="nav-link" href="{{ url('/terms') }}">Terms</a>
              </li>

              <li class="nav-item"> 
              <a class="nav-link" href="{{ url('/privacy') }}">Privacy</a>
              </li>

              <li class="nav-item"  style="margin-top:-15px;"> 
              <div class="nav-link p-0 btn btn-sm"> 
                  <span class="">
                        <select id="youSendCurrency" 
                        data-style="custom-select bg-transparent border-0 mb-0" 
                        data-container="body"
                        class="selectpicker form-control bg-transparent" 
                        required="">
                          <optgroup label="Choose Your Language">
                          <option 
                            data-icon="currency-flag currency-flag-usd mr-1"  
                            selected="selected" 
                            value="en">
                          English
                          </option>
                          <option 
                          data-icon="currency-flag currency-flag-etb mr-1" 
                          value="am">
                          Amharic
                          </option>
                          </optgroup>
                
                        </select>
                    </span> 
                </div>

              </li>

            </ul>
          </div>
        </div>
      </div>

</div>
