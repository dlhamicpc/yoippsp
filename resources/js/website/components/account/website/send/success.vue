<template>


        <!-- Send Money Success Modal================================== -->
        <div id="send-money-success" class="modal fade" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Send Money</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>

                <div class="modal-body p-0">
                  <!-- Send Money Success============================================= -->
                  <div class="bg-light shadow-sm rounded p-4 p-sm-4">
                      <div class="text-center my-5">
                      <p class="text-center text-success text-20 line-height-07"><i class="fas fa-check-circle"></i></p>
                      <p class="text-center text-success text-8 line-height-07">Success!</p>
                      <p class="text-center text-4">Transactions Complete</p>
                      </div>
                      <p class="text-center text-3 mb-4">You've Succesfully sent 
                        <span class="text-4 font-weight-500">{{ form_send_money.sending_amount | money }}</span> 
                        to <span class="font-weight-500">{{ form_send_money.receiver_address }}</span>
                        , See transaction details under 
                        
                        <router-link to="/wa/transactions" data-dismiss="modal" onclick="closeSideBar();">
                          Transactions
                        </router-link>
                        .
                      </p>

                      <router-link to="" class="btn btn-primary btn-block" 
                        data-target="#send-money" 
                        data-toggle="modal"
                        data-dismiss="modal" 
                        onclick="closeSideBar();">
                          <span style="color:white;">Send Money Again</span>
                      </router-link>

                      <button class="btn btn-link btn-block"><i class="fas fa-print"></i> Print</button> 

                  </div> 
                </div>

              </div>
            </div>
          </div>


</template>

<script>
    export default {
        mounted() {
            //console.log('Send Success Component mounted.');
        }
        ,

        props:{
          form_send_money:{
            type: Object,
          }
        }
    }
</script>
