<template>


        <!-- Edit electricity Payment Modal================================== -->
        <div id="edit-electricity-payment-settings" class="modal fade " role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h5 class="modal-title font-weight-400">Electricity Bill Payment Information</h5>
                     <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                   </div>
   
                   <div class="modal-body p-4">
                     <form id="form_edit_settings_electricity_payment" method="post" @submit.prevent="">
   
                       <div class="row">
   
                         <div class="col-12">
                           <div class="form-group">
                             <label for="electricity_service_provider">Electricity Service Provider</label>
                             <select class="custom-select" 
                                     id="electricity_service_provider" 
                                     name="electricity_service_provider"
                                     v-model="form_edit_settings_electricity_payment.electricity_service_provider"
                                     onblur=" validate(event, 'required') "
                                     oninput=" validate(event, 'required') "
                                     @blur="validate_data()"
                                     @input="validate_data()"
                                     required>
                               <option value="" disabled>Select Electricity Service Provider</option>
   
                               <option  v-for="wsp in electricity_service_providers" 
                                       v-text="wsp.bill_payment_name" 
                                       :key="wsp.id"
                                       :value="wsp.id">
                               </option>
   
                             </select>
                             <div class="form-control" id="electricity_service_providerError" style="display: none;"></div>
                           </div>
                         </div>


                         <div class="col-12">
                                <div class="form-group">
                                  <label for="electricity_payment_identification">Electricity Payment Identification</label>
                                  <input type="electricity_payment_identification" 
                                        value="" 
                                        v-model="form_edit_settings_electricity_payment.electricity_payment_identification"
                                        class="form-control" 
                                        id="electricity_payment_identification" 
                                        name="electricity_payment_identification"
                                        required=""
                                        onblur=" validate( event, 'required') "
                                        oninput=" validate( event, 'required') "
                                        @blur="validate_data()"
                                        @input="validate_data()"
                                        placeholder="electricity Payment Identification">
                                  
                                        <div class="form-control" id="electricity_payment_identificationError" style="display: none;"></div>
                                </div>
                        </div>
   
                       </div>
   
                       <button class="btn btn-primary btn-block"
                       @click="update_electricity_payment_info"
                       :class="{'btn btn-secondary btn-block': isInvalid}"
                       :disabled="isInvalid">
                       Save Changes
                       </button>
   
                     </form>
   
                   </div>
   
                 </div>
               </div>
             </div>
             <!-- electricity Payment Settings End -->
   
   
   </template>
   
   
   <script>
       export default {


           mounted() {
             this.load_electricity_service_providers();
             ECHO.$on('UPDATE_ELECTRICITY_BILL_INFO', (data)=>{
               
             });
             
           },
   
   
           data(){
               return{
                 form_edit_settings_electricity_payment: new Form({
                       electricity_service_provider: userBillPaymentLinks.electricity.bill_payment_id,
                       electricity_payment_identification: userBillPaymentLinks.electricity.user_payment_identification,
                   }),
   
                   isInvalid: false,
                   electricity_service_providers: null,
   
               }
           }
           ,
   
   
           methods: {
   
             load_electricity_service_providers(){
                  ECHO.$emit('START_LOADING');
   
                  axios.get("api/get_electricity_service_providers")
                       .then(({data}) => (
                          this.electricity_service_providers = data
                        ));

   
                  ECHO.$emit('END_LOADING');
   
                }//END of load_electricity_service_providers
                ,
             
               validate_data(){
                   let form_edit_settings_electricity_payment = document.forms["form_edit_settings_electricity_payment"];
   
                   for( let index = 0; index < form_edit_settings_electricity_payment.length - 1; index++ ){
   
                       let input = form_edit_settings_electricity_payment.elements[ index ];
   
                       if( input.value.trim() == "" ){
                           input.blur();
                           this.isInvalid = true;
                           return;
                       }
                       else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                           this.isInvalid = true;
                           return;
                       }
                       else if( this.form_edit_settings_electricity_payment.busy ){
                           this.isInvalid = true;
                           return;
                       }
   
                   }
   
                   this.isInvalid = false;
   
   
               }
               ,
   
               update_electricity_payment_info(){
   
                   this.validate_data();
                   ECHO.$emit('START_LOADING');
   
                   this.form_edit_settings_electricity_payment.put('api/update_electricity_payment_info')
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
                             
                             ECHO.$emit('UPDATE_ELECTRICITY_BILL_INFO', data);
                             userBillPaymentLinks.electricity = data;
                             //Vue.prototype.userBillPaymentLinks.electricity = data;
                             
                             $('#edit-electricity-payment-settings').modal('hide');
                             toast.fire({
                                   type: 'success',
                                   title: 'Electricity Payment Information Updated Successfully'
   
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
   
   
               invalid_electricity_service_provider( ){
                   StyleError( 'electricity_service_provider', 'electricity_service_providerError' );
                   ID( 'electricity_service_providerError' ).innerHTML = this.form_edit_settings_electricity_payment.errors.errors.electricity_service_provider;
               }
               ,
   
               invalid_electricity_payment_identification( ){
                   StyleError( 'electricity_payment_identification', 'electricity_payment_identificationError' );
                   ID( 'electricity_payment_identificationError' ).innerHTML = this.form_edit_settings_electricity_payment.errors.errors.electricity_payment_identification;
               }
               ,
   
               show_error_to_update_modal( ){
   
                   if ( this.form_edit_settings_electricity_payment.errors.any() ){
   
                       if( this.form_edit_settings_electricity_payment.errors.has('electricity_service_provider') ){
                           this.invalid_electricity_service_provider();
                       }
   
                       if( this.form_edit_settings_electricity_payment.errors.has('electricity_payment_identification') ){
                           this.invalid_electricity_payment_identification();
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