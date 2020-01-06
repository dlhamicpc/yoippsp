@section('js')
<script>

  function closeSideBar( singlePageOrNot ){

    if( singlePageOrNot !== null ){
      if( singlePageOrNot ){
        $('#not_single_page').css('display' , 'block');
      }
      else{
        $('#not_single_page').css('display' , 'none');
      }
    }

    

    if (screen.width < 768){
      $('body')[0].className = "sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse";
    }
    
  }

</script>
@endsection
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-dark-primary">
    <!-- Brand Logo -->
    <router-link to="/bpa/dashboard" class="brand-link nav-success">
      <img src="{{ asset('/images/logo.png') }}" alt="Yoip Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Yoip PSP</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/storage/uploads/users_profile_picture/' . auth()->user()->avatar) }}" class="img-circle elevation-2" alt="profile picture"  id="profile_picture_sidebar">
        </div>
        <div class="info" style="color:white">
          <router-link to="/bpa/profile" class="d-block" onclick="closeSideBar(false);" id="full_name_side_bar">
          {{ ucwords($billPaymentUser->full_name) }}
        </router-link>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          

          <li class="nav-item">
            <router-link to="/bpa/dashboard" class="nav-link" 
            onclick="closeSideBar(false);change_active_color(this)" id="left-sidebar-dashboard">
              <i class="nav-icon fas fa-tachometer-alt white"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>


          <li class="nav-item has-treeview">
            <a href="" class="nav-link" id="left-sidebar-send-request">
              <i class="nav-icon fas fa-money-bill text-blue"></i>
              <p>
                Bill Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ url('/bpa/customer_list') }}" class="nav-link" onclick="closeSideBar(true);">
                  <i class="fa fa-users nav-icon text-yellow"></i>
                  <p>Customer List</p>
                </a>
              </li>

              <li class="nav-item">
                <router-link to="" class="nav-link" data-target="#start-payment"  data-toggle="modal" onclick="closeSideBar(null);">
                  <i class="fa fa-business-time nav-icon text-red"></i>
                  <p>Start Payment</p>
                </router-link>
              </li>

              <li class="nav-item">
                <a href="{{ url('/bpa/bill_summary') }}" class="nav-link" onclick="closeSideBar(true);">
                  <i class="fa fa-hand-paper nav-icon text-green"></i>
                  <p>Bill Summary</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('/bpa/payment_detail') }}" class="nav-link" onclick="closeSideBar(true);">
                  <i class="fa fa-newspaper nav-icon text-orange"></i>
                  <p>Payment Detail</p>
                </a>
              </li>

              <!-- <li class="nav-item">
                <router-link to="" class="nav-link" data-target="#request-money"  data-toggle="modal" onclick="closeSideBar(false);">
                  <i class="fa fa-cloud-download-alt nav-icon text-red"></i>
                  <p>Sync Database</p>
                </router-link>
              </li> -->

            </ul>
          </li>

          
          <li class="nav-item">
            <router-link to="/bpa/card" class="nav-link" onclick="closeSideBar(false);change_active_color(this)" id="card_bank_link">
              <i class="nav-icon fas fa-id-card white"></i>
              <p>
                Card / Bank Account
              </p>
            </router-link>
          </li>




          <li class="nav-item has-treeview">
            <a href="" class="nav-link" id="left-sidebar-send-request">
              <i class="nav-icon fas fa-arrow-alt-circle-right"></i>
              <p>
                Refund / Request
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="" class="nav-link" 
                onclick="closeSideBar(false);check_balance('#send-money')">
                  <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                  <p>Refund</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="" class="nav-link" data-target="#request-money"  data-toggle="modal" onclick="closeSideBar(false);">
                  <i class="far fa-arrow-alt-circle-left nav-icon"></i>
                  <p>Request Money</p>
                </router-link>
              </li>

            </ul>
          </li>




          <li class="nav-item has-treeview">
            <a href="" class="nav-link" id="left-sidebar-deposit-withdraw">
              <i class="nav-icon fas fa-arrows-alt-h"></i>
              <p>
                Deposit / Withdraw
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="" class="nav-link" onclick="closeSideBar(false);check_link_card_or_bank('#deposit-money')">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Deposit Money</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="" class="nav-link" onclick="closeSideBar(false);check_link_card_or_bank('#withdraw-money')">
                  <i class="fa fa-arrow-left nav-icon"></i>
                  <p>Withdraw Money</p>
                </router-link>
              </li>

            </ul>
          </li>


          <li class="nav-item">
                <router-link to="/bpa/transactions" class="nav-link" onclick="closeSideBar(false);change_active_color(this)" id="left-sidebar-transactions">
                  <i class="fa fa-history nav-icon"></i>
                  <p>Transactions</p>
                </router-link>
          </li>

          <li class="nav-item">
                <router-link to="" class="nav-link" 
                            data-target="#balance-wallet"  data-toggle="modal" 
                            onclick="closeSideBar(false);">
                  <i class="fa fa-wallet nav-icon"></i>
                  <p>Balance</p>
                </router-link>
          </li>

