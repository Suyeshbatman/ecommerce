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
      @isset($paidsubscribers)
      @foreach ($paidsubscribers as $value)
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
      @isset($unpaidsubscribers)
      @foreach ($unpaidsubscribers as $value)
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
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
          </tr>
        </thead>
        <tbody class="tbody">
          <tr>
            <th scope="row">1</th>
          </tr>
        </tbody>
    </table>
  </div>

<div class="tab-pane" id="addservices">
  <h2>Add New Category</h2>
    {!!Form::open(['method'=>'POST','url'=>'/createcategory','class'=>'form-inline'])!!}
    <!-- @csrf -->
    <input type="hidden" class="form-control" id="addservices" name="addservices">
      <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" required>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
      {!!Form::close() !!}

  <h2>Add New Service</h2>
  {!!Form::open(['method'=>'POST','url'=>'/createservices','class'=>'form-inline'])!!}
  @csrf
     <!-- New Categories Dropdown -->
     <input type="hidden" class="form-control" id="addservices" name="addservices">

  <div class="mb-3">
      <label for="category_id" class="form-label">Category</label>
      <select class="form-select" id="category_id" name="category_id" required>
        <option selected disabled value="">Choose a category</option>
        <!-- Options will be populated here dynamically -->
      </select>
    </div>

    <div class="mb-3">
      <label for="service_name" class="form-label">Service Name</label>
      <input type="text" class="form-control" id="service_name" name="service_name" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>

    <!-- Difficulty Input -->
    <div class="mb-3">
      <label for="difficulty" class="form-label">Difficulty</label>
      <input type="number" class="form-control" id="difficulty" name="difficulty" min="1" step="1" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    {!!Form::close() !!}
</div>


  <div class="tab-pane" id="revenue">
    ghasfghfasdjkgsbdfjkgsdjkfsdjkfsghdfasgjhd
  </div>
</div>


<script>
 $(document).ready(function() {
    $('.nav-link').click(function(event) {
        event.preventDefault();
        var tabid = $(this).attr('data-target').substring(1);
        var url = '/dashboard';
        var infoData = { tabid: tabid, _token: "{{csrf_token()}}" };
        var clickedTabLink = $(this);
        $.post(url, infoData, function(response) {
            $('.tab-pane.active .table .tbody').empty();

            if (response.tabid == 'services') {
                $.each(response.servicesNames, function(index, servicesNames) {
                    var row = `<tr>
                                 <th scope="row">${index + 1}</th>
                                 <td>${servicesNames}</td>
                                 <td><button type="button" class="btn btn-primary btn-edit" onclick="editService(${index})">Edit</button></td>
                               </tr>`;
                    $('#services .table .tbody').append(row);
                });
            } else if (response.tabid == 'addservices') {
              console.log(response.tabid);
                var dropdown = $('#category_id');
                dropdown.empty();
                dropdown.append('<option selected disabled value="">Choose a category</option>');
                $.each(response.categories, function(index, category) {
                    dropdown.append($('<option>', {
                        value: category.id,
                        text: category.category_name
                    }));
                });
            }
            
            $('.tab-pane').removeClass('active');
            $('#' + response.tabid).addClass('active');
            $('.nav-link').removeClass('active');
            clickedTabLink.addClass('active');
        })
    });
});

// function editService(serviceIndex) {
//     // Placeholder function for future edit functionality
//     console.log("Edit service at index:", serviceIndex);
// }

</script>

@endsection