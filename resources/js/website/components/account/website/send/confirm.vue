<template>

<div>
      <!-- Send Money confirm Modal================================== -->
          <div id="send-money-confirm" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Send Money</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                    
                  <p class="text-4 mb-2">You are sending money to 
                    <span class="font-weight-500">{{ form_send_money.receiver_address }}</span>
                  </p>
                  <!-- Send Money Confirm============================================= -->

                    <form id="form-send-money-confirm" @submit.prevent="">

                      <div class="form-group">
                        <label for="description_send">Description</label>

                        <textarea class="form-control"
                          maxlength="65535" 
                          rows="4" 
                          id="description_send"
                          name="description"
                          v-model="description" 
                          placeholder="Payment Description ( Optional )">
                        </textarea>

                      </div>

                      <h3 class="text-5 font-weight-400 mb-3">Details</h3>
                      <p class="mb-1">Send Amount 
                        <span class="text-3 float-right">{{ form_send_money.sending_amount | money }}</span>
                      </p>

                      <hr>
                      <p class="font-weight-500">Total
                        <span class="text-3 float-right"> 
                          {{ form_send_money.sending_amount | money }}
                      </span>
                      </p>

                      <div class="row">
                            <router-link to="" class="btn btn-primary col-4 mr-2 ml-3" 
                            data-target="#send-money" 
                            data-toggle="modal"
                            data-dismiss="modal" 
                            onclick="closeSideBar();">
                              <span style="color:white;">Back</span>
                            </router-link>

                          <button class="btn btn-primary col-7"
                                @click="send_money">
                                Send Money
                          </button>

                        </div>

                    </form>
                  <!-- Send Money Confirm end --> 

                </div>
              </div>
            </div>
          </div>

          <send-money-success :form_send_money="form_send_money"></send-money-success>
</div>
</template>

<script>
    export default {
        mounted() {
           // console.log('Send Confirm Component mounted.');
        }
        ,
        created(){

        }
        ,

        props:{
          form_send_money:{
            type: Object,
          }
        }
        ,

        data(){
          return{
            description: "",
            server_response: {
              description: null,
              receiver_address: null,
              sending_amount: null,
            },

          }
        }
        ,

        methods:{
          send_money(){
            ECHO.$emit('START_LOADING');
            
            this.form_send_money['description'] = this.description;
            
            this.form_send_money.post('api/send_money')
                    .then(( response )=>{
                      
                      let data = response.data;

                      if( this.send_money_successfully( data ) ){
                        //UPDATE BALANCE AND TRANSACTION
                        ECHO.$emit('UPDATE_DATA', data);
                        Vue.prototype.userDetails.balance = data.balance;
                        Vue.prototype.transactions = data.transactions.data;
                        

                        $('#receiver_address').val("");
                        $('#sending_amount').val("");
                        $('#send-money-confirm').modal('hide');
                        //$('#send-money-success').modal('show');
                        let title = 'Transactions Complete';
                        let text = 'You\'ve Succesfully sent ' + this.form_send_money.sending_amount + ' Birr to ' + this.form_send_money.receiver_address + '.';
                        swal.fire({
                          title: title,
                          text: text,
                          showConfirmationButton: true,
                          type: 'success',
                        });
                        
                        ECHO.$emit('END_LOADING');
                      }
                      else if( this.check_if_server_validation_returned( data ) ){
                        console.log('INVALID');
                        this.show_error_to_send_modal( data );
                        ECHO.$emit('END_LOADING');
                      }
                      else{
                        //ALERT ERROR HAPPENED
                        console.log('ALERT ERROR HAPPENED');
                        some_thing_went_wrong.fire();
                        alert('ALERT ERROR HAPPENED C1');
                      }
                      

                    })
                    .catch((error)=>{
                      ECHO.$emit('END_LOADING');
                      //ALERT ERROR HAPPENED
                      if( error.message.search(422) != -1 ){
                        swal.fire({
                          title: "Failed",
                          text: "The receiver account you entered doesn't accept payment!",
                          showButtonConfirmation: true,
                          type: 'warning',
                        });
                      }
                      else{
                        console.log('ALERT ERROR HAPPENED');
                        console.log(error.message);
                        some_thing_went_wrong.fire();
                      }
                  });

          }
          ,

          check_if_server_validation_returned( data ){
            try {
              let temp = data.receiver_address;
              return temp == undefined ? false:true;
            } catch (error) {
              return false;
            }

          }
          ,

          show_error_to_send_modal( data ){
            //['INVALID RECEIVER ADDRESS', 'INVALID AMOUNT', 'INSUFICEINT BALANCE'];
            let receiverAddressInfo = data.receiver_address;
            let sendingAmountInfo = data.sending_amount;

            $('#send-money-confirm').modal('hide');
            $('#send-money').modal('show');

            if( receiverAddressInfo == 'INVALID RECEIVER ADDRESS' ){
              this.invalid_receiver_address();
            }

            if( sendingAmountInfo == 'INVALID AMOUNT' ){
              this.invalid_sending_amount( sendingAmountInfo );
            }
            else if( sendingAmountInfo == 'INSUFICEINT BALANCE' ){
              this.invalid_sending_amount( sendingAmountInfo );
            }

          }
          ,

          invalid_receiver_address(){

            StyleError( 'receiver_address', 'receiver_addressError' );
            ID( 'receiver_addressError' ).innerHTML = 'Invalid receiver address!';

          }
          ,

          invalid_sending_amount( error_type ){

            StyleErrorIconLeft( 'sending_amount', 'sending_amountError' );

            if( error_type == 'INSUFICEINT BALANCE' ){
              ID( 'sending_amountError' ).innerHTML = `Insufficient balance!<br>  
                                                      * Try again after depositing to your Yoippsp wallet
                                                      <router-link to=""
                                                        class="btn btn-primary btn-sm" 
                                                        data-target="#deposit-money"
                                                        data-dismiss="modal"  
                                                        data-toggle="modal" 
                                                        onclick="closeSideBar();">
                                                        Deposit Money
                                                      </router-link>
                                                      `;
            }
            else{
              ID( 'sending_amountError' ).innerHTML = 'Invalid amount!';
            }

          }
          ,

          send_money_successfully( data ){
            try {
              let temp = data.balance;
              return temp != undefined ? true:false;
              
            } catch (error) {
              return false;
            }
          }


        }
        ,
    }
</script>
