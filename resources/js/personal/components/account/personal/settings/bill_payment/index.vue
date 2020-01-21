<template>
    
    
    <div class="row">

        <!-- Left Panel============================================= -->
        <aside class="col-lg-3">
        
                <dashboard-profile></dashboard-profile>
                <dashboard-balance></dashboard-balance>
                
        </aside>
        <!-- Left Panel End -->

        <!-- Middle Panel============================================= -->
        <div class="col-lg-9">
          
          <view-water-payment></view-water-payment>
          <edit-water-payment></edit-water-payment>

         

          <view-electricity-payment></view-electricity-payment>
          <edit-electricity-payment></edit-electricity-payment>

          <view-dstv-payment></view-dstv-payment>
          <edit-dstv-payment></edit-dstv-payment>
          
          
        </div>
        <!-- Middle Panel End --> 



    </div>

</template>

<script>


    export default {
        mounted() {
        },

        data(){
          return{
          }
        },

        methods:{
          
        }
    }
</script>
