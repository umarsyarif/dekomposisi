<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link" data-widget="pushmenu"><i class="fa fa-bars"></i></a>
        </li>
    </ul>

<!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
            </button>
        </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown" data-toggle="dropdown">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="javascript:void(0)">
            <img src="{{asset('images/user.png')}}" alt="user-image" class="rounded-circle" width="32px">
            <span class="pro-user-name ml-1">{{Auth::user()->name}}  <i class="fas fa-angle-down"></i></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-item dropdown">
                <p>Hai, {{Auth::user()->name}}</p>
                <small>{{Auth::user()->email}}</small>
            </div>
            <div class="dropdown-item dropdown">
                <a href="javascript:void(0)" class="dropdown-item dropdown" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </div>
        </li>
    </ul>
</nav>

{{-- logout modal --}}
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary" href="">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
