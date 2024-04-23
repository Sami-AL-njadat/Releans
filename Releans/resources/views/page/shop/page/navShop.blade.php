 <div class="navbar-bg">
 </div>

 <nav class="navbar navbar-expand-lg main-navbar">
     <form class="form-inline mr-auto">
         <ul class="navbar-nav mr-3">

         </ul>

     </form>
     <ul class="navbar-nav navbar-right">
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
