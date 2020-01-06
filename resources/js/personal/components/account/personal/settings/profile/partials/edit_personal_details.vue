<template>


    <!-- Edit Details Modal================================== -->
    <div id="edit-personal-details" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Personal Details</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">


                  <form id="form_edit_personal_details" method="post" @submit.prevent="">
                    <div class="row">
                      <div class="col-12 col-sm-6">

                        <div class="form-group">
                          <label for="name">Your Name</label>
                          <input type="text"
                                value="" 
                                v-model="form_edit_personal_details.name"
                                class="form-control"  
                                id="name"
                                name="name" 
                                required=""
                                onblur=" validate(event, 'required|alpha') "
                                oninput=" validate(event, 'required|alpha') "
                                @blur="validate_data()"
                                @input="validate_data()"
                                placeholder="Your Name">
                                
                          <div class="form-control" id="nameError" style="display: none;"></div>
                        </div>

                      </div>

                      <div class="col-12 col-sm-6">

                        <div class="form-group">
                          <label for="father_name">Father's Name</label>
                          <input type="text" 
                                value="" 
                                v-model="form_edit_personal_details.father_name"
                                class="form-control" 
                                id="father_name"
                                name="father_name" 
                                required=""
                                onblur=" validate(event, 'required|alpha') "
                                oninput=" validate(event, 'required|alpha') "
                                @blur="validate_data()"
                                @input="validate_data()" 
                                placeholder="Father's Name">
                          
                          <div class="form-control" id="father_nameError" style="display: none;"></div>
                        </div>

                      </div>
                      
                      <div class="col-12">

                        <div class="form-group">
                          <label for="date_of_birth">Date of Birth</label>

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
                                  placeholder="Date of Birth" >
                            <span class="icon-inside"><i class="fas fa-calendar-alt"></i></span> 

                          </div>
                          <div class="form-control" id="date_of_birthError" style="display: none;"></div>
                        </div>

                      </div>
                      <div class="col-12">
                        <h3 class="text-5 font-weight-400 mt-3">Address</h3>
                        <hr>
                      </div>
                      <div class="col-12">

                        <div class="form-group">
                          <label for="address">Address</label>
                          <input type="text" 
                                value=""
                                v-model="form_edit_personal_details.address" 
                                class="form-control" 
                                id="address"
                                name="address"
                                placeholder="Address"
                                @blur="validate_data()"
                                @input="validate_data()">
                        </div>
                        <div class="form-control" id="addressError" style="display: none;"></div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <label for="city">City</label>
                        <div class="form-group">
                            <select class="custom-select" 
                                    id="city" 
                                    name="city"
                                    v-model="form_edit_personal_details.city"
                                    onblur=" validate(event, 'required|integer') "
                                    oninput=" validate(event, 'required|integer') "
                                    @blur="validate_data()"
                                    @input="validate_data()"
                                    required>

                              <option value=""> --- Please Select --- </option>
                              <option value="1">Addis Ababa</option>
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
                                  v-model="form_edit_personal_details.state"
                                  onblur=" validate(event, 'required|integer') "
                                  oninput=" validate(event, 'required|integer') "
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  required>
                            <option value=""> --- Please Select --- </option>
                            <option value="1">Addis Ababa</option>
                          </select>
                          <div class="form-control" id="stateError" style="display: none;"></div>
                        </div>
                      </div>

                      <div class="col-12 col-sm-6">

                        <div class="form-group">
                          <label for="home_number">Home Number</label>
                          <input id="home_number"
                              name="home_number"
                              value="" 
                              v-model="form_edit_personal_details.home_number"
                              type="text" 
                              class="form-control"
                              onblur=" validate(event, 'string') "
                              oninput=" validate(event, 'string') " 
                              @blur="validate_data()"
                              @input="validate_data()"
                              placeholder="Home number">
                          
                          <div class="form-control" id="home_numberError" style="display: none;"></div>
                        </div>

                      </div>

                      <div class="col-12 col-sm-6">

                        <div class="form-group">
                          <label for="country">Country</label>

                          <select class="custom-select" 
                                  id="country" 
                                  name="country"
                                  v-model="form_edit_personal_details.country"
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
                    @click="update_personal_details"
                    :class="{'btn btn-secondary btn-block': isInvalid}"
                    :disabled="isInvalid">
                    Save Changes
                    </button>


                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Edit Personal Details End -->


</template>



