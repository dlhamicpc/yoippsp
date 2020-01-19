<template>
    <div class="row">

        <!-- Middle Panel============================================= -->
        <div class="col-lg-12">
          

            <div class="bg-light shadow-sm rounded py-4 mb-4">
          
                <div v-if="notification.notificationCount">

                    <span class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">
                            
                            <i class="far fa-bell text-8 font-weight-400"></i>
                            <span class="badge badge-warning mr-2 mb-4">{{ notification.notificationCount }}</span> New Notifications
                    </span>

                    <div  v-for="notification in notification.notificationMessages" :key="notification.id">
                            <div class="dropdown-divider"></div>
                            
                            <router-link to="" class="dropdown-item  row flex-row" style="margin-top: -10px;margin-bottom: -8px">
                              <!-- Message Start -->
                              <div class="media">
                                <span v-html="image_or_icon(notification.image, notification.sender_id)"></span>
                                
                                <div class="media-body">
                                  <h3 class="dropdown-item-title">
                                    {{ notification.sender_name }}
                                  </h3>

                                  <p class="text-sm">{{ notification.message }}</p>

                                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ notification.created_at | from_now }}</p>
                                </div>
                              </div>
                              <!-- Message End -->
                            </router-link>
                  
                            </div>
                            
                            
                  
                            <div class="dropdown-divider"></div>
            
                            <!-- Pagination============================================= -->
                            <ul class="pagination justify-content-center mt-4 mb-0">
                                <pagination :data="notificationMessagesPaginated" 
                                            :limit="1"
                                            :size="'default'" 
                                            @pagination-change-page="pagination" 
                                            @click="">
                                </pagination>
                            </ul>
                            <!-- Paginations end --> 

                </div>
                
      
                <div  v-else class=" bg-white rounded p-4 text-center featured-box style-4 py-2">
                    <div class="featured-box-icon text-light border rounded-circle shadow-none">
                        <span class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">
                                <i class="far fa-bell-slash"></i>
                        </span>
                    </div>
                    No new Notifications yet
                </div>
      


              </div>


        </div>
        <!-- Middle End --> 

    </div>
</template>

<script>

    export default {

        created(){
          this.load_notification();
          ECHO.$on('UPDATE_DATA', (data) =>{
            this.notification.notificationMessages.unshift(...data.notificationMessagesPaginated.data);
            this.notification.notificationCount = this.notification.notificationMessages.length;
          });
          
        },

        mounted() {
            
        }
        ,

   

        data(){
          return {
                notification: {
                    notificationCount: 0,
                    notificationMessages: [],
                }
                ,
                notificationMessagesPaginated:{},
          }
        },

        methods: {

          pagination(page = 1){
            ECHO.$emit('START_LOADING');

            axios.get('api/fetch_notification_and_notify_online?page=' + page)
                 .then(response => {
                    this.notificationMessagesPaginated = response.data.notificationMessagesPaginated;
                    this.notification.notificationMessages = response.data.notificationMessagesPaginated.data;
            });
            
            ECHO.$emit('END_LOADING');
          }//END of pagination()
          ,

          load_notification() {

            axios.get("api/fetch_notification_and_notify_online")
					.then(( response ) => {

						let data = response.data;

						if( data == 0 ){
							this.notification.notificationMessages = [];
							this.notification.notificationCount = 0;
						}
						else{
							//UPDATE BALANCE AND TRANSACTION
							ECHO.$emit('UPDATE_DATA', data);
							Vue.prototype.userDetails = data.userDetails;
							Vue.prototype.userDetails.balance = data.balance;
                            Vue.prototype.transactions = data.transactions.data;

              this.notificationMessagesPaginated =  data.notificationMessagesPaginated;
							this.notification.notificationMessages = data.notificationMessagesPaginated.data;
							this.notification.notificationCount = data.notificationCount;
							
                        }
                        ECHO.$emit('END_LOADING');
						
					})
					.catch((error)=>{
						//ALERT ERROR HAPPENED
                        console.log('Notification Error C7');
                        console.log(error);
						ECHO.$emit('END_LOADING');
					});

          }
          ,

          image_or_icon(image, sender_id){
            let image_json = JSON.parse(image);

            if( image_json.type == 'picture'){
                let image_temp = "<img src='"+image_json.src+sender_id+".png' alt='User Avatar' class='img-size-50 mr-3 mt-2 img-circle'>";
                return image_temp;
            }
            else{
                let image_temp = "<i class='"+image_json.src+"'></i>";
                return image_temp; 
            }
        }
        ,




      }


    }
</script>
