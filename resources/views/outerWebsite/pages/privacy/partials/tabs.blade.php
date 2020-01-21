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

        <div class="bg-light-3">
          <div id="verticalTab">
            <div class="row no-gutters">
              <div class="col-md-3 my-0 my-md-3">
                <ul class="resp-tabs-list">

                  <li class="btn text-left">
                  <i class="fa fa-fire mr-2"></i>
                  Overview
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  What Personal Data Do We Collect?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Why Do We Retain Personal Data?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  How Do We Process Persoanl Data?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Do We Share Personal Data?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  How Do We Work with Other Services and Platforms?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  How Do We Use Cookies and Tracking Technologies?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  What Privacy Choices Are Available To You?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  How Do We Protect Your Personal Data?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Can Children Use Our Services?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  What Else Should You Know?
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Contact Us
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Definitions
                  </li>

                  <li class="btn text-left">
                  <i class="fab fa-twitter mr-2"></i>
                  Additional Information
                  </li>
                  
                </ul>
              </div>
              <div class="col-md-9">
                <div class="resp-tabs-container bg-light shadow-md rounded h-100 p-2">
                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.overview')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.what-personal-data-we-collect')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.why-do-we-retain-personal-data')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.how-do-we-process-personal-data')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.do-we-share-personal-data')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.how-do-we-work-with-other-services-and-platforms')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.how-do-we-use-cookies-and-tracking-technologies')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.what-privacy-choices-are-available-to-you')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.how-do-we-protect-your-personal-data')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.can-children-use-our-services')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.what-else-should-you-know')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.contact-us')
                    </p>
                  </div>
                  
                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.definitions')
                    </p>
                  </div>

                  <div>
                    <p>
                    @include('outerWebsite.pages.privacy.partials.additional-info')
                    </p>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Responsive Vertical Tab end -->