<!-- 
          <li class="nav-header">Services</li>
          <li class="nav-item has-treeview">
            <a href="" class="nav-link" id="left-sidebar-bill-payments">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                Billpayments
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="/card" class="nav-link" onclick="closeSideBar(false);">
                  <i class="fa fa-water nav-icon"></i>
                  <p>Water Billpayment</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/card" class="nav-link" onclick="closeSideBar(false);">
                  <i class="fa fa-lightbulb nav-icon"></i>
                  <p>Electricity Billpayment</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/card" class="nav-link" onclick="closeSideBar(false);">
                  <i class="fa fa-tv nav-icon"></i>
                  <p>DSTV Billpayment</p>
                </router-link>
              </li>

            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="" class="nav-link" id="left-sidebar-tickets">
              <i class="nav-icon fas fa-vr-cardboard"></i>
              <p>
                Buy Ticket
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="/card" class="nav-link" onclick="closeSideBar(false);">
                  <i class="fa fa-tv nav-icon"></i>
                  <p>Cinema Ticket</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/card" class="nav-link" onclick="closeSideBar(false);">
                  <i class="fa fa-plane nav-icon"></i>
                  <p>Airplane Ticket</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/card" class="nav-link" onclick="closeSideBar(false);">
                  <i class="fa fa-bus nav-icon"></i>
                  <p>Bus Ticket</p>
                </router-link>
              </li>

            </ul>
          </li> -->


          <li class="nav-header">Others</li>


          


          <li class="nav-item has-treeview">
            <a href="" class="nav-link" id="left-sidebar-settings">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="/bpa/profile" class="nav-link" onclick="closeSideBar(false);change_active_color(this)" id="left-sidebar-profile">
                  <i class="far fa-user nav-icon"></i>
                  <p>Profile</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/bpa/card" class="nav-link" onclick="closeSideBar(false);change_active_color(this)" id="left-sidebar-cards">
                  <i class="far fa-id-card nav-icon"></i>
                  <p>Cards & Bank Accounts</p>
                </router-link>
              </li>
<!-- 
              <li class="nav-item">
                <router-link to="/bpa/bill_payment_settings" class="nav-link" onclick="closeSideBar(false);change_active_color(this)" id="left-sidebar-cards">
                  <i class="far fa-id-card nav-icon"></i>
                  <p>Bill payments</p>
                </router-link>
              </li> -->

              <li class="nav-item">
                <router-link to="/bpa/notification_settings" class="nav-link" onclick="closeSideBar(false);change_active_color(this)" id="left-sidebar-notifications">
                  <i class="far fa-bell nav-icon"></i>
                  <p>Notifications</p>
                </router-link>
              </li>

            </ul>
          </li>

          
          <li class="nav-item">
                <router-link to="/bpa/exchange-rate" class="nav-link" onclick="closeSideBar(false);change_active_color(this)" id="left-sidebar-exchange-rates">
                  <i class="fa fa-dollar-sign nav-icon"></i>
                  <p>Exchage Rate</p>
                </router-link>
          </li>

          <li class="nav-item">
                <a href="{{ url('http://yoippsp.com/help') }}" class="nav-link" onclick="closeSideBar(false);">
                  <i class="fa fa-question nav-icon"></i>
                  <p>Help</p>
                </a>
          </li>

          

          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" 
                onclick="event.preventDefault();
                document.getElementById('logout-form-left-sidebar').submit();closeSideBar(false);">
                <i class="nav-icon fa fa-power-off red"></i>
                <p>
                  {{ __('Logout') }}
                </p>                             
            </a>

            <form id="logout-form-left-sidebar" action="{{ route('logout') }}" method="POST" 
                  style="display: none;">
                  @csrf
            </form>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>