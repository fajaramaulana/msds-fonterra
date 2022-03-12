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
        <a href="{{ route('home')}}">KOAPGI</a>
      </div>
      <ul class="sidebar-menu">
        <li class="{{ request()->is('home') ? 'active' : '' }}"><a class="nav-link" href="{{ route('home')}}"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
        <li class="{{ request()->is('banner','banner/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('banner.index')}}"><i class="fas fa-image"></i> <span>Banner</span></a></li>
        <li class="{{ request()->is('partner','partner/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('partner.index')}}"><i class="fas fa-user-check"></i> <span>Partner</span></a></li>
        <li class="{{ request()->is('testimoni','testimoni/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('testimoni.index')}}"><i class="fas fa-sticky-note"></i> <span>Testimoni</span></a></li>
        <li class="{{ request()->is('portofoliomanagement','portofoliomanagement/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('portofoliomanagement.index')}}"><i class="fas fa-images"></i> <span>Portofolio</span></a></li>
        <li class="{{ request()->is('listjasa','listjasa/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('listjasa.index')}}"><i class="fas fa-list-alt"></i> <span>List Jasa</span></a></li>
        <li class="{{ request()->is('pola','pola/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('pola.index')}}"><i class="fas fa-list-alt"></i> <span>Pola</span></a></li>
        <li class="{{ request()->is('bahan','bahan/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('bahan.index')}}"><i class="fas fa-list-alt"></i> <span>Bahan</span></a></li>
        <li class="{{ request()->is('faqbackend','faqbackend/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('faqbackend.index')}}"><i class="fas fa-question"></i><span>FAQ</span></a></li>
        <li class="{{ request()->is('user','user/*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index')}}"><i class="fas fa-users-cog"></i> <span>List User</span></a></li>
      </ul>
    </aside>
  </div>