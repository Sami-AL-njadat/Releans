   <div class="main-sidebar sidebar-style-2">

       @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
           <aside id="sidebar-wrapper">
               <div class="sidebar-brand">
                   <a href="index.html">Releans</a>
               </div>
               <div class="sidebar-brand sidebar-brand-sm">
                   <a href="index.html">Rs</a>
               </div>
               <ul class="sidebar-menu">
                   <li class="menu-header">Dashboard</li>
                   <li>
                       <a href="{{ route('dashboards') }}" class="nav-link"><i
                               class="fas fa-fire"></i><span>Dashboard</span></a>

                   </li>

                   <li><a class="nav-link" href="{{ route('product.page') }}"><i class="fas fa-columns"></i>
                           <span>Product
                               Page</span></a>
                   </li>
                   <li><a class="nav-link" href="{{ route('stock.page') }}"><i class="fas fa-plug"></i> <span>Stock
                               Page</span></a></li>

                   <li class="dropdown">
                       <a href="{{ route('user.page') }}" class="nav-link "><i class="far fa-user"></i>
                           <span>Auth</span></a>

                   </li>
                   <li class="dropdown">
                       <a href="{{ route('sale.page') }}" class="nav-link "><i class="fas fa-dollar-sign"></i>
                           <span>Sale</span></a>

                   </li>




               </ul>


           </aside>
       @else
           <aside id="sidebar-wrapper">
               <div class="sidebar-brand">
                   <a href="index.html">Releans</a>
               </div>
               <div class="sidebar-brand sidebar-brand-sm">
                   <a href="index.html">Rs</a>
               </div>
               <ul class="sidebar-menu">
                   <li class="menu-header">Shop</li>
                   <li>
                       <a href="{{ route('shop.page') }}" class="nav-link"><i
                               class="fas fa-fire"></i><span>Shop</span></a>

                   </li>
               </ul>

           </aside>
       @endif

   </div>
