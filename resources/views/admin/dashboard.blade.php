{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')
@section('menu-login')
                 
                  @if (Route::has('login'))
                  <li class="nav-link">
                    @auth
                    <a href="{{ url('/admin-dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
                  </li>
                  <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                      </li>
                  @endif
                  <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                  </li>
@endsection

@section('sidebar-menu') 
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item menu-open">
      <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Menu Utama
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="/control" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Setting</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin-dashboard" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Halaman Admin</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin-dashboard" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Tetapan</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
@endsection

@section('container')

    <div class="col-lg-12">
    </div>
    <!-- /.col-md-6 --> 
@endsection
  
