<template>


     <!-- Edit Details Modal================================== -->
     <div id="edit-account-settings" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Account Settings</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>

                <div class="modal-body p-4">
                  <form id="form_edit_settings_language_time_zone" method="post" @submit.prevent="">

                    <div class="row">

                      <div class="col-12">
                        <div class="form-group">
                          <label for="language">Language</label>
                          <select class="custom-select" 
                                  id="language" 
                                  name="language"
                                  v-model="form_edit_settings_language_time_zone.language"
                                  onblur=" validate(event, 'required') "
                                  oninput=" validate(event, 'required') "
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  required>
                            <option value="" disabled>Select Language</option>

                            <option  v-for="language in languages" 
                                    v-text="language.name" 
                                    :key="language.name"
                                    :value="language.name">
                            </option>

                          </select>
                          <div class="form-control" id="languageError" style="display: none;"></div>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="time_zone">Time Zone</label>
                          <select class="custom-select" 
                                  id="time_zone" 
                                  name="time_zone"
                                  v-model="form_edit_settings_language_time_zone.time_zone"
                                  onblur=" validate(event, 'required') "
                                  oninput=" validate(event, 'required') "
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  required>
                            <option value="">Select Time zone</option>

                            <option  v-for="time_zone in time_zones" 
                                    v-text="time_zone.name" 
                                    :key="time_zone.name"
                                    :value="time_zone.name">
                            </option>

                          </select>

                          <div class="form-control" id="time_zoneError" style="display: none;"></div>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="account_status">Account Status</label>
                          <select class="custom-select" 
                                  id="account_status" 
                                  name="account_status"
                                  v-model="form_edit_settings_language_time_zone.account_status"
                                  onblur=" validate(event, 'required|string') "
                                  oninput=" validate(event, 'required|string') "
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  required>
                            <option value="active" selected>Active</option>
                            <option value="delete">In Active (Delete Account)</option>
                          </select>
                          <div class="form-control" id="account_statusError" style="display: none;"></div>
                        </div>
                      </div>

                    </div>

                    <button class="btn btn-primary btn-block"
                    @click="confirm_balance_to_delete_account"
                    :class="{'btn btn-secondary btn-block': isInvalid}"
                    :disabled="isInvalid">
                    Save Changes
                    </button>

                  </form>

                </div>

              </div>
            </div>
          </div>
          <!-- Account Settings End -->


</template>


