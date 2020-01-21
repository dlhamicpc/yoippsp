@extends('innerWebsite.account.bank.layouts.master')

@section('content')

<div class="login-box" style="width:500px;margin:auto;">

  <div class="row">

      <div class="col-12">


              <div class="card card-primary">
                  <div class="card-header">
                      <h3 class="card-title text-white">Edit Bank Manager</h3>
                  </div>

                  <div class="card-body">
                    <form class="form-signin needs-validation" action="{{ route('update_bank_manager', ['bankManager' => $bankManager]) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="row">
            

                <div class="form-group col-md-12">
                    <input type="email"
                          class="form-control"
                          placeholder="Bank Manager Email Address"
                          name="email"
                          value="{{ old('email') ?? $bankManager->user->email }}" 
                          id="email"
                          onblur=" validate( event, 'required|email') "
                          oninput=" validate( event, 'required|email') "
                          required>
                    <div class="form-control" id="emailError" style="display: none;">
                  
                    </div>
                </div>


                  <div class="form-group col-md-12">
                      <input type="tel"
                          class="form-control"
                          placeholder="Bank Manager Mobile Number ( 0929194872 )"
                          name="mobile_number"
                          value="{{ old('mobile_number') ?? $bankManager->user->mobile_number }}"
                          id="mobile_number"
                          onblur=" validate(event, 'required|mobile_number') "
                          oninput=" validate(event, 'required|mobile_number') "
                          required
                          maxlength="13"
                          >
                      <div class="form-control" id="mobile_numberError" style="display: none;">
                      
                      </div>
                  </div>

            
                <div class="form-group col-md-12">
                  <input type="password"
                        class="form-control"
                        placeholder="Create Password"
                        name="password"
                        value="{{ old('password') }}"
                        id="password"
                        onblur=" validate(event, 'required|password') "
                        oninput=" validate(event, 'required|password') ">
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
                        oninput=" validate(event, 'required|confirm') ">
                  <div class="form-control" id="password_confirmationError" style="display: none;">
                  
                  </div>
                </div>

                  <div class="form-group col-md-12">
                    <input type="text"
                          class="form-control in"
                          placeholder="Bank Manager Name"
                          name="bank_manager_name"
                          value="{{ old('bank_manager_name') ?? $bankManager->name }}"
                          id="bank_manager_name"
                          onblur=" validate(event, 'required|alpha') "
                          oninput=" validate(event, 'required|alpha') "
                          required>
                    <div class="form-control" id="bank_manager_nameError" style="display: none;">
                    
                    </div>
                  </div>

                  <div class="form-group col-md-12">
                    <input type="text"
                          class="form-control in"
                          placeholder="Bank Manager's Father name"
                          name="bank_manager_father_name"
                          value="{{ old('bank_manager_father_name') ?? $bankManager->father_name }}"
                          id="bank_manager_father_name"
                          onblur=" validate(event, 'required|alpha') "
                          oninput=" validate(event, 'required|alpha') "
                          required>
                    <div class="form-control" id="bank_manager_father_nameError" style="display: none;">
                  
                    </div>
                  </div>
                  
              <!-- Branch  Name -->
              
                  <div class="form-group col-md-12">
                    <input type="text"
                          class="form-control in"
                          placeholder="Bank Branch eg.Mexico Branch"
                          name="branch_name"
                          value="{{ old('branch_name') ?? $bankManager->bank_branch}}"
                          id="branch_name"
                          onblur=" validate(event, 'required') "
                          oninput=" validate(event, 'required') "
                          required>
                    <div class="form-control" id="branch_nameError" style="display: none;">
                    
                    </div>
                  </div>

                  <div class="form-group col-md-12">
                    <input type="submit" value="Edit Bank Manager" class="form-control btn btn-primary text-white">
                    
                    </div>
                  </div>



    

              
            </div>
                    </form>

                  
              </div>

      </div>

  </div>

</div>


	
@endsection


<?php
$errorsArray = $errors->toArray();
?>

@section('js')
<script type="text/javascript">
  @if( $errors->any() )

          @foreach( $errorsArray as $errors => $error )
            
              server_validation( '{{ $errors }}', '{{ $error[0] }}' )
            
          @endforeach

  @endif
</script>

@endsection