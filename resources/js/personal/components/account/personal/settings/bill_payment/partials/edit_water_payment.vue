<template>


        <!-- Edit Water Payment Modal================================== -->
        <div id="edit-water-payment-settings" class="modal fade " role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h5 class="modal-title font-weight-400">Water Bill Payment Information</h5>
                     <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                   </div>
   
                   <div class="modal-body p-4">
                     <form id="form_edit_settings_water_payment" method="post" @submit.prevent="">
   
                       <div class="row">
   
                         <div class="col-12">
                           <div class="form-group">
                             <label for="water_service_provider">Water Service Provider</label>
                             <select class="custom-select" 
                                     id="water_service_provider" 
                                     name="water_service_provider"
                                     v-model="form_edit_settings_water_payment.water_service_provider"
                                     onblur=" validate(event, 'required') "
                                     oninput=" validate(event, 'required') "
                                     @blur="validate_data()"
                                     @input="validate_data()"
                                     required>
                               <option value="" disabled>Select Water Service Provider</option>
   
                               <option  v-for="wsp in water_service_providers" 
                                       v-text="wsp.bill_payment_name" 
                                       :key="wsp.id"
                                       :value="wsp.id">
                               </option>
   
                             </select>
                             <div class="form-control" id="water_service_providerError" style="display: none;"></div>
                           </div>
                         </div>


                         <div class="col-12">
                                <div class="form-group">
                                  <label for="water_payment_identification">Water Payment Identification</label>
                                  <input type="water_payment_identification" 
                                        value="" 
                                        v-model="form_edit_settings_water_payment.water_payment_identification"
                                        class="form-control" 
                                        id="water_payment_identification" 
                                        name="water_payment_identification"
                                        required=""
                                        onblur=" validate( event, 'required') "
                                        oninput=" validate( event, 'required') "
                                        @blur="validate_data()"
                                        @input="validate_data()"
                                        placeholder="Water Payment Identification">
                                  
                                        <div class="form-control" id="water_payment_identificationError" style="display: none;"></div>
                                </div>
                        </div>
   
                       </div>
   
                       <button class="btn btn-primary btn-block"
                       @click="update_water_payment_info"
                       :class="{'btn btn-secondary btn-block': isInvalid}"
                       :disabled="isInvalid">
                       Save Changes
                       </button>
   
                     </form>
   
                   </div>
   
                 </div>
               </div>
             </div>
             <!-- Water Payment Settings End -->
   
   
   </template>
   
   
   <script>
       export default {


           mounted() {
             this.load_water_service_providers();
             ECHO.$on('UPDATE_WATER_PAYMENT_INFO', (data)=>{
               
             });
             
           },
   
   
           data(){
               return{
                 form_edit_settings_water_payment: new Form({
                       water_service_provider: userBillPaymentLinks.water.bill_payment_id,
                       water_payment_identification: userBillPaymentLinks.water.user_payment_identification,
                   }),
   
                   isInvalid: false,
                   water_service_providers: null,
   
               }
           }
           ,
   
   
           methods: {
   
             load_water_service_providers(){
                  ECHO.$emit('START_LOADING');
   
                  axios.get("api/get_water_service_providers")
                       .then(({data}) => (
                          this.water_service_providers = data
                        ));

   
                  ECHO.$emit('END_LOADING');
   
                }//END of load_water_service_providers
                ,
             
               validate_data(){
                   let form_edit_settings_water_payment = document.forms["form_edit_settings_water_payment"];
   
                   for( let index = 0; index < form_edit_settings_water_payment.length - 1; index++ ){
   
                       let input = form_edit_settings_water_payment.elements[ index ];
   
                       if( input.value.trim() == "" ){
                           input.blur();
                           this.isInvalid = true;
                           return;
                       }
                       else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                           this.isInvalid = true;
                           return;
                       }
                       else if( this.form_edit_settings_water_payment.busy ){
                           this.isInvalid = true;
                           return;
                       }
   
                   }
   
                   this.isInvalid = false;
   
   
               }
               ,
   
               update_water_payment_info(){
   
                   this.validate_data();
                   ECHO.$emit('START_LOADING');
   
                   this.form_edit_settings_water_payment.put('api/update_water_payment_info')
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
                             
                            
   
                             ECHO.$emit('UPDATE_WATER_BILL_INFO', data);
                             userBillPaymentLinks.water = data;
                             
                             $('#edit-water-payment-settings').modal('hide');
                             toast.fire({
                                   type: 'success',
                                   title: 'Water Payment Information Updated Successfully'
   
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
   
   
               invalid_water_service_provider( ){
                   StyleError( 'water_service_provider', 'water_service_providerError' );
                   ID( 'water_service_providerError' ).innerHTML = this.form_edit_settings_water_payment.errors.errors.water_service_provider;
               }
               ,
   
               invalid_water_payment_identification( ){
                   StyleError( 'water_payment_identification', 'water_payment_identificationError' );
                   ID( 'water_payment_identificationError' ).innerHTML = this.form_edit_settings_water_payment.errors.errors.water_payment_identification;
               }
               ,
   
               show_error_to_update_modal( ){
   
                   if ( this.form_edit_settings_water_payment.errors.any() ){
   
                       if( this.form_edit_settings_water_payment.errors.has('water_service_provider') ){
                           this.invalid_water_service_provider();
                       }
   
                       if( this.form_edit_settings_water_payment.errors.has('water_payment_identification') ){
                           this.invalid_water_payment_identification();
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