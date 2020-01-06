<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="@appName Login">
    <meta name="author" content="dlham">
    <link rel="icon" href="{{ asset('/images/logo.png') }}">

    <title>@appName Login</title>

    <link rel="stylesheet" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" >
	<link rel="stylesheet" href="{{ asset('/css/login.css') }}">

  </head>

  <body>
    <div class="container card-border-color card-border-color-primary" id="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav" style="float: right;">
            <li class="" >
              <span class="btn btn-primary login" onclick="showR();">Sign up</span>
            </li>
          </ul>
          <ul class="nav" style="float: left;">
            <li class="" >
              <a href="http://yoippsp.com" class="btn btn-primary login" >@appName</a>
            </li>
          </ul>

        </nav>

      </div>

      <div class="">

        <form action="{{ route('login') }}" method="POST" class="form-signin" onsubmit="show_loading()">

          <div class="form-group">
			
            <p class="" style="">
				<center>
					<img 
                    src="{{ asset('/images/logo.png') }}" 
                    height="100"
                    alt="@appName"
                    width="100"
                    ><br>
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
                        let message_without_seconds = 'Too many login attempts. Please try again in ';

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

                

                <div class="form-group row col-md-12" style="padding: 0px;margin-left:1px;">
                    <div class="col-5">
                      <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Remember') }}</label>
                      </div>
                    </div>
                    <div class="col-7 login-forgot-password"
							style="">
                            @if (Route::has('password.request'))
						<a href="{{ route('password.request') }}" >
						{{ __('Forgot Your Password?') }}</a>
                        @endif

					</div>
            			
				</div>
				<div class="col-md-12">
					<button type="submit"
              class="btn btn-primary btn-block">
              <span style="display:none" id="loading1">
                <img src="{{ asset('/images/collection/ajax_loader.gif') }}" >
              </span>
                          {{ __('Login') }}
              <span style="display:none" id="loading2">
                <img src="{{ asset('/images/collection/ajax_loader.gif') }}" >
              </span>
          </button>
				</div>
			</div>

            @honeyPot
            @csrf
        </form>
    </div>

  @include('auth.partials.footer')

			</div>
		</div><!-- /container -->
		
		
		<div id="regChoice" class="modal" style="display: none;" >
			<div class="modal-content">
				<center>
					<div class="close">
						<span onclick="closeR();">&times;</span>
					</div>
			  </center>
				<div class="">
					<a class="btn btn-primary form-control" href="{{ url('/').'/pa-register' }}">Personal</a>
				</div><br>
				<div class="">
					<a class="btn btn-primary  form-control" href="{{ url('/').'/ba-register' }}">Company</a>
				</div><br>
				<div class="">
					<a class="btn btn-primary  form-control" href="{{ url('/').'/wa-register' }}">Website</a>
				</div><br>
				<div class="">
					<a class="btn btn-primary form-control" href="{{ url('/').'/bpa-register' }}">Bill Payment</a>
				</div><br>
                <div class="">
					<a class="btn btn-primary  form-control" href="{{ url('/').'/spa-register' }}">Service Provider</a>
				</div><br>
			</div>
		</div>	
		
    <script src="{{ asset('/js/login.js') }}"></script>
    <script>
      function show_loading() {
        document.getElementById('loading1').style.display = 'inline';
        document.getElementById('loading2').style.display = 'inline'; 
      }
    </script>
		
  </body>
</html>
