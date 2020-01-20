<template>


    <!-- Edit Details Modal================================== -->
    <div id="edit-bank-details" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">bank Details</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">


                  <form id="form_edit_bank_details" method="post" @submit.prevent="">
                    <div class="row">
                      <div class="col-12 col-sm-6">

                        <div class="form-group">
                          <label for="administrator_name">Administrator Name</label>
                          <input type="text"
                                value="" 
                                v-model="form_edit_bank_details.administrator_name"
                                class="form-control"  
                                id="administrator_name"
                                name="administrator_name" 
                                required=""
                                onblur=" validate(event, 'required|alpha') "
                                oninput=" validate(event, 'required|alpha') "
                                @blur="validate_data()"
                                @input="validate_data()"
                                placeholder="Administrator Name">
                                
                          <div class="form-control" id="administrator_nameError" style="display: none;"></div>
                        </div>

                      </div>

                      <div class="col-12 col-sm-6">

                        <div class="form-group">
                          <label for="administrator_father_name">Administrator's Father Name</label>
                          <input type="text" 
                                value="" 
                                v-model="form_edit_bank_details.administrator_father_name"
                                class="form-control" 
                                id="administrator_father_name"
                                name="administrator_father_name" 
                                required=""
                                onblur=" validate(event, 'required|alpha') "
                                oninput=" validate(event, 'required|alpha') "
                                @blur="validate_data()"
                                @input="validate_data()" 
                                placeholder="Administrator's Father Name">
                          
                          <div class="form-control" id="administrator_father_nameError" style="display: none;"></div>
                        </div>

                      </div>
                      
                      <div class="col-12">

                        <div class="form-group">
                          <label for="date_of_birth">Administrator Date of Birth</label>

                          <div class="position-relative">
                            <input id="date_of_birth"
                                  name="date_of_birth" 
                                  value=""
                                  type="text" 
                                  class="form-control" 
                                  required=""
                                  onblur=" validate(event, 'required') "
                                  oninput=" validate(event, 'required') " 
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  placeholder="Administrator Date of Birth" >
                            <span class="icon-inside"><i class="fas fa-calendar-alt"></i></span> 

                          </div>
                          <div class="form-control" id="date_of_birthError" style="display: none;"></div>
                        </div>

                      </div>

                      <div class="col-12">

                          <div class="form-group">
                            <label for="bank_name">Bank Name</label>
  
                            <div class="position-relative">
                              <input id="bank_name"
                                    name="bank_name" 
                                    value=""
                                    v-model="form_edit_bank_details.bank_name"
                                    type="text" 
                                    class="form-control" 
                                    required=""
                                    onblur=" validate(event, 'required') "
                                    oninput=" validate(event, 'required') " 
                                    @blur="validate_data()"
                                    @input="validate_data()"
                                    placeholder="Bank Name" >
  
                            </div>
                            <div class="form-control" id="bank_nameError" style="display: none;"></div>
                          </div>
  
                    </div>

                      <div class="col-12">
                        <h3 class="text-5 font-weight-400 mt-3">Bank Headquarter address</h3>
                        <hr>
                      </div>
                      <div class="col-12">

                        <div class="form-group">
                          <label for="headquarter_address">Bank Headquarter</label>
                          <input type="text" 
                                value=""
                                v-model="form_edit_bank_details.headquarter_address" 
                                class="form-control" 
                                id="headquarter_address"
                                name="headquarter_address"
                                placeholder="headquarter_address"
                                onblur=" validate(event, 'required|alpha_space') "
                                oninput=" validate(event, 'required|alpha_space') "
                                @blur="validate_data()"
                                @input="validate_data()">
                        
                          <div class="form-control" id="headquarter_addressError" style="display: none;"></div>
                        </div>
                      </div>

                      <div class="col-12 col-sm-6">
                        <label for="city">City</label>
                        <div class="form-group">
                            <select class="custom-select" 
                                    id="city" 
                                    name="city"
                                    v-model="form_edit_bank_details.city"
                                    onblur=" validate(event, 'required|integer') "
                                    oninput=" validate(event, 'required|integer') "
                                    @blur="validate_data()"
                                    @input="validate_data()"
                                    required>

                              <option value=""> --- Please Select --- </option>
                              <option value="1">Addis Ababa</option>
                              <option value="2">Harari</option>
                              <option value="3">Adama</option>
                              <option value="4">Arbaminch</option>
                              <option value="5">Jimma</option>
                              <option value="6">Hawasa</option>
                            </select>

                          <div class="form-control" id="cityError" style="display: none;"></div>
                        </div>

                      </div>

                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="state">State</label>
                          <select class="custom-select" 
                                  id="state" 
                                  name="state"
                                  v-model="form_edit_bank_details.state"
                                  onblur=" validate(event, 'required|integer') "
                                  oninput=" validate(event, 'required|integer') "
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  required>
                            <option value=""> --- Please Select --- </option>
                            <option value="1">Addis Ababa</option>
                            <option value="2">Amhara</option>
                            <option value="3">Oromiya</option>
                            <option value="4">SNPP</option>
                            <option value="5">Afar</option>
                            <option value="6">Gambella</option>
                            <option value="7">Dire Dawa</option>
                            <option value="8">Tigray</option>
                            <option value="9">Harar</option>
                            <option value="10">Benshagul Gumuz</option>
                            <option value="11">Somalia</option>
                          </select>
                          <div class="form-control" id="stateError" style="display: none;"></div>
                        </div>
                      </div>

                    

                      <div class="col-12 col-sm-12">

                        <div class="form-group">
                          <label for="country">Country</label>

                          <select class="custom-select" 
                                  id="country" 
                                  name="country"
                                  v-model="form_edit_bank_details.country"
                                  onblur=" validate(event, 'required|integer') "
                                  oninput=" validate(event, 'required|integer') "
                                  @blur="validate_data()"
                                  @input="validate_data()">
                            <option value=""> --- Please Select --- </option>
                            <option value="1">Ethiopia</option>
                          </select>

                          <div class="form-control" id="countryError" style="display: none;"></div>

                        </div>

                      </div>

                    </div>
                    
                    <button class="btn btn-primary btn-block"
                    @click="update_bank_details"
                    :class="{'btn btn-secondary btn-block': isInvalid}"
                    :disabled="isInvalid">
                    Save Changes
                    </button>


                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Edit bank Details End -->


