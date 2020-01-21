 <template>

 <!-- Add New Card Details Modal================================== -->
          <div id="add-new-card-details" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Add a Card</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="form_link_card" method="post"  @submit.prevent="">


                  <div class="form-group">
                      <label for="bank_name">Card Type</label>
                      <select id="bank_name"
                              name="bank_name"
                              class="custom-select"
                              v-model="form_link_card.bank_name"
                              onblur=" validate( event, 'required|integer') "
                              oninput=" validate( event, 'required|integer')"
                              @blur="validate_data()"
                              @input="validate_data()"
                              required="">
                        <option value="">Select Bank Name</option>
                        <option v-for="bank in banks"
                                :value="bank.id"
                                :key="bank.id">{{ bank.bank_name }}</option>
                      </select>

                      <div class="form-control" id="bank_nameError" style="display: none;"></div>
                    </div>

                    <div class="form-group">
                      <label for="type">Select Card Type</label>
                      <select id="type"
                              name="type"
                              class="custom-select"
                              v-model="form_link_card.type"
                              onblur=" validate( event, 'required|alpha') "
                              oninput=" validate( event, 'required|alpha')"
                              @blur="validate_data()"
                              @input="validate_data()"
                              required="">
                        <option value="">Card Type</option>
                        <option value="visa">Visa</option>
                        <option value="debit">Debit</option>
                      </select>

                      <div class="form-control" id="typeError" style="display: none;"></div>
                    </div>

                    <div class="form-group">
                      <label for="card_number">Card Number</label>
                      <input type="text"
                            class="form-control"
                            id="card_number"
                            name="card_number"
                            required=""
                            value=""
                            v-model="form_link_card.card_number"
                            placeholder="Card Number"
                            @blur="validate_data()"
                            @input="validate_data()"
                            onblur=" validate( event, 'required|integer|equals:16') "
                            oninput=" validate( event, 'required|integer|equals:16')"
                            >
                      <div class="form-control" id="card_numberError" style="display: none;"></div>
                    </div>

                    <div class="form-row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="expire_date">Expire Date</label>
                          <input id="expire_date"
                                  name="expire_date"
                                  type="text"
                                  class="form-control"
                                  required=""
                                  value=""
                                  v-model="form_link_card.expire_date"
                                  placeholder="MM/YY"
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  onblur=" validate( event, 'required|expire_date') "
                                  oninput=" validate( event, 'required|expire_date')">
                          <div class="form-control" id="expire_dateError" style="display: none;"></div>
                        </div>
                      </div>


                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="cvv">CVV
                            <span class="text-info ml-1"
                            data-toggle="tooltip"
                            title="Card Verification Value">
                            <i class="fas fa-question-circle">
                            </i>
                          </span>
                        </label>
                          <input id="cvv"
                                  name="cvv"
                                  type="text"
                                  class="form-control"
                                  required=""
                                  value=""
                                  v-model="form_link_card.cvv"
                                  placeholder="CVV (3 digits)"
                                  @blur="validate_data()"
                                  @input="validate_data()"
                                  onblur=" validate( event, 'required|integer|equals:3') "
                                  oninput=" validate( event, 'required|integer|equals:3')">
                          <div class="form-control" id="cvvError" style="display: none;"></div>
                        </div>
                      </div>


                    </div>

                    <div class="form-group">
                      <label for="holder_name">Card Holder Name</label>
                      <input type="text"
                              class="form-control"
                              id="holder_name"
                              name="holder_name"
                              required=""
                              value=""
                              v-model="form_link_card.holder_name"
                              placeholder="Card Holder Name"
                              @blur="validate_data()"
                              @input="validate_data()"
                              onblur=" validate( event, 'required|alpha_space') "
                              oninput=" validate( event, 'required|alpha_space')">
                        <div class="form-control" id="holder_nameError" style="display: none;"></div>
                    </div>

                    <button class="btn btn-primary btn-block"
                            @click="link_card"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Add Card
                      </button>

                  </form>
                </div>
              </div>
            </div>
          </div>


</template>


