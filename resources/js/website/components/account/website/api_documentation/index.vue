<style scoped>
    .code {
        text-align: left;
        font-size: 13px;
        font-family: Roboto,Arial,sans-serif;
        line-height: 1.428571;
    }
</style>

<template>

    



        <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-book"></i>
                     &nbsp;API Documentation
                  </h3>
                </div>
                <div class="card-body">
                  
                  <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-content-above-php-tab" data-toggle="pill" href="#custom-content-above-php" role="tab" aria-controls="custom-content-above-php" aria-selected="true">PHP</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-content-above-java-tab" data-toggle="pill" href="#custom-content-above-java" role="tab" aria-controls="custom-content-above-java" aria-selected="false">JAVA</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-content-above-python-tab" data-toggle="pill" href="#custom-content-above-python" role="tab" aria-controls="custom-content-above-python" aria-selected="false">PYTHON</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-content-above-nodejs-tab" data-toggle="pill" href="#custom-content-above-nodejs" role="tab" aria-controls="custom-content-above-nodejs" aria-selected="false">Nodejs</a>
                    </li>
                  </ul>
                  <div class="tab-custom-content">
                    <p class="lead mb-0"> These sections will guide you on how to develop and test ThemRau’s payment method integration with your application. </p>
                  </div>
                  <div class="tab-content" id="custom-content-above-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-above-php" role="tabpanel" aria-labelledby="custom-content-above-php-tab">
                            <div class="col-sm-9 wedocs-single-content">
                                                
                                <div class="col-md-12">
                            
                                    <article>
                            
                                    
                            
                                        <div class="entry-content" itemprop="articleBody">
                            
                                            
                            
                            
                            
                            <h3 id="installation">Installation<a class="anchorjs-link " href=""></a></h3>
                            
                            
                            
                            <h6>Step 1. Download the SDK</h6>
                            
                            
                            
                            <p><button type="button" class="btn btn-outline-primary btn-lg">
                                    <i class="nav-icon fas fa-download"></i>&nbsp;PHP SDK</button></p>
                            
                            
                            
                            <h6> Step 2. Extract the SDK zip file.</h6>

                            <h6> Step 3. Add to your project</h6>
                            
                            <h6>Step 4. Add your private key to your project</h6>

                            <p>First go to your ThemRau account dashboard and click on the API Key / Webhook link then you will see your private key copy that key and add it to your project or if you are using a framework add it to .env file.</p>

<span class="btn btn-default code">
<pre>

YOIPPSP_PRIVATE_KEY=$2y$10$4OWBziyRQTo4SA9I4ZdOJuwuhrlRvIE14rYt3X2ta4UYpdFLcKVNC
YOIPPSP_PUBLIC_KEY=$2y$10$6FDH.vnMip7Fiq1z31xeB.UK3bgXLT9QiivGfAskFgm7jbKMD0t3e
</pre>

</span>


                            
                            <h6>Step 5. Generate checkout URL</h6>
                            
                            
                            
                            <p>First go to your ThemRau account dashboard and click on the API Key / Webhook link then provide the callback and webhook url after this generate a Checkout Url or if you are using a framework add the following routes to your route file.</p>
                            
                            
                            <span class="btn btn-default code">
<pre>

Route::post('/pay', 'YoippspPaymentGateway\YoippspPaymentController@redirect_to_yoippsp_gateway')->name('pay');

Route::get('/callback', 'YoippspPaymentGateway\YoippspPaymentController@handle_callback');
</pre>
                                    
                                </span>
                            
                            
                            
                    
                            
                            <br><br>
                            <p>Once you have that, set the following inforamtion that are found in <code>YoippspPaymentController</code> Class <code>set_checkout()</code> method.</p>
                            
                            
                            <p>A sample implementation is shown below</p>
                            <span class="btn btn-default code">
<pre>

private function set_checkout()
{
    $this->payer_identification = 929194872;
    $this->amount = 600;
    $this->metadata = array(
        'encrypted' => false, // if you want your data to be encrypted set this value to 'true'.
        'share_data' => array(  // delete this array if your website type is not 'delala'. 
            'you_share' => 200,
            'third_party_merchant_share' => 400,
            'third_party_merchant_email' => 'hotel@gmail.com'
        ),
        'content' => array(
            'item_1' => array(
                'title' => 'shoe',
                'description' => 'shoe',
                'price' => 200
            ),
            'item_2' => array(
                'title' => 'shoe',
                'description' => 'shoe',
                'price' => 200
            ),
            'item_3' => array(
                'title' => 'shoe',
                'description' => 'shoe',
                'price' => 200
            )   
        )
    );
}
</pre>
                                    
                                </span>
                            
                            
                            
                           
                            
                            
                            
                            <h4>Step 6. Redirect your customer</h4>
                            
                            
                            
                            <p>Redirect your customer to the checkout URL generated in the step above. Your customer will then be taken to our checkout page, complete the payment with his/her ThemRau account. Once a payment has been successfully completed, we will send you an Instant Payment Notification (IPN) to the URL you provided on the CheckoutOptions object in the step above. When you receive this notification, you should query our IPN verification url to make sure it is an authentic notification initiated by our servers.</p>
                            
                            
                            
                            <p>A sample implementation is shown below</p>

                            <p>Redirect your customer</p>
                            <span class="btn btn-default code">
<pre>
public function redirect_to_yoippsp_gateway()
{
    $this->set_checkout();

    $this->send_payment_data_to_yoippsp();

    if( $this->response_content->status == 'success' ) {
        $unique_url_slug = $this->response_content->data->id;
        return redirect("http://gateway.yoippsp.com/pay/$unique_url_slug");
    }
    else{
        dd($this->response_content);
    }
    
}

</pre>


                            </span>


                            <p>Query our IPN verification</p>

<span class="btn btn-default code">
<pre>
public function handle_callback()
{
$this->payer_identification = 929194872;
$this->request_payment_data_from_yoippsp();

dd($this->response_content);
}

</pre>


</span>
                            
                            
                            
                </div>
                            
                                       
                            
                                        
                            
                                    </article>
                                </div><!-- .col-md-# -->
                                </div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-above-java" role="tabpanel" aria-labelledby="custom-content-above-java-tab">
                       Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam. 
                    </div>
                    <div class="tab-pane fade" id="custom-content-above-python" role="tabpanel" aria-labelledby="custom-content-above-python-tab">
                       Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. 
                    </div>
                    <div class="tab-pane fade" id="custom-content-above-nodejs" role="tabpanel" aria-labelledby="custom-content-above-nodejs-tab">
                       Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis. 
                    </div>
                  </div>
                </div>
                <!-- /.card -->
              </div>









</template>

<script>
    export default {
        mounted() {
            
        }
    }
</script>