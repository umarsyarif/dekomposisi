<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <center>
        <a href="{{route('home')}}" class="brand-link mb-3 justify-content-center">
          <img src="{{asset('images/crystalball.png')}}" alt="Logo" class="img-circle elevation-3 mb-3" width="120px">
               <br>
          <span class="brand-text font-weight-light"> Forecasting</span>
        </a>
    </center>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{route('page', 'dashboard')}}" class="nav-link {{$title == 'Dashboard' ? 'active' : ''}}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item has-treeview {{Str::startsWith($title, ['Data', 'Nilai']) ? 'menu-open' : ''}}">
                <a href="javascript:void(0);" class="nav-link {{Str::startsWith($title, ['Data', 'Nilai']) ? 'active' : ''}}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>
                        Data Titik Api
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('data-latih.page')}}" class="nav-link {{Str::contains($title, 'Data Titik Api') ? 'active' : ''}}">
                            <i class="fas fa-chart-pie nav-icon"></i>
                            <p>Jumlah Titik Api</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('prediksi.data-trend')}}" class="nav-link {{Str::contains($title, 'Nilai Trend') ? 'active' : ''}}">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>Nilai Trend</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('prediksi.data-musiman')}}" class="nav-link {{Str::contains($title, 'Nilai Indeks Musiman') ? 'active' : ''}}">
                            <i class="fas fa-chart-area nav-icon"></i>
                            <p>Nilai Indeks Musiman</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{route('prediksi.page')}}" class="nav-link {{$title == 'Peramalan' ? 'active' : ''}}">
                    <i class="nav-icon fas fa-calculator"></i>
                    <p>Peramalan</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('data-uji.page')}}" class="nav-link {{$title == 'Akurasi' ? 'active' : ''}}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Akurasi</p>
                </a>
            </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
</aside>
