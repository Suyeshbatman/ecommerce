@extends('layouts.app')
@section('superadmincontent')
<!-- @if (session('user_name'))
     <div class="alert alert-success">
         {{ session('user_name') }}
     </div>
@endif -->

<ul class="nav nav-pills nav-justified">
  <li class="nav-item">
                                         
    <a aria-current="page" href="#" data-target="#users" class="nav-link active" id="users_tab">Users</a>

  </li>
  <li class="nav-item">

    <a href="#" data-target="#services" class="nav-link" id="services_tab">Services</a>

  </li>
  <li class="nav-item">

    <a href="#" data-target="#addservices" class="nav-link" id="addservices_tab">Add Services</a>

  </li>
  <li class="nav-item">
    <!-- <button class="btn m-0 waves-effect waves-light" id="revenue" type="button"> -->
      <a href="#" data-target="#revenue" class="nav-link" id="revenue_tab">Revenue</a>
    <!-- </button> -->
  </li>
</ul>


<div class="tab-content">
  <div class="tab-pane active" id="users">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
      @isset($userdata)
      @foreach ($userdata as $value)
        <tr>
          <th scope="row">1</th>
          <td>{{$value->name}}</td>
          <td>{{$value->email}}</td>
          <td>Superadmin</td>
        </tr>
      @endforeach
      @endisset
      </tbody>
    </table>
  </div>

  <div class="tab-pane" id="services">
    @if(isset($udata) && !empty($udata))
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
          </tr>
        </thead>
        <tbody class="tbody">
            @php
                $udataA = json_decode($udata);
            @endphp
            @foreach ($udataA as $value)
            <tr>
                <th scope="row">1</th>
                <td>{{$value->name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>


<div class="tab-pane" id="addservices">
  <h2>Add New Service</h2>
  <form id="add-service-form">
    <div class="mb-3">
      <label for="serviceName" class="form-label">Service Name</label>
      <input type="text" class="form-control" id="serviceName" name="serviceName" required>
    </div>

    <!-- New Categories Dropdown -->
    <div class="mb-3">
      <label for="serviceCategory" class="form-label">Category</label>
      <select class="form-select" id="serviceCategory" name="serviceCategory" required>
        <option selected disabled value="">Choose a category</option>
        <!-- Options will be populated here dynamically -->
      </select>
    </div>

    <div class="mb-3">
      <label for="serviceDescription" class="form-label">Description</label>
      <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="3" required></textarea>
    </div>

    <!-- Difficulty Input -->
    <div class="mb-3">
      <label for="serviceDifficulty" class="form-label">Difficulty</label>
      <input type="number" class="form-control" id="serviceDifficulty" name="serviceDifficulty" min="1" step="1" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>


  <div class="tab-pane" id="revenue">
    ghasfghfasdjkgsbdfjkgsdjkfsdjkfsghdfasgjhd
  </div>
</div>


<script>
$(document).ready(function() {
    $('.nav-link').click(function(event) {
        event.preventDefault(); // Prevent default link behavior
        var tabid = $(this).attr('data-target').substring(1); // Extract tab ID
        var url = '/dashboard'; // Adjust if your endpoint URL is different
        var infoData = { tabid: tabid, _token: "{{csrf_token()}}" };
        var clickedTabLink = $(this); // Ensure you capture this for later use

        $.post(url, infoData, function(response) {
            if (response) {
                if (response.tabid == 'addservices' && response.categories) {
                    // Handle the 'addservices' tab response
                    var dropdown = $('#serviceCategory'); // Make sure this is your dropdown ID
                    dropdown.empty(); // Clear existing options
                    dropdown.append('<option selected disabled value="">Choose a category</option>');
                    $.each(response.categories, function(index, category) {
                        dropdown.append($('<option>', {
                            value: category,
                            text: category
                        }));
                    });
                } else {
                    // General handling for other tabs
                    // Assuming 'udata' is part of the response for other tabs
                    // Update tab content if necessary
                }
                
                // Update UI elements based on response
                $('.tab-pane').removeClass('active');
                $('#' + response.tabid).addClass('active');
                $('.nav-link').removeClass('active');
                clickedTabLink.addClass('active');
            } else {
                console.error('Empty response received.');
            }
        });
    });
});
</script>



@endsection