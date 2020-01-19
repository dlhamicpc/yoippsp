<template>


        <!-- Deposit Modal================================== -->
          <div id="deposit-money" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Deposit Money</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                    
                  <!-- Deposit Money Form============================================= -->
                  <form id="form_deposit_money" @submit.prevent="">
                    <div class="form-group">
                      <label for="deposit_amount">Amount</label>

                      <div class="input-group">
                        <div class="input-group-prepend"> 
                            <span class="input-group-text" id="deposit_amount_icon">ETB</span> 
                        </div>

                        <input type="text" 
                              class="form-control" 
                              value="" 
                              v-model="form_deposit_money.deposit_amount"
                              id="deposit_amount"
                              name="deposit_amount" 
                              required="" 
                              placeholder="Enter Deposit Amount in Birr"
                              @blur="validate_data()"
                              @input="validate_data()"
                              onblur=" validate( event, 'required|money|min:10', null, true) "
                              oninput=" validate( event, 'required|money|min:10', null, true) ">

                              
                      </div>
                      <div class="form-control" id="deposit_amountError" style="display: none;"></div>
                    </div>
                    
                    <div class="form-group">
                      <label for="payment_method_deposit">Payment Method</label>

                      <select id="payment_method_deposit" 
                              name="payment_method_deposit"
                              value=""
                              v-model="form_deposit_money.payment_method_deposit"
                              class="custom-select" 
                              required=""
                              @blur="validate_data()"
                              @input="validate_data()"
                              onblur=" validate( event, 'required') "
                              oninput=" validate( event, 'required') ">

                        <option value="">Select Deposit Method</option>

                        <option disabled v-if="card_links"><strong>ATM Card(s)</strong></option>
                        <hr>

                        <option v-for="card_link in card_links" 
                                :value="card_link.card_number" 
                                :key="card_link.id">
                                {{ card_link.card_number }} ( {{ get_bank_name(card_link.bank_id) }} )
                        </option>
                        
                        <br>
                        <option disabled v-if="bank_links"><b>Bank Account(s)</b></option>
                        <hr>

                        <option v-for="bank_link in bank_links" 
                                :value="bank_link.account_number" 
                                :key="bank_link.id">
                                {{ bank_link.account_number }} ( {{ get_bank_name(bank_link.bank_id) }} )
                        </option>

                      </select>
                      <div class="form-control" id="payment_method_depositError" style="display: none;"></div>
                    </div>

                    <hr>

                    <p class="font-weight-500">You'll deposit 
                      <span class="text-3 float-right">{{ form_deposit_money.deposit_amount | money }}</span>
                    </p>

                    <button class="btn btn-primary btn-block"
                            @click="deposit_money()"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Deposit
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
            this.load_card_bank_link();
            
        }
        ,

        created(){

        }
        ,

        data(){
          return{
            form_deposit_money: new Form({
                  deposit_amount: "",
                  payment_method_deposit: "",
                  card_or_bank: "",
            }),

            isInvalid: true,

            card_links: null,
            bank_links: null,
            banks: null,
            bank_name: null,

          }
        }
        ,
        
        methods:{

          validate_data(){
            let form_deposit_money = document.forms["form_deposit_money"];
            
            for( let index = 0; index < form_deposit_money.length - 1; index++ ){

                let input = form_deposit_money.elements[ index ];

                if( input.value.trim() == "" ){
                  this.isInvalid = true;
                  return;
                }
                else if( document.getElementById(input.id+"Error").style.display == 'block' ){    this.isInvalid = true;
                  return;
                }
                else if( this.form_deposit_money.busy ){
                  this.isInvalid = true;
                  return;
                }
                   
            }
            
            this.isInvalid = false;
            
            
          }
          ,

          set_card_or_bank() {
            let check_bank_link = true;
            for(let index in this.card_links) {
              let card_link = this.card_links[index];
              if( card_link.card_number == this.form_deposit_money.payment_method_deposit ){
                this.form_deposit_money.card_or_bank = 'card';
                this.bank_name = this.get_bank_name(card_link.bank_id);
                check_bank_link = false;
              }
            }
            
            for(let index in this.bank_links) {
              let bank_link = this.bank_links[index];
              if( bank_link.account_number == this.form_deposit_money.payment_method_deposit ){
                this.form_deposit_money.card_or_bank = 'bank';
                this.bank_name = this.get_bank_name(bank_link.bank_id);
              }
            }
          }
          ,

          deposit_money(){

            this.validate_data();
            this.set_card_or_bank();
            
            if( this.isInvalid == false ){
              this.confirm_deposit();
            }
            
          }//END of goto_deposit_confirm_modal()
          ,

          confirm_deposit() {
            let text = `You want to deposit ` 
                        + this.form_deposit_money.deposit_amount + ' birr using '
                        + this.form_deposit_money.payment_method_deposit + ' ( ' 
                        + this.bank_name + ' ) via ' + this.form_deposit_money.card_or_bank + ' link. ';
            swal.fire({
              title: 'Are you sure?',
              text: text ,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes deposit',
            }).then((result) => {
                      
              if ( result.dismiss == 'cancel' ){
                return;
              }
              else{
                this.try_deposit();
              }
                      
            });
          }
          ,

          try_deposit( ) {

            ECHO.$emit('START_LOADING');
            this.form_deposit_money.post('api/deposit_money')
            .then(( response )=>{

                let data = response.data;

                if( data == 'failed' ){
                  //ALERT ERROR HAPPENED
                  console.log('ALERT ERROR HAPPENED C1');
                  some_thing_went_wrong.fire();
                  ECHO.$emit('END_LOADING');
                    
                }
                else{
                  
                  $('#deposit-money').modal('hide');
                  

                  //UPDATE BALANCE AND TRANSACTION
                  ECHO.$emit('UPDATE_DATA', data);
                  Vue.prototype.userDetails.balance = data.balance;
                  Vue.prototype.transactions = data.transactions.data;

                  swal.fire({
                    title:'Success',
                    text:"You have successfully deposited " + this.form_deposit_money.deposit_amount + " birr to your Yoippsp wallet.\nYour current Yoippsp wallet balance is " + data.balance + " birr." ,
                    type:'success'
                  });

                  this.form_deposit_money.deposit_amount = "";
                  this.form_deposit_money.payment_method_deposit = "";

                ECHO.$emit('END_LOADING'); 
                }


            })
            .catch((error)=>{
                //ALERT ERROR HAPPENED
                console.log('ALERT ERROR HAPPENED C2');
                console.log(error);

                if( error['message'].search(422) != -1 ){
                  this.show_error_to_deposit_modal(error.response.data.message);
                }
                else {
                  this.show_error_to_deposit_modal(error);
                  some_thing_went_wrong.fire();
                }
                
                ECHO.$emit('END_LOADING');
            });

          }
          ,

          load_card_bank_link(){
            ECHO.$emit('START_LOADING');

            axios.get("api/get_card_bank_link")
                .then(({data}) => (

                  this.card_links = data.card_links,
                  this.bank_links = data.bank_links,
                  this.banks = data.banks

                ));
            ECHO.$emit('END_LOADING');

          }//END of load_card_bank_link()
          ,

          get_bank_name(bank_id) {
            for(let index in this.banks){
              let bank = this.banks[index];
              if( bank.id == bank_id ) return bank.bank_name + " Bank";
            }
          }
          ,

          show_error_to_deposit_modal( error_type ){

            if( error_type == 'INSUFFICIENT_BANK_BALANCE' ){
              StyleErrorIconLeft( 'deposit_amount', 'deposit_amountError' );
              ID( 'deposit_amountError' ).innerHTML = 'Insufficient balance!';
            }

            

            if( error_type == 'INVALID_LINKAGE' || error_type == 'payment_method_deposit_PAYMENT_METHOD_DOESNOT_EXIST' ){
              StyleError( 'payment_method_deposit', 'payment_method_depositError' );
              ID( 'payment_method_depositError' ).innerHTML = 'This '+ this.form_deposit_money.card_or_bank +' number is invalid! Please contact the nearest bank branch.';
            }

            if ( this.form_deposit_money.errors.any() ){

                if( this.form_deposit_money.errors.has('deposit_amount') ){
                    this.invalid_deposit_amount(error_type);
                }

                if( this.form_deposit_money.errors.has('payment_method_deposit') ){
                    this.invalid_payment_method_deposit(error_type);
                }

                
            }

          }
          ,

          invalid_deposit_amount( error_type ){

            StyleErrorIconLeft( 'deposit_amount', 'deposit_amountError' );
            
            if( error_type == 'INSUFFICIENT_BANK_BALANCE' ){
              ID( 'deposit_amountError' ).innerHTML = 'Insufficient balance!';
            }
            else{
              ID( 'deposit_amountError' ).innerHTML = this.form_deposit_money.errors.errors.deposit_amount;
            }

          }
          ,

          invalid_payment_method_deposit( error_type ){
              StyleError( 'payment_method_deposit', 'payment_method_depositError' );

              if( error_type == 'INVALID_LINKAGE' || error_type == 'payment_method_deposit_PAYMENT_METHOD_DOESNOT_EXIST' ){
                ID( 'payment_method_depositError' ).innerHTML = 'This '+ this.form_deposit_money.payment_method_deposit +' number is invalid! Please contact the nearest bank branch.';
              }
              else{
                ID( 'payment_method_depositError' ).innerHTML = this.form_deposit_money.errors.errors.payment_method_deposit;
              }
              
          }
          ,


        }
        ,

        

        computed:{

          
          

        }
    }
</script>
