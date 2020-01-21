<section class="container mb-5 pb-3">
      <div class="wizard">
        <div class="wizard-body pt-3">
          <h2 class="h4 text-center">Drop us a line</h2>
          <p class="text-muted text-center">We will get back to you as soon as possible</p>

          <form class="needs-validation {{
$errors->first('full_name') || $errors->first('contact_email') || $errors->first('body')? 'was-validated':''
          }}" novalidate="" action="{{ url('/contact') }}" method="POST">
         
            <div class="row pt-3">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="contact-name">Your Name <span class="text-danger font-weight-medium">*</span></label>

                  <input class="form-control" 
                  type="text" 
                  id="contact-name" 
                  name="full_name"
                  placeholder="Abdulmejid Shemsu"
                  value="{{ old('full_name', '') }}" 
                  required="">
                  <div class="invalid-feedback text-2">Please enter your name!   
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="contact-email">Your Email <span class="text-danger font-weight-medium">*</span></label>

                  <input class="form-control" 
                        type="email" 
                        id="contact-email" 
                        name="contact_email"
                        placeholder="dlham@gmail.com"
                        value="{{ old('contact_email', '') }}" 
                        required="">

                      <div class="invalid-feedback text-2">Please provide a valid email address!   
                      </div>
                  
                </div>
              </div>
            </div> 
            <div class="form-group">
              <label for="contact-message">Message <span class="text-danger font-weight-medium">*</span></label>

              <textarea class="form-control" rows="7"  wrap="soft"
              id="contact-message" 
              name="body"
              placeholder="Let us know more what's on your mind..."
              value="{{ old('body', '') }}" 
              required="" >
              </textarea>
                <div class="invalid-feedback text-2">Please write a message!  
                </div>
              
            </div>
            <div class="text-center">
              <button class="btn btn-primary btn-lg" type="submit" 
              data-original-title="Send Message"
              >Send Message<i class="ml-3 fas fa-paper-plane"></i></button>
            </div>
            @honeyPot
            @csrf
          </form>


        </div>
      </div>
    </section>

    
                            

                        