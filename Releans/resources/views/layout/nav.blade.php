             <div class="navbar-bg">
             </div>

             <nav class="navbar navbar-expand-lg main-navbar">
                 <form class="form-inline mr-auto">
                     <ul class="navbar-nav mr-3">
                         <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                     class="fas fa-bars"></i></a></li>
                         <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                                     class="fas fa-search"></i></a></li>
                     </ul>

                 </form>
                 <ul class="navbar-nav navbar-right">
                     @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                         <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                 class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                             <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                 <div class="dropdown-header">Notifications
                                     <div class="float-right">
                                         <a style="color: black" href="#" onclick="markAllAsRead()"
                                             class="nav-link">Mark All As Read</a>
                                     </div>
                                 </div>
                                 <div style="height: auto !important" class="dropdown-list-content dropdown-list-icons">


                                 </div>
                                 <div class="dropdown-footer text-center">
                                     <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                                 </div>
                             </div>
                         </li>
                     @endif
                     <li class="dropdown"><a href="#" data-toggle="dropdown"
                             class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                             @auth

                                 <img alt="image" src="{{ Auth::user()->image }}" class="rounded-circle mr-1">
                             @endauth
                             <div class="d-sm-none d-lg-inline-block">
                                 @auth
                                     Hi, {{ Auth::user()->name }}
                                 @endauth
                             </div>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right">
                             <a href="{{ route('Profile.page') }}" class="dropdown-item has-icon">
                                 <i class="far fa-user"></i> Profile
                             </a>


                             <div class="dropdown-divider"></div>
                             <a href="#" id="logout-button" class="dropdown-item has-icon text-danger">
                                 <i class="fas fa-sign-out-alt"></i> Logout
                             </a>
                         </div>
                     </li>
                 </ul>
             </nav>

             <script>
                 function fetchNotifications() {
                     fetch('http://127.0.0.1:8000/api/notifications')
                         .then(response => response.json())
                         .then(data => {
                             console.log('Received data:', data); // Log the received data
                             if (data.status === 200) {
                                 document.querySelector('.dropdown-list-content').innerHTML = '';
                                 const currentTime = new Date();

                                 // Ensure data.inventory is an array
                                 if (Array.isArray(data.inventory)) {
                                     data.inventory.forEach(notification => {
                                         const updatedAt = new Date(notification.updated_at);
                                         const hours = updatedAt.getHours().toString().padStart(2, '0');
                                         const minutes = updatedAt.getMinutes().toString().padStart(2, '0');
                                         const formattedTime = `${hours}:${minutes}`;
                                         const timeDifference = Math.floor((currentTime - updatedAt) / (1000 * 60));
                                         const timeAgo = timeDifference > 0 ? `${timeDifference} minute(s) ago` :
                                             'just now';

                                         const notificationItem = `
                                <a  style="background-color: #6777ef !important;color: white" href="#" class="dropdown-item">
                                    <div class="dropdown">
                                        ${notification.product_name} has low stock.
                                        <div class="time">At ${formattedTime} Hour (${timeAgo})</div>
                                    </div>
                                </a>
                            `;
                                         document.querySelector('.dropdown-list-content').innerHTML += notificationItem;
                                     });
                                 } else {
                                     console.error('Invalid data format: data.inventory is not an array');
                                 }
                             } else {
                                 console.error('Received data with status:', data.status);
                             }
                         })
                         .catch(error => console.error('Error fetching notifications:', error));
                 }

                 fetchNotifications();

                 setInterval(fetchNotifications, 60000);
             </script>



             <script>
                 function markAllAsRead() {
                     const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                     fetch('http://127.0.0.1:8000/api/markAllRead', {
                             method: 'POST',
                             headers: {
                                 'Content-Type': 'application/json',
                                 'X-CSRF-TOKEN': token

                             },
                             body: JSON.stringify({}),
                         })

                         .then(response => {
                             if (response.status === 200) {

                             } else {
                                 console.error('Failed to mark all notifications as read');
                             }
                         })
                         .catch(error => console.error('Error marking all notifications as read:', error));
                 }
             </script>

             <script>
                 const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                 document.getElementById('logout-button').addEventListener('click', function(event) {
                     event.preventDefault();

                     const access_tokens = localStorage.getItem('access_token');
                     console.log(access_tokens, 'sss');
                     if (!access_tokens) {
                         console.error('Access token not found in local storage');
                         return;
                     }
                     const access_token = access_tokens.split('|')[1];

                     fetch(`http://127.0.0.1:8000/api/logout/delete/${access_token}`, {
                             method: 'DELETE',
                             headers: {
                                 'X-CSRF-TOKEN': token
                             }
                         })
                         .then(response => {
                             if (response.ok) {
                                 localStorage.clear();

                                 window.location.href = 'http://127.0.0.1:8000/loginPage';

                             } else {
                                 console.error('Logout failed');
                             }
                         })
                         .catch(error => console.error('Error:', error));
                 });
             </script>
