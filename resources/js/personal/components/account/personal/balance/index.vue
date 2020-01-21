<template>



        <!-- Balance Modal================================== -->
          <div id="balance-wallet" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-0">
                <!-- Available Balance=============================== -->
                <div class="bg-light shadow-sm rounded text-center p-2 mb-0">
                      <div class="text-17 text-light my-3"><i class="fas fa-wallet"></i></div>
                      <h3 class="text-9 font-weight-400" id="balance_modal_value">
                      {{ balance | money }}</h3>
                      <p class="mb-2 text-muted opacity-8">Available Balance</p>
                      <hr class="mx-n3">
                      <div class="d-flex">

                          <router-link to=""  class="btn btn-primary mr-auto" data-target="#withdraw-money"  data-toggle="modal"  data-dismiss="modal">
                              <i class="fa fa-arrow-left nav-icon"></i>
                              Withdraw
                          </router-link>

                          <router-link to=""  class="btn btn-primary ml-auto" data-target="#deposit-money"  data-toggle="modal"  data-dismiss="modal" >
                              Deposit
                              <i class="fa fa-arrow-right nav-icon"></i>
                          </router-link>

                      </div>
                    </div>
                <!-- Available Balance End -->

                </div>
              </div>
            </div>
          </div>


</template>

<script>
    export default {
        created() {
          ECHO.$on('UPDATE_DATA', ( responseData) => {
            this.balance = responseData.balance;
          });


        }
        ,

        data() {
          return {
            balance: this.userDetails.balance,
          }
        }
    }
</script>
