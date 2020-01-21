<template>
    <div class="row">
        

        <!-- Middle Panel============================================= -->
        <div class="col-lg-12">
          
                <h2 class="font-weight-400 mb-3">Transactions</h2>
                
                <!-- Filter============================================= -->
                <div class="row">
                  <div class="col mb-2">
                    <form id="filterTransactions" method="post">
                      <div class="form-row">

                        <!-- Date Range========================= -->
                        <div class="col-sm-6 col-md-5 form-group">

                          <div class="input-group">

                            <div class="input-group-prepend"> 
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span> 
                            </div>

                            <input id="dateRange" name="dateRange" type="text" class="form-control" placeholder="Date Range" 
                             value="">

                      
                            <div class="input-group-append" style="cursor:pointer;"> 
                              <span class="input-group-text text-warning" @click="filterTransactionByDate">
                                  <i class="fas fa-search"></i>
                              </span> 
                            </div> 

                          </div>
                          

                        </div>



                        <!-- All Filters Link========================= -->
                        <div class="col-auto d-flex align-items-center mr-auto form-group" data-toggle="collapse"> 
                          <a class="btn-link" data-toggle="collapse" href="#allFilters" aria-expanded="false" aria-controls="allFilters">
                            All Filters
                            <i class="fas fa-sliders-h text-3 ml-1"></i>
                          </a> 
                        </div>

                        <!-- Statements Link========================= -->
                        <div class="col-auto d-flex align-items-center ml-auto form-group">
                          <div class="dropdown"> <a class="text-muted btn-link" href="#" role="button" id="statements" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-file-download text-3 mr-1"></i>Statements</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="statements"> <a class="dropdown-item" href="#">CSV</a> <a class="dropdown-item" href="#">PDF</a> </div>
                          </div>
                        </div>
                        
                        <!-- All Filters collapse================================ -->
                        <div class="col-12 collapse mb-3" id="allFilters">

                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="allTransactions" name="allFilters" class="custom-control-input" checked="" v-model="filterBy" value="all" @change="filterTransactionBy()">
                            <label class="custom-control-label" for="allTransactions">All Transactions</label>
                          </div>

                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="paymentsSend" name="allFilters" class="custom-control-input" v-model="filterBy" value="send" @change="filterTransactionBy">
                            <label class="custom-control-label" for="paymentsSend">Payments Send</label>
                          </div>

                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="paymentsReceived" name="allFilters" class="custom-control-input" v-model="filterBy" value="received" @change="filterTransactionBy()">
                            <label class="custom-control-label" for="paymentsReceived">Payments Received</label>
                          </div>

                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="withdrawal" name="allFilters" class="custom-control-input" v-model="filterBy" value="withdraw" @change="filterTransactionBy()">
                            <label class="custom-control-label" for="withdrawal">Withdrawal</label>
                          </div>

                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="deposit" name="allFilters" class="custom-control-input" v-model="filterBy" value="deposit" @change="filterTransactionBy()">
                            <label class="custom-control-label" for="deposit">Deposit</label>
                          </div>

                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="request" name="allFilters" class="custom-control-input" v-model="filterBy" value="request" @change="filterTransactionBy()">
                            <label class="custom-control-label" for="request">Request</label>
                          </div>

                           <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="bill_payment" name="allFilters" class="custom-control-input" v-model="filterBy" value="bill_payment" @change="filterTransactionBy()">
                            <label class="custom-control-label" for="bill_payment">Bill Payment</label>
                          </div>


                        </div>
                        <!-- All Filters collapse End -->
                      </div>
                    </form>
                  </div>
                </div>
                <!-- Filter End -->
                
                <!-- All Transactions
                ============================================= -->
                <div >
                  <div class="bg-light shadow-sm rounded py-4 mb-4">
                    <h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">{{ displayFilterType() }}</h3>
                    
                    <div v-if="showTransaction">
                    <!-- Title=============================== -->
                    <div class="transaction-title py-2 px-4">
                      <div class="row">
                        <div class="col-2 col-sm-1 text-center"><span class="">Date</span></div>
                        <div class="col col-sm-7">Description</div>
                        <div class="col-auto col-sm-2 d-none d-sm-block text-center">Status</div>
                        <div class="col-3 col-sm-2 text-right">Amount</div>
                      </div>
                    </div>
                    <!-- Title End -->
                    
                    <!-- Transaction List=============================== -->
                  

                    <transaction_list :transactionsData="transactionsThis"></transaction_list>
                    <!-- Transaction List End -->
                    
                    <!-- Transaction Item Details Modal
                    =========================================== -->
                    <transaction_modal></transaction_modal>
                    <!-- Transaction Item Details Modal End -->
                    
                    </div>

                    <div v-else>
                    
                        <div class=" bg-white rounded p-4 text-center featured-box style-4 py-2">
    
                            <div class="featured-box-icon text-light border rounded-circle shadow-none"> 
                              <i class="fas fa-eye-slash"></i> 
                            </div>
    
                            <h3 class="text-7 mb-3" style="color:red">): 0 record found!</h3>
    
                            <span class="text-muted btn-link text-4" @click="toggleFilter('all')">
                              View All Transactions
                              <i class="fas fa-chevron-right text-2 ml-2"></i>
                            </span> 
                        </div>
    
                    </div>

                    <!-- Pagination============================================= -->
                    <ul class="pagination justify-content-center mt-4 mb-0">
                        <pagination :data="transactionsPaginate" 
                                    :limit="1"
                                    :size="'default'" 
                                    @pagination-change-page="pagination" >
                        </pagination>
                    </ul>
                    <!-- Paginations end --> 

                  </div>
                </div>


                <!-- All Transactions End --> 
              </div>
              <!-- Middle End --> 

    </div>
