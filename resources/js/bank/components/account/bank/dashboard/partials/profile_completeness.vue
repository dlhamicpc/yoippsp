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
              <div class="col-sm-6 col-md-6 mb-4 mb-md-0">
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
              <div class="col-sm-6 col-md-6 mb-4 mb-md-0">
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


           


            </div>
          </div>
          <!-- Profile Completeness End -->
</template>

<script>
    export default {
        mounted() {
          
        },

        data(){
            return {
                profileChecks:{
                    mobileNumberCheck: true,
                    emailCheck: true,
                   
                }
                
            }
        },

        methods: {

          percent() {
            let percentComplete = 100;

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
