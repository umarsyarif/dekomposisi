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
                    <a href="javascript:void(0)" class="dropdown-item dropdown" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </li>
    </ul>
</nav>
<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none">
    @csrf
</form>
