<template>


    <!-- withdraw Modal================================== -->
      <div id="withdraw-money" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title font-weight-400">Withdraw Money</h5>
              <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body p-4">

                <div class="text-center bg-primary p-2 rounded mb-2">

                    <h3 class="text-10 text-white font-weight-400">ETB - 
                        {{ balance | money }}
                    </h3>
                    <p class="text-white">Available Balance</p>
  
                    <button class="btn btn-outline-light btn-sm shadow-none text-uppercase rounded-pill text-1"
                    @click="withdraw_money_all">
                      Withdraw Full Amount
                    </button>
  
                </div>

              <!-- Withdraw Money Form============================================= -->
              <form id="form_withdraw_money" @submit.prevent="">
                <div class="form-group">
                  <label for="withdraw_amount">Amount</label>

                  <div class="input-group">
                    <div class="input-group-prepend"> 
                        <span class="input-group-text" id="withdraw_amount_icon">ETB</span> 
                    </div>

                    <input type="text" 
                          class="form-control" 
                          value="" 
                          v-model="form_withdraw_money.withdraw_amount"
                          id="withdraw_amount"
                          name="withdraw_amount" 
                          required="" 
                          placeholder="Enter withdraw Amount in Birr"
                          @blur="validate_data(),check_withdraw_amount()"
                          @input="validate_data(),check_withdraw_amount()"
                          onblur=" validate( event, 'required|money|min:10|max:'+ userDetails.balance +'', null, true) "
                          oninput=" validate( event, 'required|money|min:10|max:'+ userDetails.balance +'', null, true) ">

                          
                  </div>
                  <div class="form-control" id="withdraw_amountError" style="display: none;"></div>
                </div>
                
                <div class="form-group">
                  <label for="payment_method_withdraw">Payment Method</label>

                  <select id="payment_method_withdraw" 
                          name="payment_method_withdraw"
                          value=""
                          v-model="form_withdraw_money.payment_method_withdraw"
                          class="custom-select" 
                          required=""
                          @blur="validate_data()"
                          @input="validate_data()"
                          onblur=" validate( event, 'required') "
                          oninput=" validate( event, 'required') ">

                    <option value="">Select withdraw Method</option>

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
                  <div class="form-control" id="payment_method_withdrawError" style="display: none;"></div>
                </div>

                <hr>

                <p class="font-weight-500">You'll withdraw 
                  <span class="text-3 float-right">{{ form_withdraw_money.withdraw_amount | money }}</span>
                </p>

                <button class="btn btn-primary btn-block"
                        @click="withdraw_money()"
                        :class="{'btn btn-secondary btn-block': isInvalid}"
                        :disabled="isInvalid">
                        Withdraw
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

    created() {
          ECHO.$on('UPDATE_DATA', ( responseData) => {
            this.balance = responseData.balance;
          });


    }
    ,

    data(){
      return{
        form_withdraw_money: new Form({
              withdraw_amount: "",
              payment_method_withdraw: "",
              card_or_bank: "",
        }),

        isInvalid: true,

        card_links: null,
        bank_links: null,
        banks: null,
        bank_name: null,
        balance: this.userDetails.balance,

      }
    }
    ,
    
    methods:{

      validate_data() {
        let form_withdraw_money = document.forms["form_withdraw_money"];
        
        for( let index = 0; index < form_withdraw_money.length - 1; index++ ){

            let input = form_withdraw_money.elements[ index ];

            if( input.value.trim() == "" ){
              this.isInvalid = true;
              return;
            }
            else if( document.getElementById(input.id+"Error").style.display == 'block' ){      
              this.isInvalid = true;
              return;
            }
            else if( this.form_withdraw_money.busy ){
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
          if( card_link.card_number == this.form_withdraw_money.payment_method_withdraw ){
            this.form_withdraw_money.card_or_bank = 'card';
            this.bank_name = this.get_bank_name(card_link.bank_id);
            check_bank_link = false;
          }
        }
        
        for(let index in this.bank_links) {
          let bank_link = this.bank_links[index];
          if( bank_link.account_number == this.form_withdraw_money.payment_method_withdraw ){
            this.form_withdraw_money.card_or_bank = 'bank';
            this.bank_name = this.get_bank_name(bank_link.bank_id);
          }
        }
      }
      ,

      withdraw_money_all() {
        this.form_withdraw_money.withdraw_amount = userDetails.balance;
        StyleErrorFreeIconLeft( 'withdraw_amount', 'withdraw_amountError' );
      }
      ,

      withdraw_money(){

        this.validate_data();

        let valid = this.check_withdraw_amount();
        if(!valid) {
          return;
        }

        this.set_card_or_bank();
        
        if( this.isInvalid == false ){
          this.confirm_withdraw();
        }
        
      }//END of goto_withdraw_confirm_modal()
      ,

      confirm_withdraw() {
        let text = `You want to withdraw ` 
                    + this.form_withdraw_money.withdraw_amount + ' birr using '
                    + this.form_withdraw_money.payment_method_withdraw + ' ( ' 
                    + this.bank_name + ' ) via ' + this.form_withdraw_money.card_or_bank + ' link. ';
        swal.fire({
          title: 'Are you sure?',
          text: text ,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes withdraw',
        }).then((result) => {
                  
          if ( result.dismiss == 'cancel' ){
            return;
          }
          else{
            this.try_withdraw();
          }
                  
        });
      }
      ,

      try_withdraw( ) {

        ECHO.$emit('START_LOADING');
        this.form_withdraw_money.post('api/withdraw_money')
        .then(( response )=>{

            let data = response.data;

            if( data == 'failed' ){
              //ALERT ERROR HAPPENED
              console.log('ALERT ERROR HAPPENED C1');
              some_thing_went_wrong.fire();
              ECHO.$emit('END_LOADING');
                
            }
            else{
              
              $('#withdraw-money').modal('hide');
              
              //$('#withdraw_amount').val("");
              //$('#payment_method_withdraw').val("");

              //UPDATE BALANCE AND TRANSACTION
              ECHO.$emit('UPDATE_DATA', data);
              Vue.prototype.userDetails.balance = data.balance;
              Vue.prototype.transactions = data.transactions.data;

              swal.fire({
                title:'Success',
                text:"You have successfully withdrawed " + this.form_withdraw_money.withdraw_amount + " birr to your Yoippsp wallet.\nYour current Yoippsp wallet balance is " + data.balance + " birr." ,
                type:'success'
              });

              this.form_withdraw_money.withdraw_amount = "";
              this.form_withdraw_money.payment_method_withdraw = "";

            ECHO.$emit('END_LOADING'); 
            }


        })
        .catch((error)=>{
            //ALERT ERROR HAPPENED
            console.log('ALERT ERROR HAPPENED C2');
            console.log(error.response.data.message);

            if( error['message'].search(422) != -1 ){
              this.show_error_to_withdraw_modal(error.response.data.message);
            }
            else {
              this.show_error_to_withdraw_modal(error);
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

      check_withdraw_amount(){

          if( this.form_withdraw_money.withdraw_amount < 3 ){
            StyleErrorIconLeft( 'withdraw_amount', 'withdraw_amountError' );
            ID( 'withdraw_amountError' ).innerHTML = `Amount must be at least greater than 3 birr.`;
            return false;
          }
          else if( this.form_withdraw_money.withdraw_amount > userDetails.balance ){
            StyleErrorIconLeft( 'withdraw_amount', 'withdraw_amountError' );              
            ID( 'withdraw_amountError' ).innerHTML = 'Insufficient balance!';
            return false;
          }
          else{
            return true;
          }

        }//END of check_withdraw_amount
        ,

      show_error_to_withdraw_modal( error_type ){

        if( error_type == 'INSUFFICIENT_WALLET_BALANCE' ){
          StyleErrorIconLeft( 'withdraw_amount', 'withdraw_amountError' );
          ID( 'withdraw_amountError' ).innerHTML = 'Insufficient balance!';
        }

        

        if( error_type == 'INVALID_LINKAGE' || error_type == 'PAYMENT_METHOD_DOESNOT_EXIST' ){
          StyleError( 'payment_method_withdraw', 'payment_method_withdrawError' );
          ID( 'payment_method_withdrawError' ).innerHTML = 'This '+ this.form_withdraw_money.card_or_bank +' number is invalid! Please contact the nearest bank branch.';
        }

        if ( this.form_withdraw_money.errors.any() ){

            if( this.form_withdraw_money.errors.has('withdraw_amount') ){
                this.invalid_withdraw_amount(error_type);
            }

            if( this.form_withdraw_money.errors.has('payment_method_withdraw') ){
                this.invalid_payment_method_withdraw(error_type);
            }

            
        }

      }
      ,

      invalid_withdraw_amount( error_type ){

        StyleErrorIconLeft( 'withdraw_amount', 'withdraw_amountError' );
        
        if( error_type == 'INSUFFICIENT_WALLET_BALANCE' ){
          ID( 'withdraw_amountError' ).innerHTML = 'Insufficient balance!';
        }
        else{
          ID( 'withdraw_amountError' ).innerHTML = this.form_withdraw_money.errors.errors.withdraw_amount;
        }

      }
      ,

      invalid_payment_method_withdraw( error_type ){
          StyleError( 'payment_method_withdraw', 'payment_method_withdrawError' );

          if( error_type == 'INVALID_LINKAGE' || error_type == 'PAYMENT_METHOD_DOESNOT_EXIST' ){
            ID( 'payment_method_withdrawError' ).innerHTML = 'This '+ this.form_withdraw_money.payment_method_withdraw +' number is invalid! Please contact the nearest bank branch.';
          }
          else{
            ID( 'payment_method_withdrawError' ).innerHTML = this.form_withdraw_money.errors.errors.payment_method_withdraw;
          }
          
      }
      ,


    }
    ,

    

    computed:{

      
      

    }
}
</script>
