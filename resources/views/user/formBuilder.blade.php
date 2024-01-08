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
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Pembinaan Instrumen/Aneks</h4>
    </div>
        <div class="card-body">
            <div class="form-builder">
                <div class="form-group">
                    <label>Pilih elemen</label>
                    <select class="form-control element-selector">
                        <option value="text">Input Teks</option>
                        <option value="textarea">Teks Panjang</option>
                        <option value="radio">Butang Radio</option>
                        <!-- Add more form elements as needed -->
                    </select>
                </div>
                <button class="btn btn-primary add-element">Tambah Elemen</button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-builder">
            <form id="form-builder-form" action="{{ route('form-builder.store') }}" method="post">
                @csrf
                <div class="form-preview">
                    <!-- Elements will be previewed here -->
                    <!-- Hidden input to store the form data -->
                    <input type="hidden" name="form_data" id="form-data">
                </div>
                <div class form-group>
                <button type="submit" class="btn btn-success">Jana Instrumen</button>
                </div>
            </form>
            </div>      
        </div>
</div>
@endsection

@section('footer-plugin')
<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('.add-element').on('click', function() {
        var elementType = $('.element-selector').val();
        var elementHtml = '';
        
        // Create HTML for the selected element
        if(elementType === 'text') {
            elementHtml = '<input type="text" class="form-control" />';
        } else if(elementType === 'textarea') {
            elementHtml = '<textarea class="form-control"></textarea>';
        } else if(elementType === 'radio') {
            elementHtml = '<div><input type="radio" name="options" /> Option 1</div>';
            // Add more options as needed
        }
        
        // Append the element HTML to the form preview
        $('.form-preview').append(elementHtml);
    });
});

$('#form-builder-form').on('submit', function() {
    // Initialize an array to hold the form elements
    var formElements = [];

    // Iterate over each form element added
    $('.form-preview').children().each(function() {
        var $el = $(this);
        var type = $el.prop('tagName').toLowerCase();
        var name = $el.attr('name');
        var value = $el.val();

        // Push a representation of the form element to the array
        formElements.push({ type: type, name: name, value: value });
    });

    // Convert the form elements array to a JSON string
    var formJson = JSON.stringify(formElements);

    // Set the value of the hidden input to the JSON string
    $('#form-data').val(formJson);

    // The form will now submit the JSON string to the server
});

</script>
@endsection
