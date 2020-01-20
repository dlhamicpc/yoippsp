<template>



    <!-- Edit Details Modal================================== -->
    <div id="change-password" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Change Password</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="form_change_password" method="post" @submit.prevent="">

                    <div class="form-group">
                      <label for="existing_password">Confirm Current Password</label>
                      <input type="password" 
                            class="form-control" 
                            id="existing_password" 
                            name="existing_password"
                            v-model="form_change_password.existing_password"
                            onblur=" validate(event, 'required|password') "
                            oninput=" validate(event, 'required|password') "
                            @blur="validate_data()"
                            @input="validate_data()"
                            required 
                            placeholder="Enter Current Password">
                        <div class="form-control" id="existing_passwordError" style="display: none;"></div>
                    </div>

                    <div class="form-group">
                      <label for="password">New Password</label>
                      <input type="password" 
                            class="form-control"
                            id="password" 
                            name="password"
                            v-model="form_change_password.new_password"
                            onblur=" validate(event, 'required|password') "
                            oninput=" validate(event, 'required|password') "
                            @blur="validate_data()"
                            @input="validate_data()"
                            required  
                            placeholder="Enter New Password">
                        <div class="form-control" id="passwordError" style="display: none;"></div>
                    </div>

                    <div class="form-group">
                      <label for="password_confirmation">Confirm New Password</label>
                      <input type="password" 
                            class="form-control" 
                            id="password_confirmation" 
                            name="password_confirmation"
                            v-model="form_change_password.new_password_confirmation"
                            onblur=" validate(event, 'required|confirm') "
                            oninput=" validate(event, 'required|confirm') "
                            @blur="validate_data()"
                            @input="validate_data()"
                            required 
                            placeholder="Enter Confirm New Password">
                      
                      <div class="form-control" id="password_confirmationError" style="display: none;"></div>
                    </div>

                    <button class="btn btn-primary btn-block"
                            @click="update_password"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Save Changes
                    </button>
                  </form>

                </div>
              </div>
            </div>
          </div>
          <!-- Security End -->


</template>



<script>
    export default {

        data(){
            return{
              form_change_password: new Form({
                   existing_password: null,
                   new_password: null,
                   new_password_confirmation: null,
                }),

                isInvalid: true,

            }
        }
        ,


        methods: {
          
            validate_data(){
                let form_change_password = document.forms["form_change_password"];

                for( let index = 0; index < form_change_password.length - 1; index++ ){

                    let input = form_change_password.elements[ index ];
                    

                    if( input.value.trim() == "" ){
                        input.blur();
                        this.isInvalid = true;
                        return;
                    }
                    else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                        this.isInvalid = true;
                        return;
                    }
                    else if( this.form_change_password.busy ){
                        this.isInvalid = true;
                        return;
                    }

                }
                
                if( this.form_change_password.new_password != this.form_change_password.new_password_confirmation ) {
                  this.isInvalid = true;
                  return;
                }

                this.isInvalid = false;


            }
            ,

            update_password(){

                this.validate_data();

                ECHO.$emit('START_LOADING');

                this.form_change_password.put('api/update_password')
                    .then(( response )=>{

                        let data = response.data;

                        if( data == 'failed' ) {
                          //ALERT ERROR HAPPENED
                          console.log('ALERT ERROR HAPPENED C1' + error.message);
                          this.show_error_to_update_modal();
                          some_thing_went_wrong.fire();
                          ECHO.$emit('END_LOADING');
                        }
                        else if( data.errors != undefined ){

                          StyleError( 'existing_password', 'existing_passwordError' );
                          ID( 'existing_passwordError' ).innerHTML = data.errors.existing_password;
                          ECHO.$emit('END_LOADING');
                            
                        }
                        else{

                          Vue.prototype.user = data;
                          $('#change-password').modal('hide');
                          this.form_change_password.existing_password = null;
                          this.form_change_password.new_password = null;
                          this.form_change_password.new_password_confirmation = null;
                          
                          toast.fire({
                                type: 'success',
                                title: 'Password Changed Successfully'

                            });

                            
                         ECHO.$emit('END_LOADING'); 
                        }


                    })
                    .catch((error)=>{
                        //ALERT ERROR HAPPENED
                        console.log('ALERT ERROR HAPPENED C2' + error.message);
                        this.some_thing_went_wrong.fire();
                        this.show_error_to_update_modal();
                        ECHO.$emit('END_LOADING');
                    });

            }
            ,



            invalid_existing_password( ){
                StyleError( 'existing_password', 'existing_passwordError' );
                ID( 'existing_passwordError' ).innerHTML = this.form_change_password.errors.errors.existing_password;
            }
            ,

            invalid_new_password( ){
                StyleError( 'password', 'passwordError' );
                ID( 'passwordError' ).innerHTML = this.form_change_password.errors.errors.new_password;
            }
            ,

            invalid_new_password_confirmation( ){
                StyleError( 'password_confirmation', 'password_confirmationError' );
                ID( 'password_confirmationError' ).innerHTML = this.form_change_password.errors.errors.new_password_confirmation;
            }
            ,
          
            show_error_to_update_modal( ){

                if ( this.form_change_password.errors.any() ){

                    if( this.form_change_password.errors.has('existing_password') ){
                        this.invalid_existing_password();
                    }

                    if( this.form_change_password.errors.has('new_password') ){
                        this.invalid_new_password();
                    }

                    if( this.form_change_password.errors.has('new_password_confirmation') ){
                        this.invalid_new_password_confirmation();
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