<div class="main-wrapper main-wrapper-1">
  <div class="navbar-bg"></div>
  <nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
      </ul>

    </form>
    <ul class="navbar-nav navbar-right">

      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
          <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ route('home')}}">Admin </a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home')}}">Admin</a>
      </div>
      <ul class="sidebar-menu">
        <li class="{{ request()->is('msds','msds/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('msds.index')}}"><i class="fas 
fa-list-alt"></i> <span>Hazardous Register</span></a></li>
        <li class="{{ request()->is('departement','departement/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('departement.index')}}"><i 
class="fas fa-question"></i><span>User</span></a></li>
        <li class="{{ request()->is('user','user/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index')}}"><i class="fas 
fa-users-cog"></i> <span>List User Aplikasi</span></a></li>
      </ul>
    </aside>
  </div>