<script>
    export default {
        mounted() {
          ECHO.$emit('START_BIRTH_DATE');
          ECHO.$on('UPDATE_PERSONAL_DETAILS', (data)=>{
            this.userDetails = data;
          });

          $('#date_of_birth').val(
            this.filter_birth_date(this.userDetails.date_of_birth)
          );

        },


        data(){
            return{
              form_edit_personal_details: new Form({
                    name: this.userDetails.name,
                    father_name: this.userDetails.father_name,
                    date_of_birth: this.userDetails.date_of_birth,
                    address: this.userDetails.address,
                    state: this.userDetails.state,
                    city: this.userDetails.city,
                    country: this.userDetails.country,
                    home_number: this.userDetails.home_number,
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
                let form_edit_personal_details = document.forms["form_edit_personal_details"];

                for( let index = 0; index < form_edit_personal_details.length - 1; index++ ){

                    let input = form_edit_personal_details.elements[ index ];
                    
                    if( input.id == 'date_of_birth' ){
                      if ( ($('#date_of_birth').val()).trim() == '' ){
                        this.isInvalid = true;
                        return;
                      } 
                    }
                    
                    if( input.id == 'address' || input.id == 'home_number' ){
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
                    else if( this.form_edit_personal_details.busy ){
                        this.isInvalid = true;
                        return;
                    }

                }

                this.isInvalid = false;


            }
            ,

            update_personal_details(){

                this.validate_data();
                ECHO.$emit('START_LOADING');

                this.form_edit_personal_details.date_of_birth =  $('#date_of_birth').val();

                this.form_edit_personal_details.put('api/update_personal_details')
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
                          ECHO.$emit('UPDATE_PERSONAL_DETAILS', data);
                          Vue.prototype.userDetails = data;

                          this.update_full_name_side_nav_bar( data );

                          $('#edit-personal-details').modal('hide');
                          toast.fire({
                                type: 'success',
                                title: 'Personal Details Updated Successfully'

                            });
                         ECHO.$emit('END_LOADING'); 
                        }


                    })
                    .catch((error)=>{
                        //ALERT ERROR HAPPENED
                        console.log('ALERT ERROR HAPPENED C2');
                        this.show_error_to_update_modal();
                        ECHO.$emit('END_LOADING');
                    });

            }
            ,

            update_full_name_side_nav_bar( data ) {

              let name = data.name;
              let father_name = data.father_name;

              let fixed_name = name.charAt(0).toUpperCase() + name.substr(1);
              let fixed_father_name = father_name.charAt(0).toUpperCase() + father_name.substr(1);

              let full_name = fixed_name + " " + fixed_father_name;
              
              $('#full_name_side_bar').text(full_name);
              $('#full_name_nav_bar').text(full_name);

              //return full_name;

            }
            ,


            invalid_name( ){
                StyleError( 'name', 'nameError' );
                ID( 'nameError' ).innerHTML = this.form_edit_personal_details.errors.errors.name;
            }
            ,

            invalid_father_name( ){
                StyleError( 'father_name', 'father_nameError' );
                ID( 'father_nameError' ).innerHTML = this.form_edit_personal_details.errors.errors.father_name;
            }
            ,

            invalid_date_of_birth( ){
                StyleError( 'date_of_birth', 'date_of_birthError' );
                ID( 'date_of_birthError' ).innerHTML = this.form_edit_personal_details.errors.errors.date_of_birth;
            }
            ,

            invalid_country( ){
                StyleError( 'country', 'countryError' );
                ID( 'countryError' ).innerHTML = this.form_edit_personal_details.errors.errors.country;
            }
            ,

            invalid_city( ){
                StyleError( 'city', 'cityError' );
                ID( 'cityError' ).innerHTML = this.form_edit_personal_details.errors.errors.city;
            }
            ,

            invalid_state( ){
                StyleError( 'state', 'stateError' );
                ID( 'stateError' ).innerHTML = this.form_edit_personal_details.errors.errors.state;
            }
            ,

            invalid_address( ){
                StyleError( 'address', 'addressError' );
                ID( 'addressError' ).innerHTML = this.form_edit_personal_details.errors.errors.address;
            }
            ,

            invalid_home_number( ){
                StyleError( 'home_number', 'home_numberError' );
                ID( 'home_numberError' ).innerHTML = this.form_edit_personal_details.errors.errors.home_number;
            }
            ,

            show_error_to_update_modal( ){

                if ( this.form_edit_personal_details.errors.any() ){

                    if( this.form_edit_personal_details.errors.has('name') ){
                        this.invalid_name();
                    }

                    if( this.form_edit_personal_details.errors.has('father_name') ){
                        this.invalid_father_name();
                    }

                    if( this.form_edit_personal_details.errors.has('date_of_birth') ){
                        this.invalid_date_of_birth();
                    }

                    if( this.form_edit_personal_details.errors.has('country') ){
                        this.invalid_country();
                    }

                    if( this.form_edit_personal_details.errors.has('city') ){
                        this.invalid_city();
                    }

                    if( this.form_edit_personal_details.errors.has('address') ){
                        this.invalid_address();
                    }

                    if( this.form_edit_personal_details.errors.has('home_number') ){
                        this.invalid_home_number();
                    }

                    if( this.form_edit_personal_details.errors.has('state') ){
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