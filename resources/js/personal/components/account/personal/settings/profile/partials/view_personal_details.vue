<template>


     <!-- Personal Details============================================= -->
     <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">Personal Details <a href="#edit-personal-details" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
              <p class="col-sm-9">
                {{ full_name() | ucwords }}
              </p>
            </div>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
              <p class="col-sm-9">
                {{ userDetails.date_of_birth | birth_day }}
              </p>
            </div>

            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Address</p>
              <p class="col-sm-9">
                {{ userDetails.address }}
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
                return this.userDetails.name + " " + this.userDetails.father_name; 
            }

        },

        created(){
            ECHO.$on('UPDATE_PERSONAL_DETAILS',(data)=>{
                this.userDetails = data;
            });
        }
        ,

    }
</script>