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

    <title>@appName Website Registration</title>

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
              <a href="{{ asset('/login') }}" class="btn btn-info login" >Login</a>
            </li>
          </ul>
          <ul class="nav" style="float: left;">
            <li class="" >
              <a href="{{ asset('/') }}" class="btn btn-info login" >@appName</a>
            </li>
          </ul>

        </nav>

      </div>

      <div class="">



        <form class="form-signin needs-validation"
              id="regForm"
              action="{{ route('wa_register') }}"
              method="POST">

          <div class="form-group" id="textDescribe">
            <h3 class="" style="margin: 30px;"><center>Extend You Reach</center></h3>
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
                            onblur=" validate(event, 'required|integer') "
                            oninput=" validate(event, 'required|integer') "
                            required
                            >
                            <!--fetch from the database-->
                      <option  value="">Select Your Country</option>
                      @foreach( $countries as $country )
                        @if( $country->id == old('country') )
                          <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                        @else
                          <option value="{{ $country->id }}">{{ $country->name }}</option>
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
                            onblur=" validate(event, 'required|integer') "
                            oninput=" validate(event, 'required|integer') "
                            required>
                            <option value="">Select Your State</option>
                      @foreach( $states as $state )
                        @if( $state->id == old('state') )
                          <option value="{{ $state->id }}" selected=>{{ $state->name }}</option>
                        @else
                          <option value="{{ $state->id }}">{{ $state->name }}</option>
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
                            onblur=" validate(event, 'required|integer') "
                            oninput=" validate(event, 'required|integer') "
                            required>
                            <option  value="">Select Your City</option>
                      @foreach( $cities as $city )
                        @if( $city->id == old('city') )
                          <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                        @else
                          <option value="{{ $city->id }}">{{ $city->name }}</option>
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
                    <input type="tel"
                        class="form-control"
                        placeholder="Primary Mobile Number ( 0929194872 )"
                        name="primary_mobile_number"
                        value="{{ old('primary_mobile_number') }}"
                        id="primary_mobile_number"
                        onblur=" validate(event, 'required|mobile_number|unique') "
                        oninput=" validate(event, 'required|mobile_number') "
                        required
                        maxlength="13"
                        >
                    <div class="form-control" 
                        id="primary_mobile_numberError" 
                        style="
                        display: none;
                        @error('primary_mobile_number')
                        display:block;
                        @enderror
                        ">
                    
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="form-group col-md-12">
                    <input type="tel"
                        class="form-control"
                        placeholder="Secondary Mobile Number ( 0929194873 )"
                        name="secondary_mobile_number"
                        value="{{ old('secondary_mobile_number') }}"
                        id="secondary_mobile_number"
                        onblur=" validate(event, 'required|mobile_number|unique') "
                        oninput=" validate(event, 'required|mobile_number') "
                        required
                        maxlength="13"
                        >
                    <div class="form-control" 
                        id="secondary_mobile_numberError" 
                        style="
                        display: none;
                        @error('secondary_mobile_number')
                        display:block;
                        @enderror
                        ">
                    
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


          <!-- Website Type -->
            <div class="row">

                <div class="form-group col-12 col-md-12">
                        <select class="form-control"
                                id="type_of_website"
                                name="type_of_website"
                                onblur=" validate(event, 'required|integer') "
                                oninput=" validate(event, 'required|integer') "
                                required
                                >
                                <!--fetch from the database-->
                        <option  value="">Select The Type of Website</option>
                        @foreach( $websiteTypes as $type )
                        @if( $type->id == old('type_of_website') )
                          <option value="{{ $type->id }}" selected>{{ $type->website_name }}</option>
                        @else
                          <option value="{{ $type->id }}">{{ $type->website_name }}</option>
                        @endif
                        @endforeach

                        </select>
                        <div class="form-control" 
                        id="type_of_websiteError" 
                        style="display: none;">
                
                        </div>
                </div>

            </div>

            <!-- Website Name -->
            <div class="row">
                <div class="form-group col-md-12">
                  <input type="text"
                        class="form-control in"
                        placeholder="Company Name,eg.Merkato E-Commerece"
                        name="company_name"
                        value="{{ old('company_name') }}"
                        id="company_name"
                        onblur=" validate(event, 'required|alpha_space') "
                        oninput=" validate(event, 'required|alpha_space') "
                        required>
                  <div class="form-control" id="company_nameError" style="display: none;">
                  
                  </div>
                </div>

            </div>

            <!-- Domain Name -->
            <div class="row">
                <div class="form-group col-md-12">
                  <input type="text"
                        class="form-control in"
                        placeholder="Full Website Domain,eg.https://www.merkato.com"
                        name="website_domain"
                        value="{{ old('website_domain') }}"
                        id="website_domain"
                        onblur=" validate(event, 'required|url') "
                        oninput=" validate(event, 'required|url') "
                        required>
                  <div class="form-control" id="website_domainError" style="display: none;">
                  
                  </div>
                </div>

            </div>

             <!-- Website Headquarter -->
             <div class="row">
                <div class="form-group col-md-12">
                  <input type="text"
                        class="form-control in"
                        placeholder="Company Headquarter "
                        name="company_headquarter"
                        value="{{ old('company_headquarter') }}"
                        id="company_headquarter"
                        onblur=" validate(event, 'required|alpha_space') "
                        oninput=" validate(event, 'required|alpha_space') "
                        required>
                  <div class="form-control" id="company_headquarterError" style="display: none;">
                  
                  </div>
                </div>

            </div>



            <div class="row">
                <div class="form-group col-md-12">
                  <input type="text"
                        class="form-control in"
                        placeholder="Administrator Name"
                        name="administrator_name"
                        value="{{ old('administrator_name') }}"
                        id="administrator_name"
                        onblur=" validate(event, 'required|alpha') "
                        oninput=" validate(event, 'required|alpha') "
                        required>
                  <div class="form-control" id="administrator_nameError" style="display: none;">
                  
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <input type="text"
                        class="form-control in"
                        placeholder="Administrator's Father name"
                        name="administrator_father_name"
                        value="{{ old('administrator_father_name') }}"
                        id="administrator_father_name"
                        onblur=" validate(event, 'required|alpha') "
                        oninput=" validate(event, 'required|alpha') "
                        required>
                  <div class="form-control" id="administrator_father_nameError" style="display: none;">
                
                  </div>
                </div>
            </div>

           

            <div class="row">

                <div class="col-md-12 mb-3">
                  <label for="birthday">Birth day</label>
                  <input class="form-control datetimepicker"
                         id="administrator_date_of_birth"
                         name="administrator_date_of_birth"
                         onblur=" validate(event, 'required') "
                         oninput=" validate(event, 'required') "
                         type="date"
                         value="{{ old('administrator_date_of_birth') }}"
                         required>
                  <div class="form-control" id="administrator_date_of_birthError" style="display: none;">
                  
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
                  I accept the <a href="http://yoippsp.com/terms">terms</a> and 
                  <a href="http://yoippsp.com/privacy">privacy policy</a>
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
    <script src="{{ asset('/js/tabHandler_wa.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/handleServerValidation.js') }}" type="text/javascript"></script>
    

    <script type="text/javascript" >

    @include('auth.register.error_with_js')

		</script>
    
  
  </body>
</html>