<script>
    export default {
        mounted() {
          this.load_languages();
          this.load_time_zones();

          ECHO.$on('UPDATE_LANGUAGE_TIME_ZONE', (data)=>{
            this.userDetails = data;
          });

        },


        data(){
            return{
              form_edit_settings_language_time_zone: new Form({
                    language: this.settings.language,
                    time_zone: this.settings.time_zone,
                    account_status: 'active',
                }),

                isInvalid: false,
                languages: null,
                time_zones: null,

            }
        }
        ,


        methods: {

          load_languages(){
               ECHO.$emit('START_LOADING');

               axios.get("api/get_languages")
                    .then(({data}) => (
                       this.languages = data
                     ));

               ECHO.$emit('END_LOADING');

             }//END of load_languages
             ,

             load_time_zones(){
               ECHO.$emit('START_LOADING');

               axios.get("api/get_time_zones")
                    .then(({data}) => (
                       this.time_zones = data
                     ));

               ECHO.$emit('END_LOADING');

             }//END of load_time_zones
             ,
          
            validate_data(){
                let form_edit_settings_language_time_zone = document.forms["form_edit_settings_language_time_zone"];

                for( let index = 0; index < form_edit_settings_language_time_zone.length - 1; index++ ){

                    let input = form_edit_settings_language_time_zone.elements[ index ];

                    if( input.value.trim() == "" ){
                        input.blur();
                        this.isInvalid = true;
                        return;
                    }
                    else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                        this.isInvalid = true;
                        return;
                    }
                    else if( this.form_edit_settings_language_time_zone.busy ){
                        this.isInvalid = true;
                        return;
                    }

                }

                this.isInvalid = false;


            }
            ,

            update_settings_language_time_zone(){

                this.validate_data();
                ECHO.$emit('START_LOADING');

                this.form_edit_settings_language_time_zone.put('api/update_languages_time_zone')
                    .then(( response )=>{

                        let data = response.data;

                        if( data == 'failed' ){
                          //ALERT ERROR HAPPENED
                          console.log('ALERT ERROR HAPPENED C1');
                          this.show_error_to_update_modal();
                          some_thing_went_wrong.fire();
                          ECHO.$emit('END_LOADING');
                            
                        }
                        else{
                          
                          data.settings = JSON.parse( data.settings );

                          ECHO.$emit('UPDATE_LANGUAGE_TIME_ZONE', data.settings);
                          Vue.prototype.userDetails = data;
                          Vue.prototype.settings = data.settings;
                          
                          $('#edit-account-settings').modal('hide');
                          toast.fire({
                                type: 'success',
                                title: 'Settings Updated Successfully'

                            });
                         ECHO.$emit('END_LOADING'); 
                        }


                    })
                    .catch((error)=>{
                        //ALERT ERROR HAPPENED
                        ECHO.$emit('END_LOADING');
                        if( error.message.search(403) != -1) {
                          //user deleted
                          swal.fire({
                              title: 'Come visit us again',
                              type: 'info',
                              confirmButtonColor: '#3085d6',
                              confirmButtonText: 'Good Bye',
                          }).then((result) => {
                            window.location.assign('http://account.yoippsp.com/login');
                          });
                        }
                        else{
                          this.show_error_to_update_modal();
                        }
                          
                    });

            }
            ,


            invalid_language( ){
                StyleError( 'language', 'languageError' );
                ID( 'languageError' ).innerHTML = this.form_edit_settings_language_time_zone.errors.errors.language;
            }
            ,

            invalid_time_zone( ){
                StyleError( 'time_zone', 'time_zoneError' );
                ID( 'time_zoneError' ).innerHTML = this.form_edit_settings_language_time_zone.errors.errors.time_zone;
            }
            ,

            invalid_account_status( ){
                StyleError( 'account_status', 'account_statusError' );
                ID( 'account_statusError' ).innerHTML = this.form_edit_settings_language_time_zone.errors.errors.account_status;
            }
            ,

            show_error_to_update_modal( ){

                if ( this.form_edit_settings_language_time_zone.errors.any() ){

                    if( this.form_edit_settings_language_time_zone.errors.has('language') ){
                        this.invalid_language();
                    }

                    if( this.form_edit_settings_language_time_zone.errors.has('time_zone') ){
                        this.invalid_time_zone();
                    }

                    if( this.form_edit_settings_language_time_zone.errors.has('account_status') ){
                        this.invalid_account_status();
                    }

                    
                }

            }
            ,

            
            confirm_balance_to_delete_account( ) {

                if( this.form_edit_settings_language_time_zone.account_status == 'delete' ){


                    let text= null;
                    let confirmButtonText = null;
                    let withdraw_or_delete = 'withdraw';

                    let balance = userDetails.balance;

                    if( balance > 0  ){
                      text = 'Your wallet contains ' + balance + ' birr, first you need to withdraw all your money then you can delete your account!';

                      confirmButtonText = 'Yes, withdraw!'; 
                    }
                    else{
                    withdraw_or_delete = 'delete';
                    text = "You Yoippsp account will be deleted and you won't be able to revert this!"
                    confirmButtonText = "Yes, delete my account";
                    
                    } 



                    swal.fire({
                        title: 'Are you sure?',
                        text: text,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: confirmButtonText,
                    }).then((result) => {
                      
                      if ( result.dismiss == 'cancel' ){
                        return;
                      }
                      else{
                        if( withdraw_or_delete === 'withdraw' ){
                          $('#withdraw-money').modal('show');
                        }
                        else{
                          this.update_settings_language_time_zone();
                        }
                      }
                      
                    });

                }
                else{
                  this.update_settings_language_time_zone();
                }
            }
            ,
        }
        ,


        created() {

        },


    }
</script>