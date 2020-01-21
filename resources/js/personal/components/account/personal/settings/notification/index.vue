<template>


          
    <div class="row">
        <div class="col-lg-12">
          <!-- Pills Navigation Style============================================= -->


          <ul class="nav nav-pills" id="pillsmyTab" role="tablist">

            <li class="nav-item"> 
              <a class="nav-link active btn-lg" 
                  id="notifications_button" 
                  data-toggle="tab" 
                  href="#notifications" 
                  role="tab" 
                  aria-controls="notifications" 
                  aria-selected="true">
                  <i class="fas fa-bell"></i>
                Notifications
              </a> 
            </li>

            <li class="nav-item"> 
              <a class="nav-link btn-lg" 
                id="securities_button" 
                data-toggle="tab" 
                href="#securities" 
                role="tab" 
                aria-controls="securities" 
                aria-selected="false">
                <i class="fas fa-key"></i>
              Security
              </a> 
            </li>

          </ul>


          <div class="tab-content my-3" id="pillsmyTabContent">

            <div class="tab-pane fade active show bg-light shadow-sm rounded p-4 mb-4" id="notifications" role="tabpanel" aria-labelledby="notifications_button">
              
              <h3 class="text-5 font-weight-400">Notifications</h3>
              <p class="text-muted">Select notifications to be delivered to <span class="text-body">{{ email }}</span></p>
              <hr class="mx-n4">

              <form id="notifications_form" method="post" @submit.prevent="">

                <div class="form-check custom-control custom-checkbox">
                  <input id="announcements" 
                        name="announcements" 
                        class="custom-control-input" 
                        type="checkbox" 
                        checked="" 
                        v-model="notifications.announcements">

                  <label class="custom-control-label text-3" for="announcements">Announcements</label>
                  <p class="text-muted line-height-3 mt-2">Be the first to know about new features and other news.</p>
                </div>

                <hr class="mx-n4">

                <div class="form-check custom-control custom-checkbox">
                  <input id="send_payment" 
                        name="send_payment" 
                        class="custom-control-input" 
                        type="checkbox"
                        checked="" 
                        v-model="notifications.send_payment">

                  <label class="custom-control-label text-3" for="send_payment">Send payment</label>
                  <p class="text-muted line-height-3 mt-2">Send an email when I send a payment.</p>
                </div>

                <hr class="mx-n4">

                <div class="form-check custom-control custom-checkbox">
                  <input id="receive_payment" 
                          name="receive_payment" 
                          class="custom-control-input" 
                          type="checkbox"
                          checked="" 
                          v-model="notifications.receive_payment">

                  <label class="custom-control-label text-3" for="receive_payment">Receive a payment</label>
                  <p class="text-muted line-height-3 mt-2">Send me an email when I receive a payment.</p>
                </div>

                <hr class="mx-n4">

                <div class="form-check custom-control custom-checkbox">
                  <input id="service_payment" 
                        name="service_payment" 
                        class="custom-control-input" 
                        type="checkbox"
                        checked="" 
                        v-model="notifications.service_payment">

                  <label class="custom-control-label text-3" for="service_payment">Service Payment</label>
                  <p class="text-muted line-height-3 mt-2">Send me an email when i use service provider.</p>
                </div>

                <hr class="mx-n4">

                <div class="form-check custom-control custom-checkbox">
                  <input id="have_a_problem_with_payment" 
                          name="have_a_problem_with_payment" 
                          class="custom-control-input" 
                          type="checkbox"
                          checked="" 
                          v-model="notifications.have_a_problem_with_payment">

                  <label class="custom-control-label text-3" for="have_a_problem_with_payment">Have a problem with a payment</label>
                  <p class="text-muted line-height-3 mt-2">Send me an email when i have a problem with a payment.</p>
                </div>

                <hr class="mx-n4">

                <div class="form-check custom-control custom-checkbox">
                  <input id="special_offers" 
                        name="special_offers" 
                        class="custom-control-input" 
                        type="checkbox"
                        checked="" 
                        v-model="notifications.special_offers">

                  <label class="custom-control-label text-3" for="special_offers">Special Offers</label>
                  <p class="text-muted line-height-3 mt-2">Receive last-minute offers from us.</p>
                </div>

                <hr class="mx-n4">

                <div class="form-check custom-control custom-checkbox">
                  <input id="new_events" 
                        name="new_events" 
                        class="custom-control-input" 
                        type="checkbox"
                        checked="" 
                        v-model="notifications.new_events">

                  <label class="custom-control-label text-3" for="new_events">New Events</label>
                  <p class="text-muted line-height-3 mt-2">Send me an email when there is a new event.</p>
                </div>

                <hr class="mx-n4">

                <div class="form-check custom-control custom-checkbox">
                    <input id="bill_payment_period_reached" 
                          name="bill_payment_period_reached" 
                          class="custom-control-input" 
                          type="checkbox"
                          checked="" 
                          v-model="notifications.bill_payment_period_reached">

                    <label class="custom-control-label text-3" for="bill_payment_period_reached">
                        Bill Payment Period Reached
                    </label>
                    <p class="text-muted line-height-3 mt-2">Send me an email when bill payment period reaches.</p>
                </div>
  
                <hr class="mx-n4">

                <button class="btn btn-primary mt-1" type="submit" 
                @click="update_notification_security_settings( 'notification' )">Save Changes</button>
                
              </form>

            </div>
            <!--END OF NOTIFICATION TAB-->

            <div class="tab-pane fade show bg-light shadow-sm rounded p-4 mb-4" id="securities" role="tabpanel" aria-labelledby="securities_button">
              
                <h3 class="text-5 font-weight-400">Security</h3>
                
                <hr class="mx-n4">
  
                <form id="securities_form" method="post" @submit.prevent="">
  
                  <div class="form-check custom-control custom-checkbox">
                    <input id="when_login_in" 
                          name="when_login_in" 
                          class="custom-control-input" 
                          type="checkbox"
                          checked="" 
                          v-model="securities.when_login_in">

                    <label class="custom-control-label text-3" for="when_login_in">When Login In</label>
                    <p class="text-muted line-height-3 mt-2">Send me an email when every time i login.</p>
                  </div>
  
                  <hr class="mx-n4">
  
                  <div class="form-check custom-control custom-checkbox">
                    <input id="logged_in_with_different_device" 
                          name="logged_in_with_different_device" 
                          class="custom-control-input" 
                          type="checkbox"
                          checked="" 
                          v-model="securities.logged_in_with_different_device">

                    <label class="custom-control-label text-3" for="logged_in_with_different_device">
                        Logged In With Different Device
                    </label>
                    <p class="text-muted line-height-3 mt-2">Send me an email when i login using different device.</p>
                  </div>
  
                  <hr class="mx-n4">
  

  
                  <div class="form-check custom-control custom-checkbox">
                    <input id="two_step_verification" 
                          name="two_step_verification" 
                          class="custom-control-input" 
                          type="checkbox"
                          checked="" 
                          v-model="securities.two_step_verification">

                    <label class="custom-control-label text-3" for="two_step_verification">Two Step Verification</label>
                    <p class="text-muted line-height-3 mt-2">Enable two step verification.</p>
                  </div>
  
                  <hr class="mx-n4">
  
                  <button class="btn btn-primary mt-1" type="submit" 
                  @click="update_notification_security_settings('security')">Save Changes</button>
                  
                </form>
  
              </div>


              <!--END OF SECURITIES TAB-->

          </div>

          <!-- Pills Navigation Style end -->

        </div>

