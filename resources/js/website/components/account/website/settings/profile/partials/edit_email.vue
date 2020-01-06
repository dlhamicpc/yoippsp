<template>


              <!-- Edit Details Modal================================== -->
              <div id="edit-email" class="modal fade " role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title font-weight-400">Email Addresses</h5>
                          <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body p-4">
        
                          <form id="form_edit_email" method="post" @submit.prevent="">
        
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" 
                                        value="" 
                                        v-model="form_edit_email.email"
                                        class="form-control" 
                                        id="email" 
                                        name="email"
                                        required=""
                                        onblur=" validate( event, 'required|email') "
                                        oninput=" validate( event, 'required|email') "
                                        @blur="validate_data()"
                                        @input="validate_data()"
                                        placeholder="Email Address">
                                  
                                        <div class="form-control" id="emailError" style="display: none;"></div>
                                </div>
                              </div>
                            </div>
        
                            <button class="btn btn-primary btn-block"
                            @click="update_email"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Save Changes
                            </button>

                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Email Addresses End -->


</template>




<script>
    export default {
        mounted() {

          ECHO.$on('UPDATE_EMAIL', (data)=>{
            this.email = data.email;
          });


        },


        data(){
            return{
              form_edit_email: new Form({
                    email: this.user.email
                }),

                isInvalid: false,

            }
        }
        ,


        methods: {
          
            validate_data(){
                let form_edit_email = document.forms["form_edit_email"];

                for( let index = 0; index < form_edit_email.length - 1; index++ ){

                    let input = form_edit_email.elements[ index ];
                    

                    if( input.value.trim() == "" ){
                        input.blur();
                        this.isInvalid = true;
                        return;
                    }
                    else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                        this.isInvalid = true;
                        return;
                    }
                    else if( this.form_edit_email.busy ){
                        this.isInvalid = true;
                        return;
                    }

                }

                this.isInvalid = false;


            }
            ,

            update_email(){

                this.validate_data();
                ECHO.$emit('START_LOADING');

                this.form_edit_email.put('api/update_email')
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
                          ECHO.$emit('UPDATE_EMAIL', data);
                          Vue.prototype.user = data;

                          this.update_email_nav_bar( data.email );

                          $('#edit-email').modal('hide');
                          toast.fire({
                                type: 'success',
                                title: 'Email Updated Successfully'

                            });
                         ECHO.$emit('END_LOADING'); 
                        }


                    })
                    .catch((error)=>{
                        //ALERT ERROR HAPPENED
                        console.log('ALERT ERROR HAPPENED C2' + error);
                        this.some_thing_went_wrong.fire();
                        this.show_error_to_update_modal();
                        ECHO.$emit('END_LOADING');
                    });

            }
            ,

            update_email_nav_bar( email ) {
              
              $('#email_nav_bar').text( email );


            }
            ,


            invalid_email( ){
                StyleError( 'email', 'emailError' );
                ID( 'emailError' ).innerHTML = this.form_edit_email.errors.errors.email;
            }
            ,
          
            show_error_to_update_modal( ){

                if ( this.form_edit_email.errors.any() ){

                    if( this.form_edit_email.errors.has('email') ){
                        this.invalid_email();
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