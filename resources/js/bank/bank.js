require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);
Vue.component('pagination', require('laravel-vue-pagination'));

import { Form ,HasError, AlertError} from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar,{
	color: 'rgb(0, 100, 200)',
	failedColor: 'red',
	height: '300px',
	class: 'progress-bar bg-primary progress-bar-striped',
  	thickness: '5px',
  	transition: {
    	speed: '0.2s',
    	opacity: '0.0s',
    	termination: 300
  	},
  	autoRevert: true,
  	location: 'top',
  	inverse: false
});


import swal from 'sweetalert2';
window.swal = swal;

const toast = swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});

const some_thing_went_wrong = swal.mixin({
	title:'Failed!!',
	text:"There was something wrong, try again!",
	type:'warning',
	confirmButtonText: 'Try Again ?'
});

window.some_thing_went_wrong = some_thing_went_wrong;

window.toast = toast;


window.ECHO = new Vue();

import stringHelpers from './helpers/string';
stringHelpers();

import prototypes from './prototypes';
prototypes();

import allComponentRegistered from './component_registration/all_component_registration';

allComponentRegistered;

import router from './routes/routes';

const app = new Vue({

	router,
	data:{
		loading:false,
		notification: {
			notificationCount: 0,
			notificationMessagesSample: null,
			notificationMessagesAll: null,
		}
		,

		notificationCounterForShowingToast: null,
	},

	methods:{

		fetch_notification_and_notify_online() {
 
			setInterval(() => {
				axios.get("api/fetch_notification_and_notify_online")
					.then(( response ) => {

						let data = response.data;

						if( data == 0 ){
							this.notification.notificationMessagesAll = null;
							this.notification.notificationMessagesSample = null;
							this.notification.notificationCount = 0;
							this.notificationCounterForShowingToast = 0;
						}
						else{
							//UPDATE BALANCE AND TRANSACTION
							ECHO.$emit('UPDATE_DATA', data);
							Vue.prototype.userDetails = data.userDetails;
							Vue.prototype.userDetails.balance = data.balance;
							Vue.prototype.transactions = data.transactions.data;

							this.notification.notificationMessagesAll = data.notificationMessagesNoPagination;
							this.notification.notificationMessagesSample = this.push_max_3_sample_notification( data.notificationMessagesNoPagination );
							this.notification.notificationCount = data.notificationCount;

							if( this.notificationCounterForShowingToast != data.notificationCount ) {
								let new_notification_count = Math.abs(this.notificationCounterForShowingToast-data.notificationCount);
								toast.fire({
                                	type: 'info',
                                	title: 'You have ' + new_notification_count  + ' new notification.',
                            	});
							}

							this.notificationCounterForShowingToast = data.notificationCount;
							
							
						}
						
					})
					.catch((error)=>{
						//ALERT ERROR HAPPENED
						console.log('Notification Error C2');
						console.log(error);
						ECHO.$emit('END_LOADING');
					});
			}, 5000);

		}
		,

		push_max_3_sample_notification( allNotification ) {
			return allNotification.slice(0,3);
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

		notify_message( message ) {
			if( message != null ) {
				return message.substr(0, 25)+'...';
			}
			return message;
		}
		,

	}
	,

	mounted() {
		this.fetch_notification_and_notify_online();
		ECHO.$on('START_LOADING', ()=>{
			this.loading = true
		});

		ECHO.$on('END_LOADING', ()=>{
			this.loading = false
		});
	}
	,

	
	
}).$mount('#app');






