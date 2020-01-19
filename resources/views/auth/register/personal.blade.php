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

    <title>@appName Personal Registration</title>

    <link rel="stylesheet" href="{{ asset('/css/register/signin.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('/css/register/register.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/register/icon.css') }}">
  </head>

  <body>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav" style="float: right;">
            <li class="" >
              <a href="{{ url('http://account.yoippsp.com/login') }}" class="btn btn-info login" >Login</a>
            </li>
          </ul>
          <ul class="nav" style="float: left;">
            <li class="" >
              <a href="{{ url('http://yoippsp.com') }}" class="btn btn-info login" >@appName</a>
            </li>
          </ul>

        </nav>

      </div>

      <div class="">



        <form class="form-signin needs-validation"
              id="regForm"
              action="{{ route('pa_register') }}"
              method="POST">

          <div class="form-group" id="textDescribe">
            <h3 class="" style="margin: 30px;"><center>One account for all</center></h3>
          </div>

          <div class="step-indicator" style="text-align:center;margin: 10px;" id="stepIndicate">
            <span class="step" style="width: 2.2em;height: 2.2em;font-size: 1.2em;font-weight:600;border-radius:2.2em;" id="step1">
              <span class="step-title" style="">1</span>
            </span>
            <span class="step" style="background:transparent;" id="line">
              <hr class="step-title" style="width: 3em;
                            height: .4em;
                            margin:0 -15px;
                            margin-left: -16px;
                            background: #0069d9;
                            border: none;" >
            </span>
            <span class="step" style="width: 2.2em;height: 2.2em;font-size: 1.2em;font-weight:600;border-radius:2.2em;" id="step2">
              <span class="step-title">2</span>
            </span>
          </div>

          <p class="md-4"></p>

          <div class="tab tabOne" id="tab1" style="">
            <div class="row">
              <div class="form-group col-12 col-md-12">
                    <select class="form-control"
                            id="country"
                            name="country"
                            onblur=" validate(event, 'required|alpha_space') "
                            oninput=" validate(event, 'required|alpha_space') "
                            required
                            >
                            <!--fetch from the database-->
                      <option  value="">Select Your Country</option>
                      @foreach( $countries as $country )
                        @if( $country->name == old('country') )
                          <option value="{{ $country->name }}" selected>{{ $country->name }}</option>
                        @else
                          <option value="{{ $country->name }}">{{ $country->name }}</option>
                        @endif
                      @endforeach

                    </select>
                    <div class="form-control" 
                      id="countryError" 
                      style="display: none;">
              
                    </div>
              </div>

              <div class="form-group col-12 col-md-12">
                    <select class="form-control "
                            id="state"
                            name="state"
                            onblur=" validate(event, 'required|alpha_space') "
                            oninput=" validate(event, 'required|alpha_space') "
                            required>
                            <option value="">Select Your State</option>
                      @foreach( $states as $state )
                        @if( $state->name == old('state') )
                          <option value="{{ $state->name }}" selected=>{{ $state->name }}</option>
                        @else
                          <option value="{{ $state->name }}">{{ $state->name }}</option>
                        @endif
                      @endforeach
                    </select>
                    <div class="form-control" id="stateError" style="display: none;">
                  
                    </div>
              </div>

              <div class="form-group col-12 col-md-12">
                    <select class="form-control"
                            id="city"
                            name="city"
                            onblur=" validate(event, 'required|alpha_space') "
                            oninput=" validate(event, 'required|alpha_space') "
                            required>
                            <option  value="">Select Your City</option>
                      @foreach( $cities as $city )
                        @if( $city->name == old('city') )
                          <option value="{{ $city->name }}" selected>{{ $city->name }}</option>
                        @else
                          <option value="{{ $city->name }}">{{ $city->name }}</option>
                        @endif
                      @endforeach
                    </select>
                    <div class="form-control" id="cityError" style="display: none;">
                    
                    </div>
              </div>

            </div>

            <div class="row">



              <div class="form-group col-md-12">
                  <input type="email"
                        class="form-control"
                        placeholder="Email Address"
                        name="email"
                        value="{{ old('email') }}"
                        id="email"
                        onblur=" validate( event, 'required|email|unique') "
                        oninput=" validate( event, 'required|email') "
                        required>
                  <div class="form-control" id="emailError" style="display: none;">
                 
                  </div>
              </div>

            </div>

            <div class="row">

              <div class="form-group col-md-12">
                <input type="password"
                      class="form-control"
                      placeholder="Create Password"
                      name="password"
                      value="{{ old('password') }}"
                      id="password"
                      onblur=" validate(event, 'required|password') "
                      oninput=" validate(event, 'required|password') "
                      required>
                <div class="form-control" id="passwordError" style="display: none;">
                
                </div>
              </div>

              <div class="form-group col-md-12">
                <input type="password"
                      class="form-control"
                      placeholder="Confirm Password"
                      name="password_confirmation"
                      value="{{ old('password_confirmation') }}"
                      id="password_confirmation"
                      onblur=" validate(event, 'required|confirm') "
                      oninput=" validate(event, 'required|confirm') "
                      required>
                <div class="form-control" id="password_confirmationError" style="display: none;">
                
                </div>
              </div>



            </div>
          </div>

          <div class="tab tabTwo" id="tab2" style="">
            <div class="row">
                <div class="form-group col-md-12">
                  <input type="text"
                        class="form-control in"
                        placeholder="Your name"
                        name="name"
                        value="{{ old('name') }}"
                        id="name"
                        onblur=" validate(event, 'required|alpha') "
                        oninput=" validate(event, 'required|alpha') "
                        required>
                  <div class="form-control" id="nameError" style="display: none;">
                  
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <input type="text"
                        class="form-control in"
                        placeholder="Father's name"
                        name="father_name"
                        value="{{ old('father_name') }}"
                        id="father_name"
                        onblur=" validate(event, 'required|alpha') "
                        oninput=" validate(event, 'required|alpha') "
                        required>
                  <div class="form-control" id="father_nameError" style="display: none;">
                
                  </div>
                </div>
            </div>

            <div class="row">

              <div class="form-group col-md-12">
                  <input type="tel"
                        class="form-control"
                        placeholder="Phone number ( 09 29 19 48 72 )"
                        name="mobile_number"
                        value="{{ old('mobile_number') }}"
                        id="mobile_number"
                        onblur=" validate(event, 'required|mobile_number|unique') "
                        oninput=" validate(event, 'required|mobile_number') "
                        required
                        maxlength="13"
                        >
                  <div class="form-control" 
                      id="mobile_numberError" 
                      style="
                      display: none;
                      @error('mobile_number')
                      display:block;
                      @enderror
                      ">
                  
                  </div>
              </div>


            </div>

            <div class="row">

                <div class="col-md-12 mb-3">
                  <label for="birthday">Birth day</label>
                  <input class="form-control datetimepicker"
                         id="date_of_birth"
                         name="date_of_birth"
                         onblur=" validate(event, 'required') "
                         oninput=" validate(event, 'required') "
                         type="date"
                         value="{{ old('date_of_birth') }}"
                         required>
                  <div class="form-control" id="date_of_birthError" style="display: none;">
                  
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <label for="gender">Gender</label>
                  <div class="custom-control custom-radio">
                    <input id="male"
                           name="gender"
                           type="radio"
                           onchange=" validate( null, 'gender', null ) "
                           class="custom-control-input"
                           value="M"
                           required
                           @if( old('gender') == 'M' )
                           checked
                           @endif
                           >
                    <label class="custom-control-label" for="male">Male</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input id="female"
                           name="gender"
                           type="radio"
                           onchange=" validate( null, 'gender', null ) "
                           class="custom-control-input"
                           value="F"
                           required
                           @if( old('gender') == 'F' )
                           checked
                           @endif
                           >
                    <label class="custom-control-label" for="female">Female</label>
                  </div>
                  <div class="" id="genderError" style="display: none;">
                 
                  </div>
                </div>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox"
                       class="custom-control-input"
                       id="term_privacy"
                       name="term_privacy"
                       onchange=" validate( null , 'checkbox' , this ) "
                       checked
                       required>
                <label class="custom-control-label" for="term_privacy">
                  I accept the <a href="">terms</a> and <a href="">privacy policy</a>
                </label>
                <div class="" id="term_privacyError" style="display: none;">
                
                </div>
            </div>



          </div>

          <div class="tab tabThree mt-5" id="loading" style="margin-top:20px;">
            <center><div class="row">
                <div class="form-group col-md-12 load" style="">
                  <img src="{{ asset('/images/collection/loading_gear.gif') }}">
                </div>
                <br><br>
                <div class="form-group col-md-12 load">
                  <!-- <img src="../../lib/img/loading1.gif"> -->

                <br><br>

                  <!--Sending verification code to your phone...-->
                </div>
                <br><br>
            </div></center>
          </div>

         <p class="md-4"></p>
          <center>
            <div style="overflow:auto;">
              <div style="" id="">
                <button class="btn btn-secondary col-5 col-md-5"
                        type="button"
                        id="prevBtn"
                        onclick="nextPrev(-1)">
                  Previous
                </button>
                <button class="btn btn-primary col-5 col-md-5"
                        type="button"
                        id="nextBtn"
                        onclick="nextPrev(1);">
                  Next
                </button>
                <input type="checkbox"
                       id="reg"
                       name="reg"
                       value="reg"
                       style="display: none;">

              </div>
            </div>
          </center>

          @csrf
        </form
      </div>

      @include('auth.partials.footer')

    </div> <!-- /container -->

    <script src="{{ asset('/js/thisYear.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/axios/dist/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/shortcut.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/styleHandler.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/validationRules.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/customValidate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/tabHandler_pa.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/handleServerValidation.js') }}" type="text/javascript"></script>
    

    <script type="text/javascript" >

    @include('auth.register.error_with_js')

		</script>
    
  
  </body>
</html>
