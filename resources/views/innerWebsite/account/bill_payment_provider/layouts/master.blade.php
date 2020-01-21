<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Yoip')</title>

  @include('innerWebsite.account.bill_payment_provider.assets.css')
  @yield('css')

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" id="body">

<div id="preloader" style="display: none;">
  <div data-loader="dual-ring"></div>
</div>

<div class="wrapper" id="app">

    @include('innerWebsite.account.bill_payment_provider.partials.navbar')

    @include('innerWebsite.account.bill_payment_provider.partials.left_sidebar')

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

                <bill-management></bill-management>

                <div id="not_single_page">
                  @yield('content')
                </div>
                
                
            </div>
        </div>
        <!-- Content end -->
    </div>
    <!-- /.content-wrapper -->

    @include('innerWebsite.account.bill_payment_provider.partials.footer')



</div>
<!-- ./wrapper -->
@auth
  <script type="text/javascript">

    
    window.user = @json(auth()->user());

    window.userDetails = @json($billPaymentUser);

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
            window.location.assign('/bpa/card');
          }
                  
        });
      }
      else{
        let approved_cards_count = 0;
        let approved_banks_count = 0;


        @foreach( $userBankLinks as $userBankLink )
          @if( $userBankLink->approved == 'yes' )
            approved_banks_count += 1
          @endif
        @endforeach

        @foreach( $userCardLinks as $userCardLink )
          @if( $userCardLink->approved == 'yes' )
            approved_cards_count += 1
          @endif
        @endforeach

        if( approved_cards_count == 0 && approved_banks_count == 0 ){

          swal.fire({
            title: 'Notice',
            text: 'None of your bank Account or Card link has been approved! \nBefore you deposit or withdraw, first you need to go to the nearest bank you use and get approval.' ,
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Okay',
         });

        }
        else{
          $(modal_name).modal('show');
        }
        
      }
    }
  </script>
@endauth

@include('innerWebsite.account.bill_payment_provider.assets.js')
@yield('js')



</body>
</html>
