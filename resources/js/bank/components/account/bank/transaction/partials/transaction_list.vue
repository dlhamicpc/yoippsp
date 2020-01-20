<template>
  <!-- Transaction List=============================== -->
            <div class="transaction-list">

              <div class="transaction-item px-4 py-3" data-toggle="modal" data-target="#transaction-detail"
                v-for="transaction in transactionsData" :key="transaction.id" @click="open_transaction_modal(transaction)">

                <div class="row align-items-center flex-row">
                  <div class="col-2 col-sm-1 text-center"> 
                    
                    <!-- Payment Day -->
                    <span class="d-block text-4 font-weight-400">
                      {{ transaction.created_at | only_day }}
                    </span> 
                    
                    <!-- Payment Month -->
                    <span class="d-block text-1 font-weight-800 text-uppercase">
                        {{ transaction.created_at | only_month }}
                    </span>

                    <!-- Payment Month -->
                    <span class="d-block text-1 font-weight-400 text-uppercase">
                        {{ transaction.created_at | only_time }}
                    </span>

                  </div>

                  <div class="col col-sm-7"> 

                    <!-- Payment Sender or Receiver -->
                    <span class="d-block text-4">{{ descriptionNameSign ( transaction , 'name') }}</span> 

                    <!-- Payment Type -->
                    <span class="text-muted">{{ descriptionPayedFor ( transaction ) }}</span> 
                  </div>

                  <div class="col-auto col-sm-2 d-none d-sm-block text-center text-3"> 

                    <!-- Payment Status -->
                    <span :class="status( transaction ,'color' )" data-toggle="tooltip" :title="status(transaction,'title' )">
                      <i :class="status ( transaction, 'icon' )" ></i>
                    </span> 
                  </div>

                  <!-- Payment Amount -->
                  <div class="col-3 col-sm-2 text-right text-4"> 
                    <span class="text-nowrap">
                      <!-- Payment Send or Receive -->
                      <span class="font-weight-800">{{ descriptionNameSign ( transaction , 'sign') }} </span>
                      {{ transaction.amount }}  
                    </span> 

                    <span class="text-2 text-uppercase">(Birr)</span> 

                  </div>

                </div>

              </div>

            </div>
            <!-- Transaction List End -->
</template>

<script>
    export default {
      props: {
        transactionsData:{
          
        }
      },
        mounted() {
            //console.log('Trans List Component mounted.')
            
        },

        data() {
          return {
            status_title: null,
            status_icon: null,
            status_text_color: null,
            sign: null,
          }
          
        },

        methods: {

          descriptionNameSign ( transaction , type ) {
            
            if ( transaction.sender_id == user.id ){
              return type == 'name' ? transaction.receiver_name : '-';
            }else{
              return type == 'name' ? transaction.sender_name : '+';
            }

          },

          descriptionPayedFor ( transaction ) {
            
            switch ( transaction.transaction_type ) {

              case 0: 
                if ( transaction.sender_id == user.id ) {
                  return 'Payment Sent';
                }
                return 'Payment Received';

              case 1: return 'Withdraw to Bank Account';

              case 2: return 'Deposit to yoip wallet';

              case 3: return 'Request money';

              case 4: return 'Online Payment';

              default: return 'Payment';

            }

          },

          status ( transaction, type ) {
            
            let status_ = transaction.status;
            let status_icon = null;
            let status_text_color = null;
            let status_title = null; 
            
            switch ( status_ ) {

              case 0: 
                status_title = 'Failed';
                status_icon = 'fas fa-times-circle';
                status_text_color = 'text-danger';
                break;
              
              case 1: 
                status_title = 'Pending';
                status_icon = 'fas fa-ellipsis-h';
                status_text_color = 'text-warning';
                break;
              
              case 2: 
                status_title = 'Success';
                status_icon = 'fas fa-check-circle';
                status_text_color = 'text-success';
                break;

            }

            if ( type == 'icon' ) return status_icon;
            else if ( type == 'color' ) return status_text_color;
            else return status_title;
            
          },


          open_transaction_modal ( transaction ){
            ECHO.$emit('DASHBOARD_TRANSACTION_MODAL_OPENED', transaction);
          }

        }
    }
</script>
