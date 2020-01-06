<template>
        <!-- Available Balance=============================== -->
          <div class="bg-light shadow-sm rounded text-center p-3 mb-4">
            <div class="text-17 text-light my-3"><i class="fas fa-wallet"></i></div>
            <h3 class="text-9 font-weight-400">{{ balance | money }}</h3>
            <p class="mb-2 text-muted opacity-8">Available Balance</p>
            <hr class="mx-n3">

            <div class="d-flex">

                <router-link to="" data-target="#withdraw-money"  data-toggle="modal" onclick="closeSideBar();" class="btn-link mr-auto">
                    Withdraw
                </router-link> 

                <router-link to="" data-target="#deposit-money"  data-toggle="modal" onclick="closeSideBar();" class="btn-link ml-auto">
                    Deposit
                </router-link>

            </div>
          </div>
          <!-- Available Balance End -->
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
