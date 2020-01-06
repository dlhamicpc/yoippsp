<template>

    <!-- Add New Card Details Modal================================== -->
             <div id="edit-card-details" class="modal fade" role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h5 class="modal-title font-weight-400">Update Card</h5>
                     <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <div class="modal-body p-4">
                     <form id="form_edit_card" method="post"  @submit.prevent="">


                     <div class="form-group">
                         <label for="bank_name_edit">Bank Name</label>
                         <select id="bank_name_edit"
                                 name="bank_name_edit"
                                 class="custom-select"
                                 v-model="form_edit_card.bank_name"
                                 onblur=" validate( event, 'required|integer') "
                                 oninput=" validate( event, 'required|integer')"
                                 @blur="validate_data()"
                                 @input="validate_data()"
                                 required="">
                           <option value="">Select Bank Name</option>

                           <option v-for="bank in banks"
                                   :value="bank.id"
                                   :key="bank.id">
                               {{ bank.bank_name }}
                           </option>

                         </select>

                         <div class="form-control" id="bank_name_editError" style="display: none;"></div>
                       </div>

                       <div class="form-group">
                         <label for="type_edit">Select Card Type</label>
                         <select id="type_edit"
                                 name="type_edit"
                                 class="custom-select"
                                 v-model="form_edit_card.type"
                                 onblur=" validate( event, 'required|alpha') "
                                 oninput=" validate( event, 'required|alpha')"
                                 @blur="validate_data()"
                                 @input="validate_data()"
                                 required="">
                           <option value="">Card Type</option>
                           <option value="visa">Visa</option>
                           <option value="debit">Debit</option>
                         </select>

                         <div class="form-control" id="type_editError" style="display: none;"></div>
                       </div>

                       <div class="form-group">
                         <label for="card_number_Edit">Card Number</label>
                         <input type="text"
                               class="form-control"
                               id="card_number_edit"
                               name="card_number_edit"
                               required=""
                               value=""
                               v-model="form_edit_card.card_number"
                               placeholder="Card Number"
                               @blur="validate_data()"
                               @input="validate_data()"
                               onblur=" validate( event, 'required|integer|equals:16') "
                               oninput=" validate( event, 'required|integer|equals:16')"
                               >
                         <div class="form-control" id="card_number_editError" style="display: none;"></div>
                       </div>

                       <div class="form-row">
                         <div class="col-lg-6">
                           <div class="form-group">
                             <label for="expire_date_edit">Expire Date</label>
                             <input id="expire_date_edit"
                                     name="expire_date_edit"
                                     type="text"
                                     class="form-control"
                                     required=""
                                     value=""
                                     v-model="form_edit_card.expire_date"
                                     placeholder="MM/YY"
                                     @blur="validate_data()"
                                     @input="validate_data()"
                                     onblur=" validate( event, 'required|expire_date') "
                                     oninput=" validate( event, 'required|expire_date')">
                             <div class="form-control" id="expire_date_editError" style="display: none;"></div>
                           </div>
                         </div>


                         <div class="col-lg-6">
                           <div class="form-group">
                             <label for="cvv_edit">CVV
                               <span class="text-info ml-1"
                               data-toggle="tooltip"
                               title="Card Verification Value">
                               <i class="fas fa-question-circle">
                               </i>
                             </span>
                           </label>
                             <input id="cvv_edit"
                                     name="cvv_edit"
                                     type="text"
                                     class="form-control"
                                     required=""
                                     value=""
                                     v-model="form_edit_card.cvv"
                                     placeholder="CVV (3 digits)"
                                     @blur="validate_data()"
                                     @input="validate_data()"
                                     onblur=" validate( event, 'required|integer|equals:3') "
                                     oninput=" validate( event, 'required|integer|equals:3')">
                             <div class="form-control" id="cvv_editError" style="display: none;"></div>
                           </div>
                         </div>


                       </div>

                       <div class="form-group">
                         <label for="holder_name_edit">Card Holder Name</label>
                         <input type="text"
                                 class="form-control"
                                 id="holder_name_edit"
                                 name="holder_name_edit"
                                 required=""
                                 value=""
                                 v-model="form_edit_card.holder_name"
                                 placeholder="Card Holder Name"
                                 @blur="validate_data()"
                                 @input="validate_data()"
                                 onblur=" validate( event, 'required|alpha_space') "
                                 oninput=" validate( event, 'required|alpha_space')">
                           <div class="form-control" id="holder_name_editError" style="display: none;"></div>
                       </div>

                       <button class="btn btn-primary btn-block"
                               @click="edit_card"
                               :class="{'btn btn-secondary btn-block': isInvalid}"
                               :disabled="isInvalid">
                               Update Card
                         </button>

                     </form>
                   </div>
                 </div>
               </div>
             </div>


   </template>


   <script>
       export default {
           mounted() {
             this.load_banks();
             this.form_edit_card = this.card_info;
           },

           props:{
             card_info:{

             }
           }
           ,

           data(){
             return{
               form_edit_card: new Form({
                 id: "",
                 bank_name: "",
                 type: "",
                 card_number: "",
                 holder_name: "",
                 expire_date: "",
                 cvv: "",
               }),

               isInvalid: false,

               banks:{},

             }
           }
           ,


           methods: {

             load_banks(){
               ECHO.$emit('START_LOADING');

               axios.get("api/get_bank_names")
                    .then(({data}) => (
                       this.banks = data
                     ));

               ECHO.$emit('END_LOADING');

             }//END of load_banks
             ,

             validate_data(){
               let form_edit_card = document.forms["form_edit_card"];

               for( let index = 0; index < form_edit_card.length - 1; index++ ){

                   let input = form_edit_card.elements[ index ];

                   if( input.value.trim() == "" ){
                     this.isInvalid = true;
                     return;
                   }
                   else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                     this.isInvalid = true;
                     return;
                   }
                   else if( this.form_edit_card.busy ){
                     this.isInvalid = true;
                     return;
                   }

               }

               this.isInvalid = false;


             }
             ,

             edit_card(){
               ECHO.$emit('START_LOADING');
               //console.log(this.form_edit_card);


               this.form_edit_card.put('api/update_card/'+this.form_edit_card.id)
                       .then(( response )=>{

                         let data = response.data;

                         if( data == 'success' ){
                           //Update card editage *refresh page
                           toast.fire({
                               type: 'success',
                               title: 'Card Updated Successfully'

                           });
                           ECHO.$emit('END_LOADING');
                           window.location.assign('/wa/card');
                         }
                         else{
                           //ALERT ERROR HAPPENED
                           console.log('ALERT ERROR HAPPENED C1');
                           this.show_error_to_edit_modal();
                           some_thing_went_wrong.fire();
                           ECHO.$emit('END_LOADING');
                         }


                       })
                       .catch((error)=>{
                         //ALERT ERROR HAPPENED
                         console.log('ALERT ERROR HAPPENED C2');
                         some_thing_went_wrong.fire();
                         this.show_error_to_edit_modal();
                         ECHO.$emit('END_LOADING');
                     });

             }
             ,

             invalid_bank_name( ){
               StyleError( 'bank_name', 'bank_nameError' );
               ID( 'bank_nameError' ).innerHTML = this.form_edit_card.errors.errors.bank_name;
             }
             ,

             invalid_card_type( ){
               StyleError( 'type', 'typeError' );
               ID( 'typeError' ).innerHTML = this.form_edit_card.errors.errors.type;
             }
             ,

             invalid_card_number( ){
               StyleError( 'card_number', 'card_numberError' );
               let error_message = this.form_edit_card.errors.errors.card_number;

               if( error_message.indexOf('taken') != -1 ){
                 error_message +=  `<br>*If it is not you <a href="report">report</span>.`;
               }

               ID( 'card_numberError' ).innerHTML = error_message;
             }
             ,

             invalid_cvv( ){
               StyleError( 'cvv', 'cvvError' );
               ID( 'cvvError' ).innerHTML = this.form_edit_card.errors.errors.cvv;
             }
             ,

             invalid_expire_date( ){
               StyleError( 'expire_date', 'expire_dateError' );
               ID( 'expire_dateError' ).innerHTML = this.form_edit_card.errors.errors.expire_date;
             }
             ,

             invalid_holder_name( ){
               StyleError( 'holder_name', 'holder_nameError' );
               ID( 'holder_nameError' ).innerHTML = this.form_edit_card.errors.errors.holder_name;
             }
             ,

             show_error_to_edit_modal( ){

               if ( this.form_edit_card.errors.any() ){

                 if( this.form_edit_card.errors.has('type') ){
                   this.invalid_card_type();
                 }

                 if( this.form_edit_card.errors.has('card_number') ){
                   this.invalid_card_number();
                 }

                 if( this.form_edit_card.errors.has('cvv') ){
                   this.invalid_cvv();
                 }

                 if( this.form_edit_card.errors.has('expire_date') ){
                   this.invalid_expire_date();
                 }

                 if( this.form_edit_card.errors.has('holder_name') ){
                   this.invalid_holder_name();
                 }


               }

             }
             ,

           },


           created() {

           },


       }
   </script>
