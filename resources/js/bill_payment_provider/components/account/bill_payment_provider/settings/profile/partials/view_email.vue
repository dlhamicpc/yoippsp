<template>


     <!-- Email Addresses============================================= -->
     <div class="bg-light shadow-sm rounded p-4 mb-4">

            <h3 class="text-5 font-weight-400 mb-3">
              Email Addresses 
              <a href="#edit-email" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link">
                <i class="fas fa-edit mr-1"></i>
                Edit</a>
            </h3>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">
                Email Address
              </p>
              <p class="col-sm-9">{{ email }}</p>
            </div>

          </div>


</template>



<script>
    export default {
      mouted() {

      }
      ,
  
      created() {
        ECHO.$on('UPDATE_EMAIL', (data)=>{
          this.email = data.email;
        });
  
      }
      ,
  
      data() {
        return {
          email: this.user.email,
        }
      }
      ,
  
      methods: {
  
      }
  
    }
  </script>