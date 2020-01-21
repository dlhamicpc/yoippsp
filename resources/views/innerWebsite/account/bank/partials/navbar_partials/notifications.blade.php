   <!-- Notifications Dropdown Menu -->
   <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">@{{ notification.notificationCount }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          <span class="dropdown-header" v-if="notification.notificationCount">
            @{{ notification.notificationCount }} New Notifications
          </span>

          <span class="dropdown-header" v-else>
            No New Notifications yet
          </span>


          <div  v-for="notify in notification.notificationMessagesSample" :key="notify.id">
          <div class="dropdown-divider"></div>
          
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <span v-html="image_or_icon(notify.image, notify.sender_id)"></span>
              
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  @{{ notify.sender_name | ucwords }}
                </h3>
                <p class="text-sm">@{{ notify_message(notify.message) }}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> @{{ notify.created_at | from_now }}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>

          </div>
          

          <div class="dropdown-divider"></div>
          
          <router-link to="/bank/notification_history" 
          class="dropdown-item dropdown-footer" 
          onclick="closeSideBar();"
          id="navbar-notifications_view"
          v-if="notification.notificationCount">
          See All Notifications
          </router-link>
          
        </div>
      </li>

     