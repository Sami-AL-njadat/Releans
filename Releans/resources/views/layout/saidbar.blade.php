   <div class="main-sidebar sidebar-style-2">
       <aside id="sidebar-wrapper">
           <div class="sidebar-brand">
               <a href="index.html">Stisla</a>
           </div>
           <div class="sidebar-brand sidebar-brand-sm">
               <a href="index.html">St</a>
           </div>
           <ul class="sidebar-menu">
               <li class="menu-header">Dashboard</li>
               <li>
                   <a href="{{ route('dashboards') }}" class="nav-link"><i
                           class="fas fa-fire"></i><span>Dashboard</span></a>

               </li>

               <li><a class="nav-link" href="{{ route('product.page') }}"><i class="fas fa-columns"></i> <span>Product
                           Page</span></a>
               </li>
               <li><a class="nav-link" href="{{ route('stock.page') }}"><i class="fas fa-plug"></i> <span>Stock
                           Page</span></a></li>

               <li class="dropdown">
                   <a href="{{ route('user.page') }}" class="nav-link "><i class="far fa-user"></i>
                       <span>Auth</span></a>

               </li>





           </ul>


       </aside>

   </div>
