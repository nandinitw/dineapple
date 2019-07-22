@php
$user = Auth::user();
@endphp
<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>DINE</b>Apple</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"> {{{ isset(Auth::user()->name) ? Auth::user()->name : "" }}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                   {{{ isset(Auth::user()->name) ? Auth::user()->name : ""   }}}
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body" style="display:none;">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Home</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="{{ url('/users') }}">Users</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="{{ url('/roles') }}">Roles</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">

                  <a href="{{ url('/user/edit/'.$id = Auth::id()) }}" class="btn btn-default btn-flat">Profile</a>
                </div>

                     <div class="pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            data-toggle="control-sidebar"><i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
