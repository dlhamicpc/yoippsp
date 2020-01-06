<template>
    <div>
        <!-- Start Accepting Payment Modal================================== -->
          <div id="start-payment" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Start Accepting Payment</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <!-- Start Accepting Payment Form============================================= -->
                    <form id="form_start_payment" @submit.prevent="">

                      <!-- Date range -->
                    <div class="form-group">
                        <label>Payment Starts On - Payment End On </label>
      
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="date_range_picker_icon">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input 
                            type="text" 
                            class="form-control float-right"
                            id="date_range_picker"
                            onblur=" validate( event, 'required', null, true) "
                            oninput=" validate( event, 'required', null, true) ">
                        </div>
                        <div class="form-control" id="date_range_pickerError" style="display: none;"></div>
                        
                      </div>
                      

                      <div class="row">

                        <div class="form-group col-12 col-sm-6">
                            <label>Payment Of Month</label>
            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="payment_of_month_icon">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                </div>

                                <select name="payment_of_month" 
                                    id="payment_of_month" 
                                    class="form-control float-right"
                                    v-model="form_start_payment.payment_of_month"
                                    onblur=" validate( event, 'required', null, true) "
                                    onchange=" validate( event, 'required', null, true) ">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                
                            </div>
                            <div class="form-control" id="payment_of_monthError" style="display: none;"></div>
                            </div>
                            

                            <div class="form-group col-12 col-sm-6">
                                <label>Payment Of Year</label>
                
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="payment_of_year_icon">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                    </div>
                                    
                                    <select name="payment_of_year" 
                                    id="payment_of_year" 
                                    class="form-control float-right"
                                    v-model="form_start_payment.payment_of_year"
                                    onblur=" validate( event, 'required', null, true) "
                                    onchange=" validate( event, 'required', null, true) ">
                                            <option v-for="year in years" :key="year" v-text="year">
                                            </option>
                                    </select>
                                    

                                </div>
                                <div class="form-control" id="payment_of_yearError" style="display: none;"></div>
                            </div>

                      </div>
                        

                      <hr>

                      <button class="btn btn-info btn-block"
                            @click="start_accepting_payment()"
                            style="background: #007bff">
                            Start Accepting Payment
                      </button>

                    </form>

            <!-- Start Accepting Payment Form end --> 
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
            this.set_years();
        }
        ,

        created(){

        }
        ,

        data(){
          return{
            form_start_payment: new Form({
                  date_range_picker: "",
                  payment_of_month: (new Date()).getMonth(),
                  payment_of_year: (new Date()).getFullYear(),
            }),

            years: [2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012],


          }
        }
        ,
        
        methods:{

            set_years() {
                let this_year = new Date();
                let year_total = String(this_year.getFullYear()).substr(2);
                
                for( let year = 13; year <= year_total; year++ ){
                    this.years.push( '20' + String(year) );
                }
            }
            ,

            start_accepting_payment(){
                this.form_start_payment.date_range_picker = $('#date_range_picker').val();

                swal.fire({
                    title: 'Are you sure?',
                    text: "Did you provide the correct data.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, I\'m sure'
                }).then((result) => {

                    //send delete request
                    if(result.value){
                        ECHO.$emit('START_LOADING');
                        this.form_start_payment.post('api/start_accepting_payment')
                                                .then(({data}) =>{
                                                  $('#start-payment').modal('hide');
                                                    swal.fire({
                                                        title: 'Success',
                                                        text: 'Successfully Started Accepting Payment.',
                                                        type: 'success'
                                                    });

                                                    
                                                    ECHO.$emit('END_LOADING');
                                                })
                                                .catch((error) => {
                                                    ECHO.$emit('END_LOADING');
                                                    console.log(error.message);
                                                    if( error['message'].search('403') !=-1 ){
                                                        swal.fire(
                                                            'Failed!!',
                                                            "You have already created a post for this month",
                                                            'warning'
                                                        );
                                                    }
                                                    else if(error['message'].search('500') !=-1){
                                                      swal.fire(
                                                            'Failed!!',
                                                            "We couldn't find a bill payment post with your input month and year please check your information again!",
                                                            'error'
                                                        );
                                                    }
                                                    else if(error['message'].search('422') !=-1){
                                                        this.show_error_to_request_modal();
                                                    }
                                                    else{
                                                        some_thing_went_wrong.fire();
                                                    }
                                                    
                                                    
                                                });
                    }
                });
            }
            ,


          show_error_to_request_modal( ){
            if( this.form_start_payment.errors.has('date_range_picker') ){
              this.invalid_date_range_picker();
            }

            if( this.form_start_payment.errors.has('payment_of_month') ){
              this.invalid_payment_of_month();
            }

            if( this.form_start_payment.errors.has('payment_of_year') ){
              this.invalid_payment_of_year();
            }
          }
          ,

          invalid_date_range_picker(){
            StyleErrorIconLeft( 'date_range_picker', 'date_range_pickerError' );
            ID( 'date_range_pickerError' ).innerHTML = this.form_start_payment.errors.errors.date_range_picker;
          }
          ,

          invalid_payment_of_month(){
            StyleErrorIconLeft( 'payment_of_month', 'payment_of_monthError' );
            ID( 'payment_of_monthError' ).innerHTML = this.form_start_payment.errors.errors.payment_of_month;
          }
          ,

          invalid_payment_of_year(){
            StyleErrorIconLeft( 'payment_of_year', 'payment_of_yearError' );
            ID( 'payment_of_yearError' ).innerHTML = this.form_start_payment.errors.errors.payment_of_year;
          }
          ,


        }
        ,

        computed:{

          
          

        }
    }
</script>
