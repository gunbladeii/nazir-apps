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
                    <a href="/paparInstrumen" class="nav-link">Papar instrumen</a>
                  </li>
@endsection

@section('container')
<form id="form-builder-form" action="{{ route('form-builder.store') }}" method="post">
    @csrf
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Bina Instrumen</h4>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
        {{ session('success') }}
        </div>
    @endif 
    <div class="card-body">
        <div class="form-builder">
                <div class="form-group">
                    <label>Pilih elemen</label>
                    <select class="form-control element-selector">
                        <option value="text">Input Teks</option>
                        <option value="textarea">Teks Panjang</option>
                        <option value="radio">Butang Radio</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="date">Date</option>
                        <!-- Add more form elements as needed -->
                    </select>
                </div>
                <button type="button" class="btn btn-primary add-element">Tambah Elemen</button>               
            
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Paparan Instrumen</h4>
    </div>
    <div class="card-body">
        <div class="form-preview">
            <!-- Elements will be previewed here -->
        </div>
        
        <!-- The submit button should be inside the form -->
        <button type="submit" class="btn btn-success">Jana Instrumen</button>
        <input type="hidden" name="form_data" id="form-data">   
    </div>
</div>
</form>
@endsection

@section('footer-plugin')
<script>
    $(document).ready(function() {
        $('.add-element').on('click', function() {
            var elementType = $('.element-selector').val();
            var elementLabel = prompt("Enter the label for this element:");
            var elementHtml = '';
            console.log("The 'Tambah Elemen' button was clicked.");
    
            // Ensure the user entered a label
            if (!elementLabel) return;
    
            // Create HTML for the selected element
            switch(elementType) {
                case 'text':
                    elementHtml += '<div class="form-group"><label>' + elementLabel + '</label><input type="text" class="form-control" name="elements[]" data-type="text"></div>';
                    break;
                case 'textarea':
                    elementHtml += '<div class="form-group"><label>' + elementLabel + '</label><textarea class="form-control" name="elements[]" data-type="textarea"></textarea></div>';
                    break;
                case 'radio':
                    let radioOptions = []; // Array to hold radio options
                    let radioLabel = prompt("Enter the label for radio options (comma separated):");
                    if (radioLabel) {
                        let options = radioLabel.split(',');
                        options.forEach(function(option, index) {
                            radioOptions.push({
                                label: option.trim(), // Trim whitespace
                                value: 'option' + (index + 1) // Create a value for the option
                            });
                            elementHtml += '<div class="form-check"><input type="radio" class="form-check-input" name="elements[]" data-type="radio" value="' + 'option' + (index + 1) + '">' + option.trim() + '</div>';
                        });
                    }
                    break;
                case 'checkbox':
                    let checkboxOptions = []; // Array to hold checkbox options
                    let checkboxLabel = prompt("Enter the label for checkbox options (comma separated):");
                    if (checkboxLabel) {
                        let options = checkboxLabel.split(',');
                        options.forEach(function(option, index) {
                            checkboxOptions.push({
                                label: option.trim(), // Trim whitespace
                                value: 'option' + (index + 1) // Create a value for the option
                            });
                            elementHtml += '<div class="form-check"><input type="checkbox" class="form-check-input" name="elements[]" data-type="checkbox" value="' + 'option' + (index + 1) + '">' + option.trim() + '</div>';
                        });
                    }
                    break;
                case 'date':
                    elementHtml += '<div class="form-group"><label>' + elementLabel + '</label><input type="date" class="form-control" name="elements[]" data-type="date"></div>';
                    break;
            }
    
            // Append the element HTML to the form preview
            $('.form-preview').append(elementHtml);
        });
    
        $('#form-builder-form').on('submit', function(e) {
            // No need to prevent default if you want to submit the form
            var formElements = [];

            $('.form-preview .form-group').each(function() {
                var label = $(this).find('label').first().text();
                var type = $(this).find('.form-control, .form-check-input').data('type'); // Adjusted to find data-type correctly
                var name = $(this).find('[name]').attr('name'); // Adjusted to find name attribute correctly
                var value;

                if (type === 'radio') {
                    value = $(this).find('input[type="radio"]:checked').val();
                } else if (type === 'checkbox') {
                    value = $(this).find('input[type="checkbox"]:checked').map(function() {
                        return this.value;
                    }).get(); // Get an array of checked values
                } else {
                    value = $(this).find('.form-control').val(); // Adjusted to find input or textarea value correctly
                }

                formElements.push({
                    label: label,
                    type: type,
                    name: name,
                    value: value
                });
            });

            var formData = JSON.stringify(formElements);
            $('#form-data').val(formData);

            // Submit the form after setting the value
            // this.submit(); // This line is commented out, but you can uncomment it to submit the form
        });

    });
    </script>    
@endsection