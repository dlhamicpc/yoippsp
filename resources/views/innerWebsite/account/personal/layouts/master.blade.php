<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Yoip')</title>

  @include('innerWebsite.account.personal.assets.css')
  @yield('css')

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" id="body">

<div id="preloader" style="display: none;">
  <div data-loader="dual-ring"></div>
</div>

<div class="wrapper" id="app">

    @include('innerWebsite.account.personal.partials.navbar')

    @include('innerWebsite.account.personal.partials.left_sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content============================================= -->
        <div id="content" class="py-4">
            <div class="container">

                <ring-loader :loading="loading" :size="'100px'"></ring-loader>
                <router-view></router-view>
                <send-money></send-money>
                <request-money></request-money>
                <deposit-money></deposit-money>
                <withdraw-money></withdraw-money>
                <balance-wallet></balance-wallet>
                
            </div>
        </div>
        <!-- Content end -->
    </div>
    <!-- /.content-wrapper -->

    @include('innerWebsite.account.personal.partials.footer')



</div>
<!-- ./wrapper -->
@auth
  <script type="text/javascript">    
    window.user = @json(auth()->user());

    window.userDetails = @json($personalUser);

    window.settings = JSON.parse(window.userDetails.settings);


    let userCardLinks = new Object();
    let card_index = 0;

    @foreach( $userCardLinks as $userCardLink )
      userCardLinks[ card_index++ ] = {
        'card':@json($userCardLink),
        'bank':@json($userCardLink->bank)
      }
    @endforeach

    window.userCardLinks = userCardLinks;
    
    ///
    let userBankLinks = new Object();
    bank_index = 0;

    @foreach( $userBankLinks as $userBankLink )
      userBankLinks[ bank_index++ ] = {
        'account':@json($userBankLink),
        'bank':@json($userBankLink->bank)
      }
    @endforeach

    window.userBankLinks = @json($userBankLinks);

    window.transactions = @json($transactions);

    ///
    let userBillPaymentLinks = new Object();
    bill_index = 0;

    

    @foreach( $userBillPaymentLinks as $userBillPaymentLink )
      
      window.u = @json($userBillPaymentLink);
      var type = u.type;
      if( type == 0 ) {
        userBillPaymentLinks[ 'water' ] = @json($userBillPaymentLink)
      }

      else if( type == 1 ) {
        userBillPaymentLinks[ 'electricity' ] = @json($userBillPaymentLink)
      }

      else if( type == 2 ) {
        userBillPaymentLinks[ 'dstv' ] = @json($userBillPaymentLink)
      }


    @endforeach

    if( userBillPaymentLinks.water == undefined ){
      userBillPaymentLinks['water'] = Object();
    }

    if( userBillPaymentLinks.electricity == undefined ){
      userBillPaymentLinks['electricity'] = Object();
    }

    if( userBillPaymentLinks.dstv == undefined ){
      userBillPaymentLinks['dstv'] = Object();
    }

    window.userBillPaymentLinks = userBillPaymentLinks;


    function check_link_card_or_bank( modal_name ) {
      count_banks = {{ count($userBankLinks) }};
      count_cards = {{ count($userCardLinks) }};

      if(  count_cards == 0 && count_banks == 0 ){
        swal.fire({
          title: 'Notice',
          text: 'You haven\'t linked any card or bank account! \nBefore you deposit or withdraw, first you need to link a valid card or bank account.' ,
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Go to Card and Bank Account',
        }).then((result) => {
                  
          if ( result.dismiss == 'cancel' ){
            return;
          }
          else{
            window.location.assign('/pa/card');
          }
                  
        });
      }
      else{
        $(modal_name).modal('show');
      }
    }
  </script>
@endauth

@include('innerWebsite.account.personal.assets.js')
@yield('js')



</body>
</html>
