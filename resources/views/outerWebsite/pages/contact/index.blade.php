@extends('outerWebsite.layouts.master')
@section('title', '- Contact us')

@section('content')
  @include('outerWebsite.pages.contact.partials.header')
  
  <div class="container mt-5">
      <div class="row">
        @include('outerWebsite.pages.contact.partials.info')
      
        <div class="col-12 mb-1">
      <div class="text-center py-5 px-2">
      <h2 class="text-8">Get in touch</h2>
      <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      	<div class="d-flex flex-column text-center">
              @include('layouts.social-media')
            </div>
      </div>
      </div>

      </div>
    </div>

    @include('outerWebsite.partials.awesome-customer-support')
    @include('outerWebsite.pages.contact.partials.contact-form')
        
      </div>
 </div>
@endsection
