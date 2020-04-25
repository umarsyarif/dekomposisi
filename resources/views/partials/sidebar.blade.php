<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <center>
        <a href="{{route('home')}}" class="brand-link mb-3 justify-content-center">
          <img src="{{asset('images/crystalball.png')}}" alt="AdminLTE Logo" class="img-circle elevation-3 mb-3" width="120px">
               <br>
          <span class="brand-text font-weight-light"> Prezicere</span>
        </a>
    </center>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{route('page', 'dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('page', 'data-latih')}}" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Data Latih</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-area"></i>
              <p>Data Uji</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
</aside>
