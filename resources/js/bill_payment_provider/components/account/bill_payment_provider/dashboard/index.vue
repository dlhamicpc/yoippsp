<template>
    <div class="row">
        <!-- Left Panel============================================= -->
        <aside class="col-lg-3">
        
          <dashboard-profile></dashboard-profile>
          <dashboard-balance></dashboard-balance>
          <email-qrcode></email-qrcode>
          <print-qrcode></print-qrcode>
          <dashboard-need_help></dashboard-need_help>
          
        </aside>
        <!-- Left Panel End -->
        
        <!-- Middle Panel============================================= -->
        <div class="col-lg-9">

          <dashboard-profile_completeness></dashboard-profile_completeness>
          <dashboard-recent_activity></dashboard-recent_activity>

        </div>
        <!-- Middle Panel End -->

        <!-- Partial Modals============================================= -->


        <!-- Partial Modal End -->
    </div>
</template>

<script>
    export default {
        mounted() {
            //console.log('Dashboard Component mounted.');
        }
    }
</script>
