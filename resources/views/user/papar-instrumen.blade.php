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
                    <a href="/formBuilder" class="nav-link">Bina instrumen</a>
                  </li>
@endsection

@section('container')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Papar Instrumen</h4>
    </div>
    @foreach ($forms as $form)
    <div class="card-body">
        <div class="card-header"><h5 class="card-title">Form #{{ $form->id }}</h5></div>
        @php
            $structure = json_decode($form->structure);
        @endphp
        @foreach ($structure as $element)
            <div class="form-group">
                @if (isset($element->label))
                    <label>{{ $element->label }}</label>
                @endif

                @if ($element->type == 'text')
                    <input type="text" class="form-control" name="{{ $element->name }}" value="{{ $element->value ?? '' }}" />
                @elseif ($element->type == 'textarea')
                    <textarea class="form-control" name="{{ $element->name }}">{{ $element->value ?? '' }}</textarea>
                @elseif ($element->type == 'date')
                    <input type="date" class="form-control" name="{{ $element->name }}" value="{{ $element->value ?? '' }}" />
                @elseif ($element->type == 'radio' && isset($element->options))
                    @foreach ($element->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $element->name }}" value="{{ $option->value }}" 
                                {{ (isset($element->value) && $element->value == $option->value) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $option->label }}</label>
                        </div>
                    @endforeach
                @elseif ($element->type == 'checkbox' && isset($element->options))
                    @foreach ($element->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $element->name }}[]" value="{{ $option->value }}" 
                                {{ (isset($element->value) && is_array($element->value) && in_array($option->value, $element->value)) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $option->label }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
    @endforeach
</div>
@endsection
