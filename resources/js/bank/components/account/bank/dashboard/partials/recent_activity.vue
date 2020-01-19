<template>
    <!-- Recent Activity=============================== -->
  <div>
          

            <div class="bg-light shadow-sm rounded py-4 mb-4" v-if="transactions.length">
              <h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">Recent Activity</h3>
              
              <!-- Title=============================== -->
              <div class="transaction-title py-2 px-4">
                <div class="row">
                  <div class="col-2 col-sm-1 text-center"><span class="">Date</span></div>
                  <div class="col col-sm-7">Description</div>
                  <div class="col-auto col-sm-2 d-none d-sm-block text-center">Status</div>
                  <div class="col-3 col-sm-2 text-right">Amount</div>
                </div>
              </div>
              <!-- Title End -->
              
              <transaction_list :transactionsData="transactions"></transaction_list>
              
              <transaction_modal></transaction_modal>
              
              
              
              <!-- View all Link=============================== -->
              <div class="text-center mt-4">
                <router-link to="/bank/transactions" class="btn-link text-3">View all
                  <i class="fas fa-chevron-right text-2 ml-2"></i>
                </router-link>
              </div>
              <!-- View all Link End -->
              
            </div>

            <div class="bg-light shadow-sm rounded py-4 mb-4" v-else>
                <h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">
                  No Recent Activity
                </h3>
            </div>
            <!-- Recent Activity End -->
  </div>
</template>

<script>
    export default {
        mounted() {
            //console.log('recent_activity Component mounted.')
        }
        ,

        created(){
          
          ECHO.$on('UPDATE_DATA', ( responseData) => {
            this.transactions = responseData.transactions.data;
          });

        }
        ,

        data() {
          return {
            transactions: this.transactions,
          }
        }
    }
</script>
