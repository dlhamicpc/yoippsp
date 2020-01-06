<template>


        <!-- Edit dstv Payment Modal================================== -->
        <div id="edit-dstv-payment-settings" class="modal fade " role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h5 class="modal-title font-weight-400">Dstv Bill Payment Information</h5>
                     <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                   </div>
   
                   <div class="modal-body p-4">
                     <form id="form_edit_settings_dstv_payment" method="post" @submit.prevent="">
   
                       <div class="row">
   
                         <div class="col-12">
                           <div class="form-group">
                             <label for="dstv_service_provider">Dstv Service Provider</label>
                             <select class="custom-select" 
                                     id="dstv_service_provider" 
                                     name="dstv_service_provider"
                                     v-model="form_edit_settings_dstv_payment.dstv_service_provider"
                                     onblur=" validate(event, 'required') "
                                     oninput=" validate(event, 'required') "
                                     @blur="validate_data()"
                                     @input="validate_data()"
                                     required>
                               <option value="" disabled>Select Dstv Service Provider</option>
   
                               <option  v-for="wsp in dstv_service_providers" 
                                       v-text="wsp.bill_payment_name" 
                                       :key="wsp.id"
                                       :value="wsp.id">
                               </option>
   
                             </select>
                             <div class="form-control" id="dstv_service_providerError" style="display: none;"></div>
                           </div>
                         </div>


                         <div class="col-12">
                                <div class="form-group">
                                  <label for="dstv_payment_identification">Dstv Payment Identification</label>
                                  <input type="dstv_payment_identification" 
                                        value="" 
                                        v-model="form_edit_settings_dstv_payment.dstv_payment_identification"
                                        class="form-control" 
                                        id="dstv_payment_identification" 
                                        name="dstv_payment_identification"
                                        required=""
                                        onblur=" validate( event, 'required') "
                                        oninput=" validate( event, 'required') "
                                        @blur="validate_data()"
                                        @input="validate_data()"
                                        placeholder="dstv Payment Identification">
                                  
                                        <div class="form-control" id="dstv_payment_identificationError" style="display: none;"></div>
                                </div>
                        </div>
   
                       </div>
   
                       <button class="btn btn-primary btn-block"
                       @click="update_dstv_payment_info"
                       :class="{'btn btn-secondary btn-block': isInvalid}"
                       :disabled="isInvalid">
                       Save Changes
                       </button>
   
                     </form>
   
                   </div>
   
                 </div>
               </div>
             </div>
             <!-- dstv Payment Settings End -->
   
   
   </template>
   
   
   <script>
       export default {


           mounted() {
             this.load_dstv_service_providers();
             ECHO.$on('UPDATE_DSTV_BILL_INFO', (data)=>{
               
             });
             
           },
   
   
           data(){
               return{
                 form_edit_settings_dstv_payment: new Form({
                       dstv_service_provider: userBillPaymentLinks.dstv.bill_payment_id,
                       dstv_payment_identification: userBillPaymentLinks.dstv.user_payment_identification,
                   }),
   
                   isInvalid: false,
                   dstv_service_providers: null,
   
               }
           }
           ,
   
   
           methods: {
   
             load_dstv_service_providers(){
                  ECHO.$emit('START_LOADING');
   
                  axios.get("api/get_dstv_service_providers")
                       .then(({data}) => (
                          this.dstv_service_providers = data
                        ));

   
                  ECHO.$emit('END_LOADING');
   
                }//END of load_dstv_service_providers
                ,
             
               validate_data(){
                   let form_edit_settings_dstv_payment = document.forms["form_edit_settings_dstv_payment"];
   
                   for( let index = 0; index < form_edit_settings_dstv_payment.length - 1; index++ ){
   
                       let input = form_edit_settings_dstv_payment.elements[ index ];
   
                       if( input.value.trim() == "" ){
                           input.blur();
                           this.isInvalid = true;
                           return;
                       }
                       else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                           this.isInvalid = true;
                           return;
                       }
                       else if( this.form_edit_settings_dstv_payment.busy ){
                           this.isInvalid = true;
                           return;
                       }
   
                   }
   
                   this.isInvalid = false;
   
   
               }
               ,
   
               update_dstv_payment_info(){
   
                   this.validate_data();
                   ECHO.$emit('START_LOADING');
   
                   this.form_edit_settings_dstv_payment.put('api/update_dstv_payment_info')
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
                             
                             ECHO.$emit('UPDATE_DSTV_BILL_INFO', data);
                             userBillPaymentLinks.dstv = data;
                             //Vue.prototype.userBillPaymentLinks.dstv = data;
                             
                             $('#edit-dstv-payment-settings').modal('hide');
                             toast.fire({
                                   type: 'success',
                                   title: 'Dstv Payment Information Updated Successfully'
   
                               });
                            ECHO.$emit('END_LOADING'); 
                           }
   
   
                       })
                       .catch((error)=>{
                           //ALERT ERROR HAPPENED
                           console.log('ALERT ERROR HAPPENED C2');
                           this.show_error_to_update_modal();
                           some_thing_went_wrong.fire();
                           ECHO.$emit('END_LOADING');
                       });
   
               }
               ,
   
   
               invalid_dstv_service_provider( ){
                   StyleError( 'dstv_service_provider', 'dstv_service_providerError' );
                   ID( 'dstv_service_providerError' ).innerHTML = this.form_edit_settings_dstv_payment.errors.errors.dstv_service_provider;
               }
               ,
   
               invalid_dstv_payment_identification( ){
                   StyleError( 'dstv_payment_identification', 'dstv_payment_identificationError' );
                   ID( 'dstv_payment_identificationError' ).innerHTML = this.form_edit_settings_dstv_payment.errors.errors.dstv_payment_identification;
               }
               ,
   
               show_error_to_update_modal( ){
   
                   if ( this.form_edit_settings_dstv_payment.errors.any() ){
   
                       if( this.form_edit_settings_dstv_payment.errors.has('dstv_service_provider') ){
                           this.invalid_dstv_service_provider();
                       }
   
                       if( this.form_edit_settings_dstv_payment.errors.has('dstv_payment_identification') ){
                           this.invalid_dstv_payment_identification();
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