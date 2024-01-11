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
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('failure'))
                    <div class="alert alert-danger">
                        {{ session('failure') }}
                    </div>
                @endif  
    @foreach ($forms as $form)
    <form action="{{ route('form.update', ['formId' => $form->id]) }}" method="post">
        @csrf
        @method('PUT') {{-- Laravel uses POST method, but this directive tells Laravel to treat it as PUT --}}
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">
                    Form #{{ $form->id }}
                </h5>
            </div>
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
            <button type="submit" class="btn btn-primary float-right">Simpan Perubahan</button>
            <input type="hidden" name="form_data" id="form-data">
        </div>
    </form>
    @endforeach
</div>
@endsection

@section('footer-plugin')
<script>
    function toggleEdit(button) {
        let form = button.closest('form');
        let editMode = form.querySelector('.save-form').classList.contains('d-none');
        
        // Toggle buttons
        form.querySelector('.edit-form').classList.toggle('d-none');
        form.querySelector('.save-form').classList.toggle('d-none');

        // Toggle read-only on form elements
        form.querySelectorAll('input, textarea, select').forEach(function(element) {
            if (editMode) {
                element.removeAttribute('readonly');
                if(element.type === 'checkbox' || element.type === 'radio') {
                    element.removeAttribute('disabled');
                }
            } else {
                element.setAttribute('readonly', true);
                if(element.type === 'checkbox' || element.type === 'radio') {
                    element.setAttribute('disabled', true);
                }
            }
        });
    }

    $('#form-builder-form').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission
    var formElements = [];

    $('.form-preview .form-group').each(function() {
        var label = $(this).find('label').text();
        var type = $(this).data('type'); // Make sure you have data-type attributes on your input elements
        var name = $(this).find('[name]').attr('name');
        var value;

        if (type === 'radio' || type === 'checkbox') {
            value = $(this).find('input:checked').map(function() {
                return $(this).val();
            }).get();
        } else {
            value = $(this).find('input, textarea, select').val();
        }

        formElements.push({
            label: label,
            type: type,
            name: name,
            value: value
        });
    });

    $('#form-data').val(JSON.stringify(formElements));
    
    // Now you can submit the form
    this.submit();
});
</script>
@endsection

