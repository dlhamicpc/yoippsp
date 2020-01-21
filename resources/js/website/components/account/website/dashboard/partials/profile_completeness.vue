<template>
          <!-- Profile Completeness =============================== -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">

            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-3">
              Profile Completeness 
              <span class="bg-light-4 text-success rounded px-2 py-1 font-weight-400 text-2 ml-2">
                {{ percent() }}%
              </span>
            </h3>

            <div class="row profile-completeness">
              <div class="col-sm-6 col-md-3 mb-4 mb-md-0">
                <div class="border rounded p-3 text-center"> 

                  <span class="d-block text-10 text-light mt-2 mb-3">
                    <i class="fas fa-mobile-alt"></i>
                  </span> 

                  <span class="text-5 d-block text-success mt-4 mb-3">
                    <i class="fas fa-check-circle"></i>
                  </span>
                  <p class="mb-0">Mobile Added</p>

                </div>
              </div>
              <div class="col-sm-6 col-md-3 mb-4 mb-md-0">
                <div class="border rounded p-3 text-center">

                  <span class="d-block text-10 text-light mt-2 mb-3">
                    <i class="fas fa-envelope"></i>
                  </span> 

                  <span class="text-5 d-block text-success mt-4 mb-3">
                    <i class="fas fa-check-circle"></i>
                  </span>
                  <p class="mb-0">Email Added</p>

                </div>
              </div>
              <div class="col-sm-6 col-md-3 mb-4 mb-sm-0">
                <div class="border rounded p-3 text-center"> 

                  <span class="d-block text-10 text-light mt-2 mb-3">
                    <i class="fas fa-credit-card"></i>
                  </span> 

                  <span class="text-5 d-block mt-4 mb-3" :class="checkCssTick( profileChecks.userCardLinksCheck )">
                    <i  :class="checkCssCircle( profileChecks.userCardLinksCheck )"></i>
                  </span>

                  <p class="mb-0" v-if="profileChecks.userCardLinksCheck">Card Added</p>

                  <p class="mb-0" v-else-if="!profileChecks.userCardLinksCheck">
                    <router-link to="/wa/card" class="btn-link stretched-link" href="">Add Card</router-link>
                  </p>

                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="border rounded p-3 text-center"> 
                  
                  <span class="d-block text-10 text-light mt-2 mb-3">
                    <i class="fas fa-university"></i>
                  </span> 
                  
                  <span class="text-5 d-block mt-4 mb-3" :class="checkCssTick( profileChecks.userBankLinksCheck )">
                      <i  :class="checkCssCircle( profileChecks.userBankLinksCheck )"></i>
                  </span>

                  <p class="mb-0" v-if="profileChecks.userBankLinksCheck">Bank Account Added</p>

                  <p class="mb-0" v-else-if="!profileChecks.userBankLinksCheck">
                      <router-link to="/wa/card" class="btn-link stretched-link" href="">Add Bank Account</router-link>
                  </p>

                </div>
              </div>
            </div>
          </div>
          <!-- Profile Completeness End -->
</template>

<script>
    export default {
        mounted() {
            //console.log('Profile Completness Component mounted.')
            //console.log(Object.keys(userCardLinks).length);
        },

        data(){
            return {
                profileChecks:{
                    mobileNumberCheck: true,
                    emailCheck: true,
                    userCardLinksCheck: Boolean( Object.keys(userCardLinks).length ),
                    userBankLinksCheck: Boolean( Object.keys(userBankLinks).length ),
                }
                
            }
        },

        methods: {

          percent() {
            let percentComplete = 50;
            
            if ( this.profileChecks.userBankLinksCheck ) percentComplete += 25;
            if ( this.profileChecks.userCardLinksCheck ) percentComplete += 25;

            return percentComplete;
          },

          checkCssCircle( boolean ) {

            if ( boolean ) return 'fas fa-check-circle';
            return 'far fa-circle';
          },

          checkCssTick( boolean ) {

            if ( boolean ) return 'text-success';
            return 'text-light';

          }

        },


    }
</script>
