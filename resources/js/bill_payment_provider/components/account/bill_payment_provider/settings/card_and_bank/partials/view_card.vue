<template>

<!-- Credit or Debit Cards============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-4">Credit or Debit Cards</h3>

            <div class="row">

              <div class="col-12 col-sm-6 col-lg-4 mb-4"  v-for="userCardLink in userCardLinksThis" :key="userCardLink.card.id">
                <div class="account-card account-card-primary text-white rounded p-3 mb-4 mb-lg-0">
                  <!-- Card Number -->
                  <p class="text-4"> {{ userCardLink.card.card_number }} 
                      <span class="bg-light text-1 text-body rounded-pill d-inline-block px-2 line-height-4 opacity-8 ml-auto font-weight-500"  v-if="show_warning(userCardLink)">
                          <span  style="color:red;"><i class="fas fa-exclamation-circle"></i></span>
                          {{ show_warning_message( userCardLink ) }}
                      </span>
                  </p>

                  <p class="d-flex align-items-center">
                    <span class="account-card-expire text-uppercase d-inline-block opacity-6 mr-2">Valid<br>
                    thru<br>

                    </span>
                    <!-- Expire Date -->
                    <span class="text-4 opacity-9"> {{ userCardLink.card.expire_date }} </span>

                    

                    <!-- Card Giver Bank Name -->
                    <span class="bg-light text-0 text-body font-weight-500 rounded-pill d-inline-block px-2 line-height-4 opacity-8 ml-auto">
                      {{ userCardLink.bank.bank_name }}
                    </span>

                  </p>

                  <p class="d-flex align-items-center m-0">
                    <!-- Card Holder Name -->
                    <span class="text-uppercase font-weight-500"> {{ userCardLink.card.holder_name }} </span>
                    <img class="ml-auto" :src="'/storage/uploads/banks_logo/'+ get_bank_logo( userCardLink.bank.bank_name )"
                    alt="bank"
                    title=""
                    height="50"
                    width="50">
                  </p>

                  <div class="account-card-overlay rounded">

                    <a href="#" data-target="#edit-card-details" data-toggle="modal"
                    class="text-light btn-link mx-2" @click="openCardEdit( userCardLink )">

                      <span class="mr-1"><i class="fas fa-edit"></i></span>
                      Edit
                    </a>

                    <a href="#" class="text-light btn-link mx-2" @click="delete_card( userCardLink.card.id )">

                      <span class="mr-1"><i class="fas fa-minus-circle"></i></span>
                      Delete
                    </a>

                  </div>

                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-4 mb-4">
                  <a href=""
                     data-target="#add-new-card-details"
                     data-toggle="modal"
                     class="account-card-new account-card d-flex align-items-center rounded h-100 p-5 mb-4 mb-lg-0">

                  <p class="w-100 text-center line-height-4 m-0">
                    <span class="text-3"><i class="fas fa-plus-circle"></i></span>
                    <span class="d-block text-body text-3">Add New Card</span>
                  </p>

                  </a>
              </div>

            </div>

            <edit-card :card_info="linkCardModal"></edit-card>

          </div>

</template>


<script>
    export default {
        mounted() {
            //console.log('Card Dashboard Component mounted.');
            //console.log(this.userCardLinksThis);
        },


        data() {
          return{
            linkCardModal: new Form({
              id: null,
              bank_name: null,
              type: null,
              card_number: null,
              holder_name: null,
              expire_date: null,
              cvv: null,
            }),
            userCardLinksThis: this.userCardLinks,

          }
        },


        methods: {
          openCardEdit( cardInfo ) {
            this.linkCardModal.id = cardInfo.card.id;
            this.linkCardModal.card_number = cardInfo.card.card_number.split('-').join('');
            this.linkCardModal.holder_name = cardInfo.card.holder_name;
            this.linkCardModal.expire_date = cardInfo.card.expire_date;
            this.linkCardModal.cvv = cardInfo.card.cvv;
            this.linkCardModal.type = cardInfo.card.type;
            this.linkCardModal.bank_name = cardInfo.bank.id;
          }
          ,

          get_bank_logo( bankName ) {
            return bankName.toLowerCase().split(' ').join('_') + '.png';
          }
          ,

          delete_card(id){
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
                        this.linkCardModal.delete('api/delete_card/'+ id)

                            .then(() =>{
                                swal.fire(
                                    'Deleted!',
                                    'Successfully deleted card.',
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

            show_warning( userCardLink ) {
              if( userCardLink.card.approved == 'no'){
                return true;
              }
              else if( !userCardLink.card.valid ) {
                return true;
              }
              else{
                return false;
              }
            }
            ,

            show_warning_message( userCardLink ) {
              if( userCardLink.card.approved == 'no'){
                return 'Card not approved';
              }
              else if( !userCardLink.card.valid ) {
                return 'Invalid card link';
              }
              else{
                return '';
              }
            }
            ,



        },


        created() {

        },


    }
</script>