<script>
    export default {
        mounted() {
          this.load_banks();
        },


        data(){
          return{
            form_link_card: new Form({
              bank_name: "",
              type: "",
              card_number: "",
              holder_name: "",
              expire_date: "",
              cvv: "",
            }),

            isInvalid: true,

            banks:{},

          }
        }
        ,


        methods: {

          load_banks(){
            ECHO.$emit('START_LOADING');

            axios.get("api/get_bank_names")
                 .then(({data}) => (
                    this.banks = data
                  ));

            ECHO.$emit('END_LOADING');

          }//END of load_banks
          ,

          validate_data(){
            let form_link_card = document.forms["form_link_card"];

            for( let index = 0; index < form_link_card.length - 1; index++ ){

                let input = form_link_card.elements[ index ];

                if( input.value.trim() == "" ){
                  this.isInvalid = true;
                  return;
                }
                else if( document.getElementById(input.id+"Error").style.display == 'block' ){
                  this.isInvalid = true;
                  return;
                }
                else if( this.form_link_card.busy ){
                  this.isInvalid = true;
                  return;
                }

            }

            this.isInvalid = false;


          }
          ,

          link_card(){
            this.validate_data();
            ECHO.$emit('START_LOADING');
            //console.log(this.form_link_card);


            this.form_link_card.post('api/link_card')
                    .then(( response )=>{

                      let data = response.data;

                      if( data == 'success' ){
                        //Update card linkage *refresh page
                        toast.fire({
                            type: 'success',
                            title: 'Card Linked Successfully'

                        });
                        ECHO.$emit('END_LOADING');
                        window.location.assign('/bpa/card');
                      }
                      else{
                        //ALERT ERROR HAPPENED
                        console.log('ALERT ERROR HAPPENED C1');
                        this.show_error_to_link_modal();
                        some_thing_went_wrong.fire();
                        ECHO.$emit('END_LOADING');
                      }


                    })
                    .catch((error)=>{
                      //ALERT ERROR HAPPENED
                      console.log('ALERT ERROR HAPPENED C2');
                      this.show_error_to_link_modal();
                      ECHO.$emit('END_LOADING');
                  });

          }
          ,

          invalid_bank_name( ){
            StyleError( 'bank_name', 'bank_nameError' );
            ID( 'bank_nameError' ).innerHTML = this.form_link_card.errors.errors.bank_name;
          }
          ,

          invalid_card_type( ){
            StyleError( 'type', 'typeError' );
            ID( 'typeError' ).innerHTML = this.form_link_card.errors.errors.type;
          }
          ,

          invalid_card_number( ){
            StyleError( 'card_number', 'card_numberError' );
            let error_message = this.form_link_card.errors.errors.card_number;

            if( error_message.indexOf('taken') != -1 ){
              error_message +=  `<br>*If it is not you <a href="report">report</span>.`;
            }

            ID( 'card_numberError' ).innerHTML = error_message;
          }
          ,

          invalid_cvv( ){
            StyleError( 'cvv', 'cvvError' );
            ID( 'cvvError' ).innerHTML = this.form_link_card.errors.errors.cvv;
          }
          ,

          invalid_expire_date( ){
            StyleError( 'expire_date', 'expire_dateError' );
            ID( 'expire_dateError' ).innerHTML = this.form_link_card.errors.errors.expire_date;
          }
          ,

          invalid_holder_name( ){
            StyleError( 'holder_name', 'holder_nameError' );
            ID( 'holder_nameError' ).innerHTML = this.form_link_card.errors.errors.holder_name;
          }
          ,

          show_error_to_link_modal( ){

            if ( this.form_link_card.errors.any() ){

                if( this.form_link_card.errors.has('bank_name') ){
                    this.invalid_bank_name();
                }

                if( this.form_link_card.errors.has('type') ){
                    this.invalid_card_type();
                }

                if( this.form_link_card.errors.has('card_number') ){
                    this.invalid_card_number();
                }

                if( this.form_link_card.errors.has('cvv') ){
                    this.invalid_cvv();
                }

                if( this.form_link_card.errors.has('expire_date') ){
                    this.invalid_expire_date();
                }

                if( this.form_link_card.errors.has('holder_name') ){
                    this.invalid_holder_name();
                }
            }

          }
          ,
        }
        ,


        created() {

        },


    }
</script>
