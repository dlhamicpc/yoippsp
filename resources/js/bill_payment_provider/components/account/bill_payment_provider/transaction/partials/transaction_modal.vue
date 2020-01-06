<template>
 <!-- Transaction Item Details Modal =========================================== -->
            <div id="transaction-detail" class="modal fade" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered transaction-details" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="row no-gutters">
                      <div class="col-sm-5 d-flex justify-content-center bg-primary rounded-left py-4">
                        <div class="my-auto text-center">
                          <div class="text-17 text-white my-3"><i class="fas fa-building"></i></div>
                          <!-- Transfered to or By -->
                          <h3 class="text-4 text-white font-weight-400 my-3">
                            {{ paid_or_requested_to }} {{ receiver_name }}
                          </h3>

                          <!-- Amount -->
                          <div class="text-8 font-weight-500 text-white my-4">{{ totalAmount }} Birr</div>

                          <!-- Date -->
                          <p class="text-white">{{ created_at | date_format_DDMMYY }}</p>

                        </div>
                      </div>
                      <div class="col-sm-7">
                        <h5 class="text-5 font-weight-400 m-3">Transaction Details
                          <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        </h5>
                        <hr>
                        <div class="px-3">
                          <ul class="list-unstyled">
                            <li class="mb-2">Payment Amount 
                              
                              <!--Amount-->
                              <span class="float-right text-3">{{ amount }} Birr</span>
                            
                            </li>

                            <!--Fee-->
                            <li class="mb-2">Fee <span class="float-right text-3">- {{ fee }} Birr</span></li>
                          </ul>
                          <hr class="mb-2">
                          <p class="d-flex align-items-center font-weight-500 mb-4">Total Amount 
                            
                            <!--Amount-->
                            <span class="text-3 ml-auto">{{ totalAmount }} Birr</span></p>

                          <ul class="list-unstyled">
                            <li class="font-weight-500">{{ paid_or_requested_by }}</li>
                            <!--Sender -->
                            <li class="text-muted">{{ sender_name }}</li>
                          </ul>
                          <ul class="list-unstyled">
                            <li class="font-weight-500">Transaction ID:</li>
                            <!--Transaction id-->
                            <li class="text-muted">{{ id }}</li>
                          </ul>
                          <ul class="list-unstyled">
                            <li class="font-weight-500">Description:</li>

                            <!--Description-->
                            <li class="text-muted">{{ description }}</li>
                          </ul>
                          <ul class="list-unstyled">
                            <li class="font-weight-500">Status:</li>

                            <!--Status-->
                            <li class="text-muted">{{ statusText }}</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Transaction Item Details Modal End -->
</template>

<script>
    export default {
        mounted() {
            //console.log('rans Modal Component mounted.')
        },


        data(){
          return{
           
              id: null,
              sender_name: null,
              receiver_name: null,
              amount: null,
              fee: null,
              description: null,
              transaction_type: null,
              status: null,
              created_at: null,

              totalAmount: null,
              statusText: null,

              paid_or_requested_by: null,
              paid_or_requested_to: null, 

          }
        },


        methods:{
          loadData( transaction ) {
              this.id =  transaction.id;
              this.sender_name =  transaction.sender_name;
              this.receiver_name = transaction.receiver_name;
              this.amount = transaction.amount;
              this.fee = transaction.fee;
              this.description = this.check_if_description_is_greater_than_65535( transaction.description );
              this.transaction_type = transaction.transaction_type;
              this.status = transaction.status;
              this.created_at = transaction.created_at;

              this.totalAmount = this.amount - this.fee;
              
              if( this.status == 0 ) this.statusText = 'Failed';
              else if( this.status == 1 ) this.statusText = 'Pending';
              else this.statusText = 'Completed';

              if( this.transaction_type == 3 ){
                this.paid_or_requested_by = "Requested By: ";
                this.paid_or_requested_to = "Request Sent To: ";
              }
              else{
                this.paid_or_requested_by = "Paid By: ";
                this.paid_or_requested_to = "Paid To: ";
              }

          }
          ,

          check_if_description_is_greater_than_65535( description ) {
            if( description != null && description.length > 200 ) {
              return description.substr(0,200 ) + "...";
            }
            return description;
          }

        },


        created() {
          ECHO.$on('DASHBOARD_TRANSACTION_MODAL_OPENED', (transaction) => {
                this.loadData(transaction);
          });
        }
    }
</script>
