<template>


              <!-- Edit Details Modal================================== -->
              <div id="edit-mobile-number" class="modal fade " role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title font-weight-400">Mobile number</h5>
                          <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body p-4">
        
                          <form id="form_edit_mobile_number" method="post" @submit.prevent="">
        
                            <div class="row">

                              <div class="col-12">
                                <div class="form-group">
                                  <label for="primary_mobile_number">Primary Mobile number</label>
                                  <input type="text" 
                                        value="" 
                                        v-model="form_edit_mobile_number.primary_mobile_number"
                                        class="form-control" 
                                        id="primary_mobile_number" 
                                        name="primary_mobile_number"
                                        required=""
                                        onblur=" validate( event, 'required|mobile_number') "
                                        oninput=" validate( event, 'required|mobile_number') "
                                        @blur="validate_data()"
                                        @input="validate_data()"
                                        placeholder="Primary Mobile number">
                                  
                                        <div class="form-control" id="primary_mobile_numberError" style="display: none;"></div>
                                </div>
                              </div>

                              <div class="col-12">
                                  <div class="form-group">
                                    <label for="secondary_mobile_number">Secondary Mobile number</label>
                                    <input type="text" 
                                          value="" 
                                          v-model="form_edit_mobile_number.secondary_mobile_number"
                                          class="form-control" 
                                          id="secondary_mobile_number" 
                                          name="secondary_mobile_number"
                                          required=""
                                          onblur=" validate( event, 'required|mobile_number') "
                                          oninput=" validate( event, 'required|mobile_number') "
                                          @blur="validate_data()"
                                          @input="validate_data()"
                                          placeholder="Secondary Mobile number">
                                    
                                          <div class="form-control" id="secondary_mobile_numberError" style="display: none;"></div>
                                  </div>
                                </div>

                            </div>
        
                            <button class="btn btn-primary btn-block"
                            @click="update_mobile_number"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Save Changes
                            </button>

                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- mobile_number Addresses End -->


</template>




<script>
    export default {
        mounted() {

          ECHO.$on('UPDATE_MOBILE_NUMBER', (data)=>{
            this.primary_mobile_number = data.primary_mobile_number;
            this.secondary_mobile_number = data.secondary_mobile_number;
          });


        },


        data(){
            return{
              form_edit_mobile_number: new Form({
                    primary_mobile_number: this.user.mobile_number,
                    secondary_mobile_number: this.userDetails.admin_office_phone_number,

                }),

                isInvalid: false,

            }
        }
        ,


        methods: {
          
            validate_data(){
                let form_edit_mobile_number = document.forms["form_edit_mobile_number"];

                for( let index = 0; index < form_edit_mobile_number.length - 1; index++ ){

                    let input = form_edit_mobile_number.elements[ index ];
                    

                    if( input.value.trim() == "" ){
                        input.blur();
                        this.isInvalid = true;
                        return;
                    }
                    else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                        this.isInvalid = true;
                        return;
                    }
                    else if( this.form_edit_mobile_number.busy ){
                        this.isInvalid = true;
                        return;
                    }

                }

                this.isInvalid = false;


            }
            ,

            update_mobile_number(){

                this.validate_data();
                ECHO.$emit('START_LOADING');

                this.form_edit_mobile_number.put('api/update_mobile_number')
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
                          ECHO.$emit('UPDATE_MOBILE_NUMBER', data);
                          Vue.prototype.user = data.user;
                          Vue.prototype.userDetails = data.userDetails;
                          console.log(userDetails.admin_office_phone_number);

                          $('#edit-mobile-number').modal('hide');
                          toast.fire({
                                type: 'success',
                                title: 'Mobile number Updated Successfully'

                            });
                         ECHO.$emit('END_LOADING'); 
                        }


                    })
                    .catch((error)=>{
                        //ALERT ERROR HAPPENED
                        console.log('ALERT ERROR HAPPENED C2' + error);
                        this.show_error_to_update_modal();
                        some_thing_went_wrong.fire();
                        ECHO.$emit('END_LOADING');
                    });

            }
            ,



            invalid_primary_mobile_number( ){
                StyleError( 'primary_mobile_number', 'primary_mobile_numberError' );
                ID( 'primary_mobile_numberError' ).innerHTML = this.form_edit_mobile_number.errors.errors.primary_mobile_number;
            }
            ,

            invalid_secondary_mobile_number( ){
                StyleError( 'secondary_mobile_number', 'secondary_mobile_numberError' );
                ID( 'secondary_mobile_numberError' ).innerHTML = this.form_edit_mobile_number.errors.errors.secondary_mobile_number;
            }
            ,
          
            show_error_to_update_modal( ){

                if ( this.form_edit_mobile_number.errors.any() ){

                  
                    if( this.form_edit_mobile_number.errors.has('primary_mobile_number') ){
                        this.invalid_mobile_number();
                    }
                    
                    if( this.form_edit_mobile_number.errors.has('secondary_mobile_number') ){
                        this.invalid_secondary_mobile_number();
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