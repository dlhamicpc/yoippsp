<template>


    <!-- Account Settings============================================= -->
    <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">Account Settings <a href="#edit-account-settings" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Language</p>
              <p class="col-sm-9">{{ language }}</p>
            </div>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Time Zone</p>
              <p class="col-sm-9">{{ time_zone }}</p>
            </div>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Account Status</p>
              <p class="col-sm-9"><span class="bg-success text-white rounded-pill d-inline-block px-2 mb-0"><i class="fas fa-check-circle"></i> Active</span></p>
            </div>
          </div>



</template>


<script>
  export default {
    mouted() {

    }
    ,

    created() {
      ECHO.$on('UPDATE_LANGUAGE_TIME_ZONE', (data)=>{
        this.language = data.language;
        this.time_zone = data.time_zone;
      });

    }
    ,

    data() {
      return {
        language: this.settings.language,
        time_zone: this.settings.time_zone,
      }
    }
    ,

    methods: {

    }

  }
</script>