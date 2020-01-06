<template>
    <div>
        <!-- Send Money Modal================================== -->
          <div id="send-money" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Send Money</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <!-- Send Money Form============================================= -->

                    <form id="form_send_money" @submit.prevent="">

                      <div class="form-group">
                        <label for="receiver_address">Recipient Email or Mobile number</label>

                        <div class="input-group">

                              <div class="input-group-prepend"> 
                                  <span class="input-group-text" id="receiver_address_icon" onclick="alert('Comming Soon')">
                                      <i class="fas fa-camera"></i>
                                  </span> 
                                </div>


                          <input type="text" 
                                  value=""
                                  v-model="form_send_money.receiver_address" 
                                  class="form-control" 
                                  :class="{'is-invalid': form_send_money.errors.has('receiver_address')}"
                                  id="receiver_address"
                                  name="receiver_address" 
                                  required="" 
                                  placeholder="Email or Mobile number"
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  onblur=" validate( event, 'required|email_mobile_number|exists', null, true) "
                                oninput=" validate( event, 'required|email_mobile_number|exists', null, true) ">
                        </div>
                                <div class="form-control" id="receiver_addressError" style="display: none;"></div>
                      </div>

                      <div class="form-group">
                        <label for="youSend">Amount</label>

                        <div class="input-group">
                          <div class="input-group-prepend"> 
                            <span class="input-group-text" id="sending_amount_icon">ETB</span> 
                          </div>

                          <input type="text" 
                                class="form-control"
                                :class="{'is-invalid': form_send_money.errors.has('sending_amount')}" 
                                id="sending_amount"
                                name="sending_amount" 
                                value=""
                                v-model="form_send_money.sending_amount" 
                                required="" 
                                placeholder="Amount"
                                @blur="validate_data(),check_sending_amount()"
                                @input="validate_data(),check_sending_amount()"
                                onblur=" validate( event, 'required|money', null, true) "
                                oninput=" validate( event, 'required|money', null, true) ">
                                
                        </div>

                        <div class="form-control" id="sending_amountError" style="display: none;"></div>

                      </div>
                      <hr>

                      <p class="font-weight-500">Total To Send
                        <span class="text-3 float-right">{{ form_send_money.sending_amount | money }}</span>
                      </p>

                      <button class="btn btn-primary btn-block"
                            @click="goto_send_confirm_modal()"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Continue
                      </button>

                    </form>

            <!-- Send Money Form end --> 
                </div>
              </div>
            </div>
          </div>

          <send-money-confirm :form_send_money="form_send_money"></send-money-confirm>
          
  </div>

</template>

<script>
    export default {
        mounted() {
            //console.log('Send Component mounted.');
        }
        ,

        created(){
          this.checkIfMobile();
        }
        ,

        data(){
          return{
            form_send_money: new Form({
                  sending_amount: "",
                  receiver_address: "",
            }),

            isInvalid: true,
            isMobile: false,

          }
        }
        ,
        
        methods:{
          showQRIntro() {
              confirm("Use your camera to take a picture of a QR code.");
          }
          ,

          validate_data(){
            let form_send_money = document.forms["form_send_money"];
            
            for( let index = 0; index < form_send_money.length - 1; index++ ){

                let input = form_send_money.elements[ index ];

                if( input.value.trim() == "" ){
                  this.isInvalid = true;
                  return;
                }
                else if( document.getElementById(input.id+"Error").style.display == 'block' ){      
                  this.isInvalid = true;
                  return;
                }
                else if( this.form_send_money.errors.hasAny('sending_amount', 'receiver_address')  ){
                  this.isInvalid = true;
                  return;
                }
                else if( this.form_send_money.busy ){
                  this.isInvalid = true;
                  return;
                }
                   
            }
            
            this.isInvalid = false;
            
            
          }
          ,

          check_receiver_address_existance(){
            let receiver_address = this.form_send_money.receiver_address;
  
            let field_id = "receiver_address";
            let error_field_id = field_id + "Error";
            let field_name = "receiver_address";

            if( user.email == receiver_address || user.mobile_number == receiver_address ){
              StyleError( field_id, error_field_id );
              ID( error_field_id ).innerHTML = 'You can\'t send to your self enter another\'s person address!';
              this.isInvalid = true;
              return true;
            }

            ECHO.$emit('START_LOADING');
            axios.post( '/api/exists/'+ field_id, {

                    data: receiver_address

            }).then( (response)=>{

                responseData = response.data;

                if( responseData == 0){
                  StyleError( field_id, error_field_id );
                  ID( error_field_id ).innerHTML = `* The receiver address you provided doesn't exist in our system!<br>
                                                * Please Check your spelling!`;
                  this.isInvalid = true;
                  ECHO.$emit('END_LOADING');
                  return true;
                }
                ECHO.$emit('END_LOADING');
                this.isInvalid = false;
                return false;

            }).catch((error)=>{
              ECHO.$emit('END_LOADING');
              this.isInvalid = true;
              return true;
            });

          }//END of check_receiver_address_existance
          ,

          check_sending_amount(){

            if( this.form_send_money.sending_amount < 3 ){
              StyleErrorIconLeft( 'sending_amount', 'sending_amountError' );
              ID( 'sending_amountError' ).innerHTML = `Amount must be at least greater than 3 birr.`;
            }
            else if( this.form_send_money.sending_amount > userDetails.balance ){
              
              StyleErrorIconLeft( 'sending_amount', 'sending_amountError' );              
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

          }//END of check _sending_amount
          ,

          goto_send_confirm_modal(){
            
            this.check_receiver_address_existance();
            
            this.check_sending_amount();
            this.validate_data();

            if( this.isInvalid == false ){
              $('#send-money').modal('hide');
              $('#send-money-confirm').modal('show');
            }
            
          }//END of goto_send_confirm_modal()
          ,

          checkIfMobile(){

            if (screen.width < 768){
              this.isMobile = true;
            }

          }


        }
        ,

        computed:{

          
          

        }
    }
</script>
