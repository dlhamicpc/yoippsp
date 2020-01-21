 <template>
          <!-- Add New Bank Account Details Modal======================================== -->
          <div id="add-new-bank-account" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Add bank account</h5>

                  <button type="button"
                          class="close font-weight-400"
                          data-dismiss="modal"
                          aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body p-4">
                  <form id="form_link_bank_account" method="post" @submit.prevent="">


                

                    <div class="form-group">
                      <label for="bank_name_">Bank Name</label>
                      <select id="bank_name_"
                              name="bank_name_"
                              class="custom-select"
                              v-model="form_link_bank.bank_name"
                              onblur=" validate( event, 'required|integer') "
                              oninput=" validate( event, 'required|integer')"
                              @blur="validate_data()"
                              @input="validate_data()"
                              required="">
                        <option value="">Select Bank Name</option>
                        <option v-for="bank in banks"
                                :value="bank.id"
                                :key="bank.id">{{ bank.bank_name }}</option>
                      </select>

                      <div class="form-control" id="bank_name_Error" style="display: none;"></div>
                    </div>

                    <div class="form-group">
                      <label for="full_name">Full Name</label>
                      <input type="text" 
                            class="form-control" 
                            id="full_name"
                            name="full_name"
                            v-model="form_link_bank.full_name"
                            onblur=" validate( event, 'required|aplha_space') "
                            oninput=" validate( event, 'required|aplha_space')"
                            @blur="validate_data()"
                            @input="validate_data()"
                            required="" 
                            value="" 
                            placeholder="e.g. Abdulmejid Shemsu">
                      <div class="form-control" id="full_nameError" style="display: none;"></div>
                    </div>

                    <div class="form-group">
                      <label for="account_number">Account Number</label>
                      <input type="text" 
                            class="form-control"
                            id="account_number"
                            name="account_number"
                            v-model="form_link_bank.account_number"
                            onblur=" validate( event, 'required|string') "
                            oninput=" validate( event, 'required|string')"
                            @blur="validate_data()"
                            @input="validate_data()" 
                            required="" 
                            value="" 
                            placeholder="e.g. 1000211992208">
                            <div class="form-control" id="account_numberError" style="display: none;"></div>
                    </div>

                    <div class="form-group">
                        <label for="book_number">Account Number</label>
                        <input type="text" 
                              class="form-control"
                              id="book_number"
                              name="book_number"
                              v-model="form_link_bank.book_number"
                              onblur=" validate( event, 'required|string') "
                              oninput=" validate( event, 'required|string')"
                              @blur="validate_data()"
                              @input="validate_data()" 
                              required="" 
                              value="" 
                              placeholder="e.g. 1000211">
                              <div class="form-control" id="book_numberError" style="display: none;"></div>
                      </div>

                    <div class="form-check custom-control custom-checkbox mb-3">
                      <input id="confirm" 
                            name="confirm" 
                            class="custom-control-input" 
                            type="checkbox"
                            v-model="form_link_bank.confirm"
                            onchange=" validate( null , 'checkbox' , this ) "
                            @change="validate_data()"
                            checked
                            required=""
                            >
                      <label class="custom-control-label" for="confirm">I confirm the bank account details above</label>
                      <div class="" id="confirmError" style="display: none;"></div>
                    </div>

                    <button class="btn btn-primary btn-block"
                    @click="link_bank"
                    :class="{'btn btn-secondary btn-block': isInvalid}"
                    :disabled="isInvalid">
                    Add Bank Account
                    </button>

                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Bank Accounts End -->


 </template>


 <script>
     export default {
         mounted() {
             this.load_banks();
         },


         data(){
             return{
                 form_link_bank: new Form({
                     bank_name: "",
                     full_name: "",
                     account_number: "",
                     book_number: "",
                     confirm: false,
                 }),

                 isInvalid: true,

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
                 let form_link_bank = document.forms["form_link_bank_account"];

                 for( let index = 0; index < form_link_bank.length - 1; index++ ){

                     let input = form_link_bank.elements[ index ];

                     if( input.value.trim() == "" || input.value == false){
                         this.isInvalid = true;
                         return;
                     }
                     else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                         this.isInvalid = true;
                         return;
                     }
                     else if( this.form_link_bank.busy ){
                         this.isInvalid = true;
                         return;
                     }

                 }

                 if( this.form_link_bank.confirm == false ){
                    this.isInvalid = true;
                    return;
                 }

                 this.isInvalid = false;


             }
             ,

             link_bank(){
                 this.validate_data();
                 ECHO.$emit('START_LOADING');
                 //console.log(this.form_link_bank);

                 this.form_link_bank.post('api/link_bank')
                     .then(( response )=>{

                         let data = response.data;

                         if( data == 'success' ){
                             //Update card linkage *refresh page
                             toast.fire({
                                 type: 'success',
                                 title: 'Bank Account Linked Successfully'

                             });
                             ECHO.$emit('END_LOADING');
                             window.location.assign('/bpa/card');
                         }
                         else{
                             //ALERT ERROR HAPPENED
                             console.log('ALERT ERROR HAPPENED C1');
                             this.show_error_to_link_modal();
                             some_thing_went_wrong.fire();
                             ECHO.$emit('END_LOADING');
                         }


                     })
                     .catch((error)=>{
                         //ALERT ERROR HAPPENED
                         console.log('ALERT ERROR HAPPENED C2');
                         this.show_error_to_link_modal();
                         ECHO.$emit('END_LOADING');
                     });

             }
             ,


             invalid_bank_name( ){
                 StyleError( 'bank_name', 'bank_nameError' );
                 ID( 'bank_nameError' ).innerHTML = this.form_link_bank.errors.errors.bank_name;
             }
             ,

             invalid_account_number( ){
                 StyleError( 'account_number', 'account_numberError' );
                 let error_message = this.form_link_bank.errors.errors.account_number;

                 if( error_message.indexOf('taken') != -1 ){
                     error_message +=  `<br>*If it is not you <a href="report">report</span>.`;
                 }

                 ID( 'account_numberError' ).innerHTML = error_message;
             }
             ,

             invalid_book_number( ){
                 StyleError( 'book_number', 'book_numberError' );
                 let error_message = this.form_link_bank.errors.errors.book_number;

                 if( error_message.indexOf('taken') != -1 ){
                     error_message +=  `<br>*If it is not you <a href="report">report</span>.`;
                 }

                 ID( 'book_numberError' ).innerHTML = error_message;
             }
             ,

             invalid_full_name( ){
                 StyleError( 'full_name', 'full_nameError' );
                 ID( 'full_nameError' ).innerHTML = this.form_link_bank.errors.errors.full_name;
             }
             ,

             invalid_confirm( ){
                 StyleError( 'confirm', 'confirmError' );
                 ID( 'confirmError' ).innerHTML = this.form_link_bank.errors.errors.confirm;
             }
             ,

             show_error_to_link_modal( ){

                 if ( this.form_link_bank.errors.any() ){

                     if( this.form_link_bank.errors.has('bank_name') ){
                         this.invalid_bank_name();
                     }

                     if( this.form_link_bank.errors.has('account_number') ){
                         this.invalid_account_number();
                     }

                     if( this.form_link_bank.errors.has('book_number') ){
                         this.invalid_book_number();
                     }

                     if( this.form_link_bank.errors.has('full_name') ){
                         this.invalid_full_name();
                     }

                     if( this.form_link_bank.errors.has('confirm') ){
                         this.invalid_confirm();
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
