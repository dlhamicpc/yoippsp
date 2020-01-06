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




const bill_payment_has_not_started = swal.mixin({
	title:'Notice',
	text:"New bill payment has not started. We will notify you as soon as a new bill payment starts.",
	type:'warning',
	confirmButtonText: 'Okay'
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
			billPaymentNotification: null,
		}
		,

		notificationCounterForShowingToast: null,
		showBillPaymentNotification: {
			show: false,
			waterShow: false,
			waterData: null,
			dstvShow: false,
			dstvData: null,
			electricity: false,
			electricityData: null,
			length: 0,
		},

		form_bill_payment: new Form({
			id: null,
			user_id: null,
			amount: null,
	  	}),

	},

	methods:{

		start_loading() {
			ECHO.$emit('START_LOADING');
		}
		,
		
		end_loading() {
			ECHO.$emit('END_LOADING');
		}
		,

		update_data_after_notification( data ) {
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

				if( data.billPaymentNotification != 'empty' ) {
					Vue.prototype.billPaymentNotification = data.billPaymentNotification;
					this.notification.billPaymentNotification = data.billPaymentNotification;
					this.showBillPaymentNotification.show = true;
					this.show_each_bill_payment_notification();
				}

				
				

				if( this.notificationCounterForShowingToast != data.notificationCount ) {
					let new_notification_count = Math.abs(this.notificationCounterForShowingToast-data.notificationCount);
					toast.fire({
						type: 'info',
						title: 'You have ' + new_notification_count  + ' new notification.',
					});
				}

				this.notificationCounterForShowingToast = data.notificationCount;
				
				
			}
		}
		,

		fetch_notification_and_notify_online() {
 
			setInterval(() => {
				axios.get("api/fetch_notification_and_notify_online")
					.then(( response ) => {

						let data = response.data;

						this.update_data_after_notification( data );
						
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

		show_each_bill_payment_notification() {
			let notifications = this.notification.billPaymentNotification;

			this.showBillPaymentNotification.length = 0;
			let waterBill = notifications.water;
			if( waterBill != undefined ) {
				this.showBillPaymentNotification.waterShow = true;
				this.showBillPaymentNotification.waterData = waterBill;
				this.showBillPaymentNotification.length += 1;
			}

			let electricityBill = notifications.electricity;
			if( electricityBill != undefined ) {
				this.showBillPaymentNotification.electricityShow = true;
				this.showBillPaymentNotification.electricityData = electricityBill;
				this.showBillPaymentNotification.length += 1;
			}

			let dstvBill = notifications.dstv;
			if( dstvBill != undefined ) {
				this.showBillPaymentNotification.dstvShow = true;
				this.showBillPaymentNotification.dstvData = dstvBill;
				this.showBillPaymentNotification.length += 1;
			}

		}
		,

		pay_bill( type ) {
			let pass = this.check_balance( this.form_bill_payment.amount );
			if( !pass ){
				return 0;
			}

			let amount = this.form_bill_payment.amount;

			let text = 'Are you sure you want to pay ' + amount + ' Birr for  monthly '+ type +' bill payment.';

			swal.fire({
				title: 'Are you sure?',
				text: text,
				type: 'info',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, I\'m sure'
			}).then((result) => {

				//send delete request
				if(result.value){
					ECHO.$emit('START_LOADING');
					this.form_bill_payment.post('api/pay_bill')
											.then((response) =>{
												let data = response.data;

												this.update_data_after_notification( data );

												swal.fire({
													title: 'Success',
													text: 'Successfully Paid.',
													type: 'success'
												});

												this.showBillPaymentNotification.show = false;
												this.showBillPaymentNotification.waterShow = false;
												this.showBillPaymentNotification.waterData = null;
												this.showBillPaymentNotification.electricityShow = false;
												this.showBillPaymentNotification.electricityData = null;
												this.showBillPaymentNotification.dstvShow = false;
												this.showBillPaymentNotification.dstvData = null;


												
												ECHO.$emit('END_LOADING');
											})
											.catch((error) => {
												ECHO.$emit('END_LOADING');
												if( error.message.search(422) != -1 ){
													swal.fire({
														title:'Failed!!',
														text:"Insufficient Balance",
														type:'error',
														confirmButtonText: 'Try Again ?'
													});
												}
												else if( error.message.search(423) != -1 ){
													swal.fire({
														title:'Notice',
														text:"Already Paid",
														type:'warning',
														confirmButtonText: 'Okay'
													});
												}
												else if( error.message.search(424) != -1 ){
													swal.fire({
														title:'Notice',
														text:"Bill payment due date has passed!",
														type:'warning',
														confirmButtonText: 'Okay'
													});
													this.showBillPaymentNotification.show = false;
													this.showBillPaymentNotification.waterShow = false;
													this.showBillPaymentNotification.waterData = null;
													this.showBillPaymentNotification.electricityShow = false;
													this.showBillPaymentNotification.electricityData = null;
													this.showBillPaymentNotification.dstvShow = false;
													this.showBillPaymentNotification.dstvData = null;
												}
												else{
													some_thing_went_wrong.fire();
												}		
												
												
											});
				}
			});
		}
		,

		pay_water_bill() {
			let waterBill = this.showBillPaymentNotification.waterData;
			if( waterBill != null ){
				this.set_form_data( waterBill );
				this.pay_bill('water');
			}
			else{
				bill_payment_has_not_started.fire();
			}
		}
		,

		set_form_data( bill ) {
			this.form_bill_payment.id = bill.id;
			this.form_bill_payment.user_id = bill.user_id;
			this.form_bill_payment.amount = bill.amount;
		}
		,

		pay_electricity_bill() {
			let electricityBill = this.showBillPaymentNotification.electricityData;
			if( electricityBill != null ){
				this.set_form_data( electricityBill );
				this.pay_bill('electricity');
			}
			else{
				bill_payment_has_not_started.fire();
			}
		}
		,

		pay_dstv_bill() {
			let dstvBill = this.showBillPaymentNotification.dstvData;
			if( dstvBill != null ){
				this.set_form_data( dstvBill );
				this.pay_bill('dstv');
			}
			else{
				bill_payment_has_not_started.fire();
			}
		}
		,

		check_balance( amount ) {
			
			if(  userDetails.balance < amount){
			  swal.fire({
				title: 'Inssuficient Balance!',
				type: 'error',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Deposit',
			  }).then((result) => {
						
				if ( result.dismiss == 'cancel' ){
				}
				else{
					$('#deposit-money').modal('show');
				}
				return 0;
						
			  });
			}
			else{
				return 1;
			}
			

		  }

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






