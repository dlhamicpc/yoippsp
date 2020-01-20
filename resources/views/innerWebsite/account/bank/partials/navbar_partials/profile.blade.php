   <!-- Profile Dropdown Menu -->
   <li class="nav-item dropdown">
        <div class="user-panel d-flex"  data-toggle="dropdown">

            <div class="image">
            <img src="{{ asset('/storage/uploads/users_profile_picture/'. auth()->user()->avatar) }}" class="img-circle elevation-2" alt="profile picture"  id="profile_picture_dropdown">
            </div>
           
        </div>
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        <router-link to="/bank/profile" onclick="closeSideBar();">
        <div class="user-panel mt-2 pb-2 d-flex">
        

            <div class="image">
            <img 
            src="{{ asset('/storage/uploads/users_profile_picture/'. auth()->user()->avatar) }}" 
            class="img-circle elevation-2 mt-2" alt="profile picture" id="profile_picture_navbar">
            </div>

            <div class="info" style="color:black;">
            <span class="d-block" id="full_name_nav_bar">{{ ucwords($bankUser->full_name) }}</span>
            <span class="d-block" id="email_nav_bar">{{ Auth::user()->email }}</span>
            </div>

            

           
        </div></router-link>


          <div class="dropdown-divider"></div>  
          <router-link to="/bank/profile" class="dropdown-item" onclick="closeSideBar();">
            <i class="fas fa-user mr-2"></i>
            Profile 
          </router-link>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}" 
                onclick="event.preventDefault();
                document.getElementById('logout-form-navbar').submit();">
                <i class="fa fa-power-off red mr-2"></i>
                
                  {{ __('Logout') }}
               
                <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" 
                  style="display: none;">
                  @csrf
            </form>                            
        </a>

    

        </div>
      </li>