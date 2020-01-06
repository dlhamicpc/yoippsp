<template>
    <div>
        <!-- API Modal================================== -->
          <div id="api-key" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">API Configuration</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <!-- API Form============================================= -->

                    <div class="form-group">
                        <label for="private_key">Private Key</label>
                        <textarea v-text="api.private_key" class="form-control" id="private_key" disabled></textarea>
                    </div>

                    <div class="form-group">
                        <label for="public_key">Public Key</label>
                        <textarea v-text="api.public_key" class="form-control" id="public_key" disabled></textarea>
                    </div>
                    <form id="form_api_key" @submit.prevent="">
                    
                      <div class="form-group">
                        <label for="webhook_url">Webhook Url</label>

                        <input type="text" 
                                value=""
                                v-model="form_api_key.webhook_url" 
                                class="form-control" 
                                :class="{'is-invalid': form_api_key.errors.has('webhook_url')}"
                                id="webhook_url"
                                name="webhook_url" 
                                required="" 
                                placeholder="Webhook Url"
                                @blur="validate_data()"
                                @input="validate_data()"
                                onblur=" validate( event, 'required|url') "
                                oninput=" validate( event, 'required|url') ">

                                <div class="form-control" id="webhook_urlError" style="display: none;"></div>
                      </div>


                      <div class="form-group">
                        <label for="callback_url">Callback Url</label>

                        <input type="text" 
                                value=""
                                v-model="form_api_key.callback_url" 
                                class="form-control" 
                                :class="{'is-invalid': form_api_key.errors.has('callback_url')}"
                                id="callback_url"
                                name="callback_url" 
                                required="" 
                                placeholder="Callback Url"
                                @blur="validate_data()"
                                @input="validate_data()"
                                onblur=" validate( event, 'required|url') "
                                oninput=" validate( event, 'required|url') ">

                                <div class="form-control" id="callback_urlError" style="display: none;"></div>
                      </div>

                     

                      <hr>


                      <button class="btn btn-primary btn-block"
                            @click="api_key()"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Save Changes
                      </button>

                    </form>

            <!-- API Form end --> 
                </div>
              </div>
            </div>
          </div>
          
  </div>

</template>

<script>
    export default {
        mounted() {
            //console.log('request Component mounted.');
            ECHO.$emit('UPDATE_API', (data)=>{
                this.form_api_key.webhook_url = data.userDetails.webhook_url;
                this.form_api_key.callback_url = data.userDetails.callback_url;
                this.api.private_key = data.api.private_key;
                this.api.public_key = data.api.public_key;
            });
        }
        ,

        created(){

        }
        ,

        data(){
          return{
            form_api_key: new Form({
                  webhook_url: userDetails.webhook_url,
                  callback_url: userDetails.callback_url,
            }),

            api:{
                private_key: api.private_key,
                public_key: api.public_key,
            },

            isInvalid: true,

          }
        }
        ,
        
        methods:{

          validate_data(){
            let form_api_key = document.forms["form_api_key"];
            
            for( let index = 0; index < form_api_key.length - 1; index++ ){

                let input = form_api_key.elements[ index ];
                
                if( input.value.trim() == "" ){
                  this.isInvalid = true;
                  return;
                }
                else if( document.getElementById(input.id+"Error").style.display == 'block' ){      
                  this.isInvalid = true;
                  return;
                }
                else if( this.form_api_key.busy ){
                  this.isInvalid = true;
                  return;
                }
                   
            }
            
            this.isInvalid = false;
            
            
          }
          ,

          
          api_key(){
            
            this.validate_data();

            ECHO.$emit('START_LOADING');
            
            this.form_api_key.patch('api/update_api_key')
              .then(( response )=>{
                
                let data = response.data;

                if( data == 'failed' ){
                  
                  //ALERT ERROR HAPPENED
                  console.log('ALERT ERROR HAPPENED');
                  some_thing_went_wrong.fire();
                  alert('ALERT ERROR HAPPENED C1');

                  ECHO.$emit('END_LOADING');
                }
                else{
                  swal.fire({
                    title:'Success',
                    text:"You have Successfully saved your API configuration.",
                    type:'success'
                  });
                  
                  ECHO.$emit('UPDATE_API', data);
                  console.log(data);
                  Vue.prototype.api = data.api;
                  Vue.prototype.userDetails = data.userDetails;

                  $('#api-key').modal('hide');

                  ECHO.$emit('END_LOADING');
                }
                

              })
              .catch((error)=>{
                //ALERT ERROR HAPPENED
                some_thing_went_wrong.fire();
                if ( this.form_api_key.errors.any() ) {
                  this.show_error_to_request_modal();
                }
                else{
                  some_thing_went_wrong.fire();
                }
                
                ECHO.$emit('END_LOADING');
            });

          }
          ,



          show_error_to_request_modal( ){
            if( this.form_api_key.errors.has('webhook_url') ){
              this.invalid_webhook_url();
            }

            if( this.form_api_key.errors.has('callback_url') ){
              this.invalid_callback_url();
            }
          }
          ,

          invalid_webhook_url(){
            StyleError( 'webhook_url', 'webhook_urlError' );
            ID( 'webhook_urlError' ).innerHTML = this.form_api_key.errors.errors.webhook_url;
          }
          ,

          invalid_callback_url( error_type ){
            StyleError( 'callback_url', 'callback_urlError' ); 
            ID( 'callback_urlError' ).innerHTML = this.form_api_key.errors.errors.callback_url;
          }
          ,

        }
        ,

        computed:{

          
          

        }
    }
</script>