</template>



<script>
    export default {
        mounted() {
          ECHO.$emit('START_BIRTH_DATE');
          ECHO.$on('UPDATE_BANK_DETAILS', (data)=>{
            this.userDetails = data;
          });

          $('#date_of_birth').val(
            this.filter_birth_date(this.userDetails.admin_date_of_birth)
          );

        },


        data(){
            return{
              form_edit_bank_details: new Form({
                    administrator_name: this.userDetails.admin_name,
                    administrator_father_name: this.userDetails.admin_father_name,
                    date_of_birth: this.userDetails.admin_date_of_birth,
                    headquarter_address: this.userDetails.bank_headquarter_address,
                    state: this.userDetails.bank_headquarter_state,
                    city: this.userDetails.bank_headquarter_city,
                    country: this.userDetails.bank_headquarter_country,
                    headquarter_home_number: this.userDetails.headquarter_home_number,
                    bank_name: this.userDetails.bank_name,
                }),

                isInvalid: false,

            }
        }
        ,


        methods: {
            filter_birth_date( birthDay ){
              let year_date_month = birthDay.split('-');
              return year_date_month[1]+'-'+year_date_month[2]+'-'+year_date_month[0];
            }
            ,
            validate_data(){
                let form_edit_bank_details = document.forms["form_edit_bank_details"];

                for( let index = 0; index < form_edit_bank_details.length - 1; index++ ){

                    let input = form_edit_bank_details.elements[ index ];
                    
                    if( input.id == 'date_of_birth' ){
                      if ( ($('#date_of_birth').val()).trim() == '' ){
                        this.isInvalid = true;
                        return;
                      } 
                    }
                    
                    if( input.id == 'headquarter_address' || input.id == 'headquarter_home_number' ){
                      continue;
                    }

                    if( input.value.trim() == "" || input.value == false){
                        input.blur();
                        this.isInvalid = true;
                        return;
                    }
                    else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                        this.isInvalid = true;
                        return;
                    }
                    else if( this.form_edit_bank_details.busy ){
                        this.isInvalid = true;
                        return;
                    }

                }

                this.isInvalid = false;


            }
            ,

            update_bank_details(){

                this.validate_data();
                ECHO.$emit('START_LOADING');

                this.form_edit_bank_details.date_of_birth =  $('#date_of_birth').val();
                

                this.form_edit_bank_details.put('api/update_bank_user_details')
                    .then(( response )=>{

                        let data = response.data;

                        if( data == 'failed' ){
                          //ALERT ERROR HAPPENED
                          console.log('ALERT ERROR HAPPENED C1');
                          this.show_error_to_update_modal();
                          some_thing_went_wrong.fire();
                          ECHO.$emit('END_LOADING');
                            
                        }
                        else{
                          ECHO.$emit('UPDATE_BANK_DETAILS', data);
                          Vue.prototype.userDetails = data;

                          this.update_full_name_side_nav_bar( data );

                          $('#edit-bank-details').modal('hide');
                          toast.fire({
                                type: 'success',
                                title: 'bank Details Updated Successfully'

                            });
                         ECHO.$emit('END_LOADING'); 
                        }


                    })
                    .catch((error)=>{
                        //ALERT ERROR HAPPENED
                        console.log('ALERT ERROR HAPPENED C2' + error);
                        some_thing_went_wrong.fire();
                        this.show_error_to_update_modal();
                        ECHO.$emit('END_LOADING');
                    });

            }
            ,

            update_full_name_side_nav_bar( data ) {

              let name = data.admin_name;
              let admin_father_name = data.admin_father_name;

              let fixed_name = name.charAt(0).toUpperCase() + name.substr(1);
              let fixed_admin_father_name = admin_father_name.charAt(0).toUpperCase() + admin_father_name.substr(1);

              let full_name = fixed_name + " " + fixed_admin_father_name;
              
              $('#full_name_side_bar').text(full_name);
              $('#full_name_nav_bar').text(full_name);

              //return full_name;

            }
            ,


            invalid_administrator_name( ){
                StyleError( 'administrator_name', 'administrator_nameError' );
                ID( 'administrator_nameError' ).innerHTML = this.form_edit_bank_details.errors.errors.administrator_name;
            }
            ,

            invalid_administrator_father_name( ){
                StyleError( 'administrator_father_name', 'administrator_father_nameError' );
                ID( 'administrator_father_nameError' ).innerHTML = this.form_edit_bank_details.errors.errors.administrator_father_name;
            }
            ,

            invalid_bank_name( ){
                StyleError( 'bank_name', 'bank_nameError' );
                ID( 'bank_nameError' ).innerHTML = this.form_edit_bank_details.errors.errors.bank_name;
            }
            ,

            invalid_headquarter_address( ){
                StyleError( 'headquarter_address', 'headquarter_addressError' );
                ID( 'headquarter_addressError' ).innerHTML = this.form_edit_bank_details.errors.errors.bank_name;
            }
            ,

            invalid_date_of_birth( ){
                StyleError( 'date_of_birth', 'date_of_birthError' );
                ID( 'date_of_birthError' ).innerHTML = this.form_edit_bank_details.errors.errors.date_of_birth;
            }
            ,

            invalid_country( ){
                StyleError( 'country', 'countryError' );
                ID( 'countryError' ).innerHTML = this.form_edit_bank_details.errors.errors.country;
            }
            ,

            invalid_city( ){
                StyleError( 'city', 'cityError' );
                ID( 'cityError' ).innerHTML = this.form_edit_bank_details.errors.errors.city;
            }
            ,

            invalid_state( ){
                StyleError( 'state', 'stateError' );
                ID( 'stateError' ).innerHTML = this.form_edit_bank_details.errors.errors.state;
            }
            ,

            invalid_headquarter_address( ){
                StyleError( 'headquarter_address', 'headquarter_addressError' );
                ID( 'headquarter_addressError' ).innerHTML = this.form_edit_bank_details.errors.errors.headquarter_address;
            }
            ,

            invalid_headquarter_home_number( ){
                StyleError( 'headquarter_home_number', 'headquarter_home_numberError' );
                ID( 'headquarter_home_numberError' ).innerHTML = this.form_edit_bank_details.errors.errors.headquarter_home_number;
            }
            ,

            show_error_to_update_modal( ){

                if ( this.form_edit_bank_details.errors.any() ){

                    if( this.form_edit_bank_details.errors.has('administrator_name') ){
                        this.invalid_administrator_name();
                    }

                    if( this.form_edit_bank_details.errors.has('administrator_father_name') ){
                        this.invalid_administrator_father_name();
                    }

                    if( this.form_edit_bank_details.errors.has('date_of_birth') ){
                        this.invalid_date_of_birth();
                    }

                    if( this.form_edit_bank_details.errors.has('headquarter_address') ){
                        this.invalid_headquarter_address();
                    }

                    if( this.form_edit_bank_details.errors.has('bank_name') ){
                        this.invalid_bank_name();
                    }

                    if( this.form_edit_bank_details.errors.has('country') ){
                        this.invalid_country();
                    }

                    if( this.form_edit_bank_details.errors.has('city') ){
                        this.invalid_city();
                    }

                    if( this.form_edit_bank_details.errors.has('headquarter_address') ){
                        this.invalid_headquarter_address();
                    }

                    if( this.form_edit_bank_details.errors.has('headquarter_home_number') ){
                        this.invalid_headquarter_home_number();
                    }

                    if( this.form_edit_bank_details.errors.has('state') ){
                        this.invalid_state();
                    }

                    
                }

            }
            ,
        }
        ,


        created() {

        },


    }
</script>