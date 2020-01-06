<template>


     <!-- Phone============================================= -->
     <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">
              Mobile Number 
              <a href="#edit-mobile-number" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link">
                <i class="fas fa-edit mr-1"></i>
                Edit</a>
            </h3>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">
                Mobile Number
              </p>
              <p class="col-sm-9"> {{ mobile_number }}</p>
            </div>

          </div>


</template>


<script>
    export default {
      mouted() {

      }
      ,
  
      created() {
        ECHO.$on('UPDATE_MOBILE_NUMBER', (data)=>{
          this.mobile_number = data.mobile_number;
        });
  
      }
      ,
  
      data() {
        return {
          mobile_number: this.user.mobile_number,
        }
      }
      ,
  
      methods: {
  
      }
  
    }
  </script>