<!-- Script --> 
<script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script> 
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/vendor/owl.carousel/owl.carousel.min.js') }}"></script> 
<script src="{{ asset('/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('/vendor/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/js/sweetAlertFunctions.js') }}"></script>
<script src="{{ asset('/js/validate.js') }}"></script>
<script src="{{ asset('/js/outerWebsite.js') }}"></script>

<script>

  // for alerting contact us or subscribe
  @if($message = session('message') )
            success('{{ $message }}')
  @endif

  // to notify is the user already subscribed
  @if( $error = $errors->first('email') )
    @if( strpos($error, 'already') )

      info('{{ $error }}')

    @endif
  @endif

</script>


