<!-- How work============================================= -->
    <section class="section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="card bg-dark-3 shadow-sm border-0"> 
            <img class="card-img opacity-8" 
            src="{{ asset('/images/outerWebsite/how-work.jpg') }}" alt="banner">
              <div class="card-img-overlay p-0"> <a class="d-flex h-100 video-btn" 
              href="#" 
              data-src="{{ asset('/videos/outerWebsite/sv.mp4') }}" 
              data-toggle="modal" data-target="#videoModal"> <span class="btn-video-play bg-white shadow-md rounded-circle m-auto"><i class="fas fa-play"></i></span> </a> </div>
            </div>
          </div>
          <div class="col-lg-6 mt-5 mt-lg-0">
            <div class="ml-4">
              <h2 class="text-9">How does it work?</h2>
              <p class="text-4">Quidam lisque persius interesset his et, in quot quidam persequeris essent possim iriure. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <ul class="list-unstyled text-3 line-height-5">
                <li><i class="fas fa-check mr-2"></i>Sign Up Account</li>
                <li><i class="fas fa-check mr-2"></i>Receive & Send Payments from worldwide</li>
                <li><i class="fas fa-check mr-2"></i>Your funds will be transferred to your local bank account</li>
              </ul>
              
              @include('outerWebsite.partials.buttons.open-account-outline')

              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- How work end -->