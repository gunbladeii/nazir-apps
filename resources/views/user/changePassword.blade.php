{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.app')
@section('menu-login')
                 
                  @if (Route::has('login'))
                  <li class="nav-item d-none d-sm-inline-block">
                    @auth
                    <a href="{{ url('/user-dashboard') }}" class="nav-link">Home</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log in</a>

                @endauth
                  </li>
                  <li class="nav-item d-none d-sm-inline-block">
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

@section('container')
        <!-- Blade template for changing password -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tukar Kata Laluan</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.changePassword') }}">
                    @csrf
                    <div class="form-group">
                        <label for="old_password">Kata Laluan Asal:</label>
                        <input class="form-control" type="password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Laluan Baharu:</label>
                        <input  class="form-control" type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Pengesahan Kata Laluan:</label>
                        <input class="form-control" type="password" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tukar Kata Laluan</button>
                </form>
            </div>
        </div>
@endsection
  

