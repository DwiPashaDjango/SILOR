<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
          <div class="search-element">
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('') }}img/avatar/avatar-4.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{route('reset.index')}}" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Reset Password
              </a>
              <div class="dropdown-divider"></div>
              <form action="{{route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt mt-2"></i> Logout
                </button>
              </form>
            </div>
          </li>
        </ul>
      </nav>