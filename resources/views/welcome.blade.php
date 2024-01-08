@extends('layouts.app')
@section('menu-login')
                  @if (Route::has('login'))
                  <li class="nav-item d-none d-sm-inline-block">
                    @auth
                    <a href="{{ url('/') }}" class="nav-link">Home</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
         
                @endauth
                  </li>
                  @endif
                  <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                  </li>
@endsection

@section('container')

    <div class="col-lg-12">
      <img src="https://fastly.4sqi.net/img/general/600x600/41604833_AKxd3koY99wd-vsF2hbYhDbnensohZFg42xvNCXd9CM.jpg" class="rounded mx-auto d-block" alt="...">
    </div>
    <!-- /.col-md-6 --> 
@endsection
