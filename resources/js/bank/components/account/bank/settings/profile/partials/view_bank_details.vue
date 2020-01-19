<template>


     <!-- bank Provider Details============================================= -->
     <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">bank Details <a href="#edit-bank-details" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Administrator Name</p>
              <p class="col-sm-9">
                {{ full_name() | ucwords }}
              </p>
            </div>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Administrator Date of Birth</p>
              <p class="col-sm-9">
                {{ userDetails.admin_date_of_birth | birth_day }}
              </p>
            </div>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Bank Name</p>
              <p class="col-sm-9">
                {{ userDetails.bank_name }}
              </p>
            </div>

            <div class="row">
                <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Bank Headquarter</p>
                <p class="col-sm-9">
                  {{ userDetails.bank_headquarter_address }}
                </p>
              </div>

    </div>


</template>

<script>
    export default {
        mounted() {
            //console.log('Profile Component mounted.');
        },

        data(){
            return {
                userDetails: this.userDetails,
                
            }
        },

        methods: {
            full_name() {
                return this.userDetails.admin_name + " " + this.userDetails.admin_father_name; 
            }

        },

        created(){
            ECHO.$on('UPDATE_BANK_DETAILS',(data)=>{
                this.userDetails = data;
            });
        }
        ,

    }
</script>