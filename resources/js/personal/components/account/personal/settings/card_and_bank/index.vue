<template>
    <div class="row">
        
        
        <!-- Middle Panel============================================= -->
        <div class="col-lg-12">
          
          <view-card ></view-card>

          <link-card></link-card>
          

          <view-bank></view-bank>

          <link-bank></link-bank>


        </div>
        <!-- Middle Panel End -->
    </div>
</template>

<script>
    export default {
        mounted() {
            //console.log('Card Dashboard Component mounted.');
        },

        
        data() {
          return{
            linkCardModal: {
              card_number: null,
              holder_name: null,
              expire_date: null,
              cvv: null,
            },

            linkBankModal: {
              account_type: 'Personal',
              account_name: null,
              account_number: null,
              bank_name: null,
              book_number: null,
              bank_country: 'Ethiopia',

            }

          }
        },


        methods: {
          openCardEdit( cardInfo ) {
            this.linkCardModal.card_number = cardInfo.card.card_number;
            this.linkCardModal.holder_name = cardInfo.card.holder_name;
            this.linkCardModal.expire_date = cardInfo.card.expire_date;
            this.linkCardModal.cvv = cardInfo.card.cvv;
            this.linkCardModal.bank_name = cardInfo.bank.bank_name;
          },

          openBankAccountDetail( BankAccountDetail ) {
            this.linkBankModal.account_name = BankAccountDetail.full_name;
            this.linkBankModal.account_number = BankAccountDetail.account_number;
            this.linkBankModal.bank_name = BankAccountDetail.bank.bank_name;
            this.linkBankModal.book_number = BankAccountDetail.book_number;

          }

        },


        created() {

        },


    }
</script>
