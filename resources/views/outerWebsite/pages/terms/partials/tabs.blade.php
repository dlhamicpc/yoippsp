 @section('css')
 <style>
    .text-left{
    
        text-align:left;
        border-bottom-left-radius:0px;
        border-bottom-right-radius:0px;
        border-top-right-radius:0px;
    }
    .b-b-l{
        border-bottom-left-radius:5px;
    }
 </style>
 @endsection   
    
    <!-- Responsive Vertical Tab============================================= -->

        <div class="bg-light-5">
          <div id="verticalTab">
            <div class="row no-gutters">
              <div class="col-md-3 my-0 my-md-3">
                <ul class="resp-tabs-list">

                  <li class="btn text-left">
                  <i class="fa fa-fire mr-2"></i>
                  Note
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Payment Services and Eligibility
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Sending Payments
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Eligibility for Use
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Account Balances
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Withdrawing Money
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Closing Your Account
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  PayPal Buyer Protection
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Unauthorized Transactions
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  PayPal Seller Protection
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Restricted Activities
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Your Liability - Actions We May Take
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Disputes with PayPal
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  General Terms
                  </li>
                  
                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Definitions
                  </li>
                  
                </ul>
              </div>
              <div class="col-md-9">
                <div class="resp-tabs-container bg-light shadow-md rounded h-100 p-2">
                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.note')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.payment-service-and-eligibility')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.sending-payments')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.eligibility-for-use')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.account-balances')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.withdrawing-money')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.closing-your-account')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.paypal-buyer-protection')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.unauthorized')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.paypal-seller-protection')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.restricted-activities')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.your-liability')
                    </p>
                  </div>
                  
                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.disputes-with-paypal')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.general-terms')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.terms.partials.definitions')
                    </p>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Responsive Vertical Tab end -->