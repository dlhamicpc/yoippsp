<template>
<!-- Bank Accounts ============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-4">Bank Accounts</h3>
            <div class="row">
              <div class="col-12 col-sm-4 mb-4 " v-for=" userBankLink in userBankLinks " :key="userBankLink.id">
                <div class="account-card account-card-primary text-white rounded mb-4 mb-lg-0">
                  <div class="row no-gutters">
                    <div class="col-3 d-flex justify-content-center p-3">
                      <div class="my-auto text-center text-13"> <i class="fas fa-university"></i>

                        <!--Book number-->
                        <p class="bg-light text-0 text-body font-weight-500 rounded-pill d-inline-block px-2 line-height-4 opacity-8 mb-0">{{ userBankLink.book_number }}

                            
                        </p>

                      </div>
                    </div>
                    <div class="col-9 border-left">
                      <div class="py-4 my-2 pl-4">

                        <!--Bank Name-->
                        <p class="text-4 font-weight-500 mb-1">{{ userBankLink.bank.bank_name }}
                          <span class="bg-light text-1 text-body rounded-pill d-inline-block px-2 line-height-4 opacity-8 ml-auto font-weight-500"  v-if="show_warning(userBankLink)">
                            <span  style="color:red;"><i class="fas fa-exclamation-circle"></i></span> 
                            {{ show_warning_message( userBankLink ) }}
                        </span>
                        </p>

                        <!-- Account number -->
                        <p class="text-4 opacity-9 mb-1">{{ userBankLink.account_number }}</p>

                        <!-- Full Name Status -->
                        <p class="m-0">{{ userBankLink.full_name }}</p>

                        

                      </div>
                    </div>
                  </div>
                  <div class="account-card-overlay rounded">

                    <a href="#" data-target="#bank-account-details" data-toggle="modal"
                    class="text-light btn-link mx-2" @click="openBankAccountDetail( userBankLink )">

                      <span class="mr-1"><i class="fas fa-share"></i></span>More Details</a>

                      <a href="#" class="text-light btn-link mx-2" @click="delete_bank_account( userBankLink.id )">

                        <span class="mr-1"><i class="fas fa-minus-circle"></i></span>
                        Delete</a>

                  </div>

                </div>
              </div>
              <div class="col-12 col-sm-4  col-lg-4 mb-4">
                  <a href=""
                     data-target="#add-new-bank-account"
                     data-toggle="modal"
                     class="account-card-new account-card d-flex align-items-center rounded h-100 p-5 mb-4 mb-lg-0">

                <p class="w-100 text-center line-height-4 m-0">
                    <span class="text-3">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="d-block text-body text-3">Add New Bank Account</span>
                </p>

                </a>
              </div>
            </div>


              <!--Bank Account Details Modal======================================== -->
              <div id="bank-account-details" class="modal fade" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered transaction-details" role="document">
                      <div class="modal-content">
                          <div class="modal-body">
                              <div class="row no-gutters">
                                  <div class="col-sm-5 d-flex justify-content-center bg-primary rounded-left py-4">
                                      <div class="my-auto text-center">
                                          <div class="text-17 text-white mb-3"><i class="fas fa-university"></i></div>
                                          <h3 class="text-6 text-white my-3">{{ linkBankModal.bank_name }}</h3>

                                          <p class="bg-light text-0 text-body font-weight-500 rounded-pill d-inline-block px-2 line-height-4 mb-0">{{ linkBankModal.book_number }}</p>
                                      </div>
                                  </div>
                                  <div class="col-sm-7">
                                      <h5 class="text-5 font-weight-400 m-3">Bank Account Details
                                          <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                      </h5>
                                      <hr>
                                      <div class="px-3">
                                          <ul class="list-unstyled">
                                              <li class="font-weight-500">Account Type:</li>
                                              <li class="text-muted">Bill Payment Provider</li>
                                          </ul>
                                          <ul class="list-unstyled">
                                              <li class="font-weight-500">Account Name:</li>
                                              <li class="text-muted">{{ linkBankModal.account_name }}</li>
                                          </ul>
                                          <ul class="list-unstyled">
                                              <li class="font-weight-500">Account Number:</li>
                                              <li class="text-muted">{{ linkBankModal.account_number }}</li>
                                          </ul>
                                          <ul class="list-unstyled">
                                              <li class="font-weight-500">Bank Country:</li>
                                              <li class="text-muted">Ethiopia</li>
                                          </ul>
                                          <ul class="list-unstyled">
                                              <li class="font-weight-500">Status:</li>
                                              <li class="text-muted">
                                                  {{ linkBankModal.status_text  }}
                                                  <span class="text-3" :class="linkBankModal.status_icon_color">
                                                      <i :class="linkBankModal.status_icon"></i>
                                                  </span>
                                              </li>
                                          </ul>

                                          <p>

                                            <a href="#" class="btn btn-sm btn-outline-danger btn-block shadow-none"
                                            @click="delete_bank_account( linkBankModal.id )">
                                              <span class="mr-1">
                                                <i class="fas fa-minus-circle"></i>
                                              </span>Delete Account
                                            </a>
                                            </p>

                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>


          </div>

        </template>


        <script>
            export default {
                mounted() {
                    //console.log('Card Dashboard Component mounted.');
                },


                data() {
                  return{
                    linkBankModal: new Form({
                      id: null,
                      account_type: 'Bill Payment Provider',
                      account_name: null,
                      account_number: null,
                      bank_name: null,
                      book_number: null,
                      bank_country: 'Ethiopia',
                      status_text: null,
                      status_icon_color: null,
                      status_icon: null,

                    }),

                  }
                },


                methods: {
                  openBankAccountDetail( BankAccountDetail ) {
                    this.linkBankModal.id = BankAccountDetail.id;
                    this.linkBankModal.account_name = BankAccountDetail.full_name;
                    this.linkBankModal.account_number = BankAccountDetail.account_number;
                    this.linkBankModal.bank_name = BankAccountDetail.bank.bank_name;
                    this.linkBankModal.book_number = BankAccountDetail.book_number;
                    console.log(BankAccountDetail.approved);

                    if( BankAccountDetail.approved === 'yes' ){
                        this.linkBankModal.status_text = 'Approved';
                        this.linkBankModal.status_icon = 'fas fa-check-circle';
                        this.linkBankModal.status_icon_color = 'text-success';
                    }
                    else{
                        this.linkBankModal.status_text = 'Not Approved! Please go to the nearest ' + BankAccountDetail.bank.bank_name +
                                                            ' branch and approve your bank account.';
                        this.linkBankModal.status_icon = 'fas fa-exclamation-circle';
                        this.linkBankModal.status_icon_color = 'text-danger';
                    }

                  }
                  ,

                  show_warning( userBankLink ) {
                    if( userBankLink.approved == 'no'){
                      return true;
                    }
                    else if( !userBankLink.valid ) {
                      return true;
                    }
                    else{
                      return false;
                    }
                  }
                  ,

                  show_warning_message( userBankLink ) {
                    if( userBankLink.approved == 'no'){
                      return 'Bank account not approved';
                    }
                    else if( !userBankLink.valid ) {
                      return 'Invalid bank account link';
                    }
                    else{
                      return '';
                    }
                  }
                  ,

                          
                delete_bank_account(id){
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
                              ECHO.$emit('START_LOADING');

                              this.linkBankModal.delete('api/delete_bank_account/'+ id)

                                  .then(() =>{
                                      swal.fire(
                                          'Deleted!',
                                          'Successfully deleted bank account.',
                                          'success'
                                          );

                                      window.location.assign('/bpa/card');
                                      ECHO.$emit('END_LOADING');
                                  })

                                  .catch((error) => {
                                      swal.fire(
                                          'Failed!!',
                                          error['message'].search('403') !=-1 ?
                                              "You don't have Access":"There was something wrong",
                                          'warning'
                                          );
                                      ECHO.$emit('END_LOADING');
                                  });
                          }
                      })
                  }
                  ,

                },


                created() {

                },


            }
        </script>
