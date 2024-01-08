{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('menu-login')
                 
                  @if (Route::has('login'))
                  <li class="nav-item d-none d-sm-inline-block">
                    @auth
                    <a href="{{ url('/admin-dashboard') }}" class="nav-link">Home</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    @endif
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
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Paparan Pengguna Sistem</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
    
        @if(auth()->check() && auth()->user()->hasRole('admin'))
            <!-- Show admin specific content and controls -->
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Ubahsuai</th>
                        <!-- Add more headers if needed -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                          @csrf
                          @method('PATCH') {{-- This directive is used to spoof the PATCH method --}}
                          <span class="editable" onclick="makeEditable(this)">{{ $user->name }}</span>
                          <input type="text" class="form-control d-none" value="{{ $user->name }}" onblur="submitNameChange(this, {{ $user->id }})" onkeyup="handleKeyUp(event, this)">
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <span>{{ $role->name }}</span> {{-- Display the role name --}}
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ url('/user/'.$user->id.'/role') }}" method="POST">
                                @csrf
                                @method('PATCH') {{-- This directive is used to spoof the PATCH method --}}
                                <select name="role_id" onchange="this.form.submit()">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
    
                </tbody>
            </table>
        @endif
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <!-- /.col-md-12 --> 
@endsection

@section('head-plugin')
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('footer-plugin')
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
  // Function to make the span editable
  function makeEditable(element) {
      let input = element.nextElementSibling;
      element.classList.add('d-none');
      input.classList.remove('d-none');
      input.focus();
  }
  
  // Function to handle the keyup event for input (to save on enter key press)
  function handleKeyUp(event, input) {
      if(event.key === 'Enter') {
          input.blur(); // This will trigger the onblur event
      }
  }
  
  // Function to submit the name change
  function submitNameChange(input, userId) {
      let newName = input.value;
      let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // CSRF token
  
      // Hide the input field and show the span element
      input.classList.add('d-none');
      input.previousElementSibling.classList.remove('d-none');
      input.previousElementSibling.textContent = newName;
  
      // Send the request to the server
      fetch(`/user/${userId}/update-name`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': token
          },
          body: JSON.stringify({ name: newName })
      })
      .then(response => response.json())
      .then(data => {
          // Handle response here
          console.log(data);
          // Update the UI based on the response if necessary
      })
      .catch(error => {
          console.error('Error:', error);
      });
  }
  </script>  
@endsection