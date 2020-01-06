<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="@appName Pay">
    <meta name="author" content="dlham">
    <link rel="icon" href="{{ asset('/images/logo.png') }}">

    <title>@appName Pay</title>

    
    <link rel="stylesheet" href="{{ asset('/innerWebsite/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">

  </head>

  <body>
    <div class="container card-border-color card-border-color-primary" id="container">

      <div class="">

        <form action="{{ route('pay') }}" method="POST" class="form-signin"  onsubmit="show_loading()">

          <div class="form-group">
			
            <p class="" style="">
				<center>
          <h2>
          <img src="{{ asset('/images/logo.png') }}" height="100" alt="@appName" width="100">
            YOIPPSP
          </h2>
				</center>
			</p>
          </div>

          
			<div class="row">
				<div class="form-group col-md-12">
					<label for="email_mobile" class="sr-only">
                    {{ __('E-Mail Address or Mobile phone number') }}
                    </label>
					
					<input type="text"
						   id="email_mobile"
						   class="form-control @error('email_mobile') is-invalid @enderror"
						   name="email_mobile"
						   value="{{ old('email_mobile') }}"
						   placeholder="Email or Mobile"
						   required
                           autocomplete="email_mobile"
                           autofocus
                           oninput="this.className = 'form-control'">
					
					<label for="password" class="sr-only">
                    {{ __('Password') }}
                    </label>
					
					<input type="password"
						   id="password"
						   class="form-control 
                            @error('password') 
                            is-invalid 
                            @enderror
                            @error('email_mobile')
                            @if(
                              $message == 'These credentials do not match our records.'
                            ||
                              strstr($message, 'Too many')
                            )
                            is-invalid
                            @endif
                            @enderror
                            "
						   name="password"
						   placeholder="Password"
                           value="{{ old('password') }}"
						   autocomplete="current-password"
                           oninput="this.className = 'form-control'">
				
                @error('email_mobile')
                  
                    <span class="invalid-feedback text-center" role="alert">
                    <strong id="message">{{ $message }}</strong>
                    </span>

                    @if( strstr($message, 'Too many') )

                      <script>
                        let seconds = {{ $errors->all()[1] }};
                        let message = document.getElementById('message');
                        let message_without_seconds = 'Too many attempts. Please try again in ';

                        setInterval(() => {
                          seconds--;
                          if( seconds <= 0 ){
                            document.getElementById('email_mobile').className = 'form-control';
                            document.getElementById('password').className = 'form-control';
                            message.innerHTML = '';
                            return 0;
                          }
                          message.innerHTML = message_without_seconds + seconds + ' seconds.';
                        }, 1000);
                      </script>

                    @endif
                @enderror

                @error('password')
                <span class="invalid-feedback  text-center" role="alert">
                    <strong>The password field is required.</strong>
                </span>
                @enderror
                </div>

  
				<div class="col-md-12">
					<button type="submit"
              class="btn btn-primary btn-block">
              <span style="display:none" id="loading1">
                <img src="{{ asset('/images/collection/ajax_loader.gif') }}" >
              </span>
                          <b>Pay {{ (double)$amount }} Birr</b>
              <span style="display:none" id="loading2">
                <img src="{{ asset('/images/collection/ajax_loader.gif') }}">
              </span>
          </button>
        </div>
        
        <div class="row mt-2">
        
          <div class="col-12">
              <div class="callout callout-info m-1" style="box-shadow:20px;">
                <h5><i class="fas fa-info"></i> Note:</h5>
                By click the pay button you are agreeing you to pay 
                <b> {{ (double)$amount }} Birr </b> 
                to 
                <a href="{{ $website_url }}" style="color:#007bff;text-decoration:none">
                  {{ $website_name.' ( '. $website_url .' )' }}
                </a>
              </div>
          </div>

          <div class="col-12 text-center">
            <div class="btn btn-primary m-2">
            <i class="fas fa-lock"></i>
            &nbsp;SECURED BY YOIPPSP
            </div>
          
          
          </div>
        
        </div>
			</div>

            @honeyPot
            @csrf
        </form>
    </div>

  @include('auth.partials.footer')

			</div>
		</div><!-- /container -->
		
		
		
		
    <script src="{{ asset('/js/login.js') }}"></script>
    <script>
      function show_loading() {
        document.getElementById('loading1').style.display = 'inline';
        document.getElementById('loading2').style.display = 'inline'; 
      }
    </script>
		
  </body>
</html>
