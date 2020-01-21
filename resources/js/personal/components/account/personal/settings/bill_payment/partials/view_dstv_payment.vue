<template>


     <!-- Phone============================================= -->
     <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">
              Dstv Bill Payment 
              <a href="#edit-dstv-payment-settings" data-toggle="modal" 
              class="float-right text-1 text-uppercase btn btn-sm btn-info">
                <i class="fas fa-edit mr-1"></i>
                {{ operationTypeText }}</a>
            </h3>


            <div  v-if="showInfoDetail">

            

                <div class="row">
                <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">
                    Payment identification
                </p>
                <p class="col-sm-9"> {{ dstv_payment_identification }}</p>
                </div>

                <div class="row">
                    <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">
                        Service provider
                    </p>
                    <p class="col-sm-9"> {{ dstv_service_provider }}</p>
                </div>

                <h3 class="text-5 font-weight-400 mb-4 text-white">
                        <button class="float-right text-1 text-uppercase btn btn-sm btn-danger" 
                        @click="delete_link()">
                          <i class="fas fa-trash mr-1"></i>
                          Delete</button>
                </h3>
            
            </div>

          </div>


</template>


<script>
    export default {
      mouted() {
          //this.show_data();
          //console.log(userBillPaymentLinks.dstv);
      }
      ,
  
      created() {
        this.show_data();
        ECHO.$on('UPDATE_DSTV_BILL_INFO', (data)=>{
          this.delete_bill_payment_link.link_id = data.id;
          this.dstv_payment_identification = data.user_payment_identification;
          let bill_payment_id = data.bill_payment_id;
          for( let wsp in this.dstv_service_providers ) {

                let wsp_data = this.dstv_service_providers[wsp];
                if( wsp_data.id == bill_payment_id ){
                    this.dstv_service_provider = wsp_data.bill_payment_name;
                    break;
                }

            }
            this.showInfoDetail = true;
            this.operationTypeText = 'Edit Dstv Bill Information';
        });

        ECHO.$on('DELETE_DSTV_BILL_INFO',()=>{
            this.showInfoDetail = false;
            this.dstv_payment_identification = 'Not Linked';
            this.dstv_service_provider = 'Not Linked';
            this.operationTypeText = 'Add Dstv Bill Information';
        });
        
        this.find_dstv_provider_full_name();
  
      }
      ,
  
      data() {
        return {

            dstv_payment_identification: userBillPaymentLinks.dstv.user_payment_identification,
            dstv_service_provider: 'Finding...',
            dstv_service_providers: null,
            operationTypeText: 'Add Dstv Bill Information',
            showInfoDetail: false,
            delete_bill_payment_link: new Form({
                link_id: userBillPaymentLinks.dstv.id
            }),
        }
      }
      ,
  
      methods: {

          find_dstv_provider_full_name(){
                  ECHO.$emit('START_LOADING');

                  
   
                  axios.get("/pa/api/get_dstv_service_providers")
                       .then(({data}) => {
                          this.dstv_service_providers = data;

                          let bill_payment_id = userBillPaymentLinks.dstv.bill_payment_id;

                            for( let wsp in this.dstv_service_providers ) {
                                let wsp_data = this.dstv_service_providers[wsp];
                                if( wsp_data.id == bill_payment_id ){
                                    this.dstv_service_provider = wsp_data.bill_payment_name;
                                    break;
                                }

                            }
                            return 'Finding...';

                       });

   
                ECHO.$emit('END_LOADING');
   
         }//END of load_dstv_service_providers
        ,

        show_data() {
            if( userBillPaymentLinks.dstv.user_payment_identification == null ){
                this.showInfoDetail = false;
                
                this.dstv_payment_identification = 'Not Linked';
                this.dstv_service_provider = 'Not Linked';
                this.operationTypeText = 'Add Dstv Bill Information';

            }
            else{
                this.showInfoDetail = true;
                this.operationTypeText = 'Edit Dstv Bill Information';
                this.dstv_payment_identification = userBillPaymentLinks.dstv.user_payment_identification;
                this.dstv_service_provider = 'Finding';
                this.find_dstv_provider_full_name();
            }
        }
        ,

        delete_link(){
            swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    //send delete request
                    if(result.value){
                        this.delete_link_function();
                    }
                })

        }
        ,

        delete_link_function() {
            ECHO.$emit('START_LOADING');

            this.delete_bill_payment_link.post('api/delete_bill_payment_link')
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
                    
                    ECHO.$emit('DELETE_DSTV_BILL_INFO');
                    userBillPaymentLinks.dstv = null;
                    swal.fire({
                    title:'Success',
                    text:"Dstv Bill payment link deleted successfully.",
                    type:'warning',
                    confirmButtonText: 'OK'
                    });
                    ECHO.$emit('END_LOADING'); 
                }


            })
            .catch((error)=>{
                //ALERT ERROR HAPPENED
                console.log('ALERT ERROR HAPPENED C2');
                some_thing_went_wrong.fire();
            });
        }
        ,

         


      }
  
    }
  </script>