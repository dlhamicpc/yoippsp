<template>
        <!-- Email Qrcode=============================== -->
          <div class="bg-light shadow-sm rounded text-center mb-4">

            <img class="img-fluid" 
                :src="'/storage/qrcodes/email/' + user.id + '.png'" 
                alt="Email Qrcode"
                style="margin-bottom: 0px;">
            <p class="btn btn-block btn-outline-primary btn-flat" 
            style="margin-top: -5px;">Qrcode</p>

          </div>
          <!-- Email Qrcode End -->
</template>

<script>
    export default {
        created() {
          
        
        }
        ,

        data() {
          return {
            
          }
        }
    }
</script>
