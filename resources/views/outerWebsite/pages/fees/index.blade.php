@extends('outerWebsite.layouts.master')
@section('title', '- Fees')

@include('outerWebsite.pages.fees.partials.banner')

@section('content')
    <section class="section pt-5 pb-0">
      <div class="container">
        <div class="row">
        
        
        @include('outerWebsite.pages.fees.partials.withdrawal-fee')
        @include('outerWebsite.pages.fees.partials.deposit-fee')
        @include('outerWebsite.pages.fees.partials.receive-fee')
        @include('outerWebsite.pages.fees.partials.send-fee')
        @include('outerWebsite.pages.fees.partials.bill-payment-fee')
        @include('outerWebsite.pages.fees.partials.administrative-fee')

       
        </div>
      </div>
    </section>
    
    <!-- Content============================================= -->
    <section class="section bg-primary">
      <div class="container text-center">
        <h2 class="text-9 text-white"> Open a free account in minutes.</h2>
        <p class="text-5 text-white mb-4">Quickly and easily send, receive and request money. Over 180 countries and 80 currencies supported.</p>
        
    @include('outerWebsite.partials.buttons.open-account-light')

        </div>
    </section>
    <!-- Banner end --> 
    
    @include('outerWebsite.partials.mobile-with-image')
    @include('outerWebsite.partials.video-modal') 
    
@endsection