<template>
    
    
    <div class="row">

        <!-- Left Panel============================================= -->
        <aside class="col-lg-3">
        
                <dashboard-profile></dashboard-profile>
                <dashboard-balance></dashboard-balance>
                <dashboard-need_help></dashboard-need_help>
                
        </aside>
        <!-- Left Panel End -->

        <!-- Middle Panel============================================= -->
        <div class="col-lg-9">
          
          <view-website-details></view-website-details>
          <edit-website-details></edit-website-details>

          <view-account-settings></view-account-settings>
          <edit-account-settings></edit-account-settings>

          <view-email></view-email>
          <edit-email></edit-email>

          <view-mobile-number></view-mobile-number>
          <edit-mobile-number></edit-mobile-number>

          <view-password></view-password>
          <edit-password></edit-password>
          
          
        </div>
        <!-- Middle Panel End --> 



    </div>

</template>

<script>


    export default {
        mounted() {
            //ECHO.$emit('START_BIRTH_DATE');
        },

        data(){
          return{
            countryCode:{"Ethiopia": "+251",},
          }
        },

        methods:{
          format_mobile_number( mobile_number ){

          }
        }
    }
</script>