</template>

<script>

    export default {

        created(){
          this.loadTransaction();
          
          ECHO.$on('UPDATE_DATA', ( responseData) => {
            this.transactionsThis = responseData.transactions.data;
          });
          
          
        },

        mounted() {
          ECHO.$emit('START_DATE_PICKER');
          
        },

        data(){
          return {
            transactionsThis: {},
            transactionsBeforeFilter: {},
            transactionsPaginate: {},
            filterBy: "all",
            showTransaction: true,
          }
        },

        methods: {

          loadTransaction(){
            ECHO.$emit('START_LOADING');
            
            let temp;
            axios.get("api/transactions")
                 .then(({data}) => (
                    this.transactionsPaginate = data,
                    this.transactionsBeforeFilter = data.data,
                    temp = this.filterTransactionBy(),
                    ECHO.$emit('END_LOADING')
                  ));
            
            
                                
          }//END of loadTransaction()
          ,

          pagination(page = 1){
            ECHO.$emit('START_LOADING');

            let temp;
            axios.get('api/transactions?page=' + page)
                 .then(response => {
                    this.transactionsPaginate = response.data;
                    this.transactionsBeforeFilter = response.data.data;
                    temp = this.filterTransactionBy();
                    ECHO.$emit('END_LOADING');
                  });
            
            
          }//END of pagination()
          ,

          filterTransactionBy() {
            
            switch ( this.filterBy ) {
              

              case "all":{
                this.transactionsThis = this.transactionsBeforeFilter;
                break;
              }

              case "send": {
                let temp = new Object();
                let temp2 = this.transactionsBeforeFilter;

                for( let index in temp2 ){
                  
                  let temp3 = temp2[index];
                  if ( temp3.transaction_type == 0 && (temp3.sender_id == user.id) ){
                    temp[index] = temp3;
                  }
                }

                this.transactionsThis = temp;
                break;
              }

              case "received": {
                let temp = new Object();
                let temp2 = this.transactionsBeforeFilter;

                for( let index in temp2 ){
                  
                  let temp3 = temp2[index];
                  if ( temp3.transaction_type == 0 && (temp3.sender_id != user.id) ){
                    temp[index] = temp3;
                  }
                }

                this.transactionsThis = temp;
                break;
              }

              case "withdraw": {
                let temp = new Object();
                let temp2 = this.transactionsBeforeFilter;

                for( let index in temp2 ){
                  
                  let temp3 = temp2[index];
                  if ( temp3.transaction_type == 1 ){
                    temp[index] = temp3;
                  }
                }

                this.transactionsThis = temp;
                break;
              }

              case "deposit": {
                let temp = new Object();
                let temp2 = this.transactionsBeforeFilter;

                for( let index in temp2 ){
                  let temp3 = temp2[index];
                  if ( temp3.transaction_type == 2 ){
                    temp[index] = temp3;
                  }
                }

                this.transactionsThis = temp;
                break;
              }

              case "request": {
                let temp = new Object();
                let temp2 = this.transactionsBeforeFilter;

                for( let index in temp2 ){
                  let temp3 = temp2[index];
                  if ( temp3.transaction_type == 3 ){
                    temp[index] = temp3;
                  }
                }

                this.transactionsThis = temp;
                break;
              }

              case "bill_payment": {
                let temp = new Object();
                let temp2 = this.transactionsBeforeFilter;

                for( let index in temp2 ){
                  let temp3 = temp2[index];
                  if ( temp3.transaction_type == 5 ){
                    temp[index] = temp3;
                  }
                }

                this.transactionsThis = temp;
                break;
              }

              default: 
                this.transactionsThis = this.transactionsBeforeFilter;

            }

            this.show_transaction_();
          }//END of filterTransactionBy()
          ,

          filterTransactionByDate(){

            let filterDate = document.getElementById('dateRange').value;
            let start_end = filterDate.split("-");
            let start = start_end[0].trim();
            let end = start_end[1].trim();

            let temp = new Object();
            let temp2 = this.transactionsBeforeFilter;

            for( let index in temp2 ){

              let temp3 = temp2[ index ];
              let created_at = temp3.created_at;
            
              let date = created_at.split(" ")[0];
              // 12/21/2001 format "mm/dd/yyyy" *from* "yyyy-mm-dd"
              let date_array = date.split("-");
              let formattedDate = date_array[1] + "/" + date_array[2] + "/" + date_array[0];

              if( formattedDate >= start && formattedDate <= end ){
                temp[ index ] = temp3;
              }
              
            }      

            this.transactionsThis = temp;
            this.show_transaction_();

          }//END of filterTransactionByDate()
          ,

          displayFilterType(){

            switch ( this.filterBy ) {

              case 'all':       return "All Transactions";
              case 'send':      return "Send Transactions" ;
              case "received":  return "Received Transactions";
              case "withdraw":  return "Withdraw Transactions";
              case "deposit":   return "Deposit Transactions";
              case 'request':   return "Request Transactions";
              case 'bill_payment':   return "Bill Payment Transactions";
              default:          return "All Transactions";

            }

          }//END of displayFilterType()
          ,

          toggleFilter( filter ){
            
            this.filterBy = filter;
            this.filterTransactionBy();
            
          }//END of toggleFilter()
          ,

          show_transaction_(){
            let empty = true;
            for( let t in this.transactionsThis ){
              if( !empty ) break;
              empty = false;
            }

            if( empty ){
              this.showTransaction = false;
            }
            else{
              this.showTransaction = true;
            }
          }// END of show_transaction()
          ,


      }


    }
</script>
