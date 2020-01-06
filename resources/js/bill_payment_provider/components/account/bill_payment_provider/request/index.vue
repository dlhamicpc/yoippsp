<template>
    <div>
        <!-- request Money Modal================================== -->
          <div id="request-money" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Request Money</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <!-- request Money Form============================================= -->

                    <form id="form_request_money" @submit.prevent="">

                      <div class="form-group">
                        <label for="receiver_address_request">Email or Mobile number</label>

                        <input type="text" 
                                value=""
                                v-model="form_request_money.receiver_address_request" 
                                class="form-control" 
                                :class="{'is-invalid': form_request_money.errors.has('receiver_address_request')}"
                                id="receiver_address_request"
                                name="receiver_address_request" 
                                required="" 
                                placeholder="Email or Mobile number"
                                @blur="validate_data()"
                                @input="validate_data()"
                                onblur=" validate( event, 'required|email_mobile_number|exists') "
                                oninput=" validate( event, 'required|email_mobile_number|exists') ">

                                <div class="form-control" id="receiver_address_requestError" style="display: none;"></div>
                      </div>

                      <div class="form-group">
                        <label for="yourequest">Amount</label>

                        <div class="input-group">
                          <div class="input-group-prepend"> 
                            <span class="input-group-text" id="requesting_amount_icon">ETB</span> 
                          </div>

                          <input type="text" 
                                class="form-control"
                                :class="{'is-invalid': form_request_money.errors.has('requesting_amount')}" 
                                id="requesting_amount"
                                name="requesting_amount" 
                                value=""
                                v-model="form_request_money.requesting_amount" 
                                required="" 
                                placeholder="Amount"
                                @blur="validate_data()"
                                @input="validate_data()"
                                onblur=" validate( event, 'required|money', null, true) "
                                oninput=" validate( event, 'required|money', null, true) ">
                                
                        </div>

                        <div class="form-control" id="requesting_amountError" style="display: none;"></div>

                      </div>

                      <div class="form-group">
                          <label for="description">Description</label>
  
                          <textarea class="form-control"
                            maxlength="65535" 
                            rows="4" 
                            id="description"
                            name="description"
                            v-model="form_request_money.description" 
                            placeholder="Payment Description ( Optional )">
                          </textarea>
  
                      </div>

                      <hr>

                      <p class="font-weight-500">Total To request
                        <span class="text-3 float-right">{{ form_request_money.requesting_amount | money }}</span>
                      </p>

                      <button class="btn btn-primary btn-block"
                            @click="request_money()"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Request Money
                      </button>

                    </form>

            <!-- request Money Form end --> 
                </div>
              </div>
            </div>
          </div>
          
  </div>

</template>

<script>
    export default {
        mounted() {
            //console.log('request Component mounted.');
        }
        ,

        created(){

        }
        ,

        data(){
          return{
            form_request_money: new Form({
                  requesting_amount: "",
                  receiver_address_request: "",
                  description: "",
            }),

            isInvalid: true,

          }
        }
        ,
        
        methods:{

          validate_data(){
            let form_request_money = document.forms["form_request_money"];
            
            for( let index = 0; index < form_request_money.length - 1; index++ ){

                let input = form_request_money.elements[ index ];
                
                if( input.id == 'description') {
                  continue;
                }

                if( input.value.trim() == "" ){
                  this.isInvalid = true;
                  return;
                }
                else if( document.getElementById(input.id+"Error").style.display == 'block' ){      
                  this.isInvalid = true;
                  return;
                }
                else if( this.form_request_money.busy ){
                  this.isInvalid = true;
                  return;
                }
                   
            }
            
            this.isInvalid = false;
            
            
          }
          ,

          check_receiver_address_request_existance(){
            let receiver_address_request = this.form_request_money.receiver_address_request;
  
            let field_id = "receiver_address_request";
            let error_field_id = field_id + "Error";
            let field_name = "receiver_address_request";

            if( user.email == receiver_address_request || user.mobile_number == receiver_address_request ){
              StyleError( field_id, error_field_id );
              ID( error_field_id ).innerHTML = 'You can\'t request to your self enter another\'s person address!';
              this.isInvalid = true;
              return true;
            }

            ECHO.$emit('START_LOADING');
            axios.post( '/api/exists/'+ field_id, {

                    data: receiver_address_request

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

          }//END of check_receiver_address_request_existance
          ,
          
          request_money(){

            this.check_receiver_address_request_existance();
            
            this.validate_data();

            ECHO.$emit('START_LOADING');
            
            this.form_request_money.post('api/request_money')
              .then(( response )=>{
                
                let data = response.data;

                if( data == 'failed' ){
                  
                  //ALERT ERROR HAPPENED
                  console.log('ALERT ERROR HAPPENED');
                  some_thing_went_wrong.fire();
                  alert('ALERT ERROR HAPPENED C1');

                  ECHO.$emit('END_LOADING');
                }
                else{
                  swal.fire({
                    title:'Success',
                    text:"You have Successfully requested " + this.form_request_money.requesting_amount + " birr from " + this.form_request_money.receiver_address_request +".",
                    type:'success'
                  });
                  //UPDATE BALANCE AND TRANSACTION
                  ECHO.$emit('UPDATE_DATA', data);
                  Vue.prototype.userDetails.balance = data.balance;
                  Vue.prototype.transactions = data.transactions.data;

                  $('#request-money').modal('hide');
                  this.form_request_money.receiver_address_request = "";
                  this.form_request_money.requesting_amount = "";
                  this.form_request_money.description = "";

                  ECHO.$emit('END_LOADING');
                }
                

              })
              .catch((error)=>{
                //ALERT ERROR HAPPENED
                console.log('ALERT ERROR HAPPENED');
                console.log(error);
                some_thing_went_wrong.fire();
                if ( this.form_request_money.errors.any() ) {
                  this.show_error_to_request_modal();
                }
                else{
                  some_thing_went_wrong.fire();
                }
                
                ECHO.$emit('END_LOADING');
            });

          }
          ,



          show_error_to_request_modal( ){
            if( this.form_request_money.errors.has('receiver_address_request') ){
              this.invalid_receiver_address_request();
            }

            if( this.form_request_money.errors.has('requesting_amount') ){
              this.invalid_requesting_amount();
            }
          }
          ,

          invalid_receiver_address_request(){
            StyleError( 'receiver_address_request', 'receiver_address_requestError' );
            ID( 'receiver_address_requestError' ).innerHTML = this.form_request_money.errors.errors.receiver_address_request;
          }
          ,

          invalid_requesting_amount( error_type ){
            StyleErrorIconLeft( 'requesting_amount', 'requesting_amountError' ); 
            ID( 'requesting_amountError' ).innerHTML = this.form_request_money.errors.errors.requesting_amount;
          }
          ,

        }
        ,

        computed:{

          
          

        }
    }
</script>
