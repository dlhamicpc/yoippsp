<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-primary  border-bottom-0">

    @include('innerWebsite.account.bill_payment_provider.partials.navbar_partials.links')

    @include('innerWebsite.account.bill_payment_provider.partials.navbar_partials.search_form')


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      @include('innerWebsite.account.bill_payment_provider.partials.navbar_partials.notifications') 

      @include('innerWebsite.account.bill_payment_provider.partials.navbar_partials.profile')
      
    </ul>
  </nav>
  <!-- /.navbar -->