</div>


</template>

<script>
    export default {
        mounted() {
            //console.log('Notification Component mounted.')
            ECHO.$emit('START_TAB_MANAGER');

            ECHO.$on('UPDATE_EMAIL', (data)=>{
                this.email = data.email;
            });

            ECHO.$on('UPDATE_SETTINGS', (data)=>{
              let settings = JSON.parse( data.settings );
              this.notifications = new Form(settings.notifications);
              this.securities = new Form(settings.securities);
            });
        }
        ,

        created(){

        }
        ,

        data(){
          return{

            notifications: new Form({
              announcements: settings.notifications.announcements,
              send_payment: settings.notifications.send_payment,
              receive_payment: settings.notifications.receive_payment,
              have_a_problem_with_payment: settings.notifications.have_a_problem_with_payment,
              service_payment: settings.notifications.service_payment,
              special_offers: settings.notifications.special_offers,
              new_events: settings.notifications.new_events,
              bill_payment_period_reached: settings.notifications.bill_payment_period_reached,
            }),

            securities: new Form({
              when_login_in: settings.securities.when_login_in,
              logged_in_with_different_device: settings.securities.logged_in_with_different_device,
              two_step_verification: settings.securities.two_step_verification,
            }),

            email: this.user.email,

          }
        }
        ,

        methods: {
          update_notification_security_settings( type ){

            ECHO.$emit('START_LOADING');

            let update_type = null;
            let title = null;
            let url = null;

            if( type == 'notification' ) {
              update_type = this.notifications
              title = 'Notification Setting Updated Successfully';
              url = 'update_notification_settings';
            }
            else{
              update_type = this.securities;
              title = 'Security Setting Updated Successfully';
              url = 'update_security_settings';
            }

            update_type.put('api/'+url)
                .then(( response )=>{

                    let data = response.data;

                    if( data == 'failed' ){
                      //ALERT ERROR HAPPENED
                      console.log('ALERT ERROR HAPPENED C1');

                      some_thing_went_wrong.fire();

                      ECHO.$emit('END_LOADING');
                        
                    }
                    else{
                      ECHO.$emit('UPDATE_SETTINGS', data);
                      Vue.prototype.settings = JSON.parse( data.settings );

                      toast.fire({
                            type: 'success',
                            title: title,

                        });
                    ECHO.$emit('END_LOADING'); 
                    }


                })
                .catch((error)=>{
                    //ALERT ERROR HAPPENED
                    console.log('ALERT ERROR HAPPENED C2' + error);
                    some_thing_went_wrong.fire();
                    ECHO.$emit('END_LOADING');
                });

          }
          ,
        }
        ,

    }
</script>



