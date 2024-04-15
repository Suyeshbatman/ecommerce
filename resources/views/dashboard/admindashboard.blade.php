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
                <th scope="col">Service Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <!-- Table rows will be populated here dynamically -->
        </tbody>
    </table>
</div>

<div class="tab-pane" id="addservices">
  @isset($tabid)
  <input type="hidden" class="form-control" id="viewdata" value="{{$tabid}}" name="viewdata">
  @endisset

  <h2>Add New Category</h2>
  <input type="hidden" class="form-control" id="addservices" name="addcategotyForm">
    {!!Form::open(['method'=>'POST','url'=>'/createcategory', 'id'=>'addcategoryForm'])!!}
    @csrf

      <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" required>
      </div>

      <button type="submit" id="registercategory"class="btn btn-primary">Submit</button>
    {!!Form::close() !!}

  <h2>Add New Service</h2>
  {!!Form::open(['method'=>'POST','url'=>'/createservices', 'id'=>'createServiceForm']) !!}
  @csrf
     <input type="hidden" class="form-control" id="addservices" name="addservices">

  <div class="mb-3">
      <label for="category_id" class="form-label">Category</label>
      <select class="form-control" id="category_id" name="category_id" required>
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

<!-- Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form starts here -->
        <form id="editServiceForm">
          <div class="mb-3">
            <label for="editCategoryId" class="form-label">Category</label>
            <select class="form-select" id="editCategoryId" name="category_id">
              <!-- Categories options will be populated here dynamically -->
            </select>
          </div>
          <div class="mb-3">
            <label for="editServiceName" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="editServiceName" name="service_name">
          </div>
          <div class="mb-3">
            <label for="editServiceDescription" class="form-label">Description</label>
            <textarea class="form-control" id="editServiceDescription" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="editDifficulty" class="form-label">Difficulty</label>
            <input type="number" class="form-control" id="editDifficulty" name="difficulty">
          </div>
        </form>
        <!-- Form ends here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="editServiceForm">Save changes</button>
      </div>
    </div>
  </div>
</div>



<script>
$(document).ready(function() {
    // Function to populate the services table
    function populateServicesTable(services) {
        var tbody = $('#services .table tbody');
        tbody.empty(); // Clear existing rows
        $.each(services, function(index, service) {
            var row = `<tr>
                <th scope="row">${index + 1}</th>
                <td>${service.service_name}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-edit" data-service-id="${service.id}">Edit</button>
                    <button type="button" class="btn btn-danger btn-delete" data-service-id="${service.id}">Delete</button>
                </td>
            </tr>`;
            tbody.append(row);
        });
    }

    // Function to activate a specific tab
    function activateTab(tabId) {
        $('.tab-pane').removeClass('active');
        $('#' + tabId).addClass('active');
        $('.nav-link').removeClass('active');
        $(`[data-target="#${tabId}"]`).addClass('active');
    }

    // Function to fetch and populate categories
    function fetchAndPopulateCategories() {
        $.ajax({
            type: "GET",
            url: "/fetch-categories",
            success: function(response) {
                var dropdown = $('#category_id');
                dropdown.empty();
                dropdown.append('<option selected disabled value="">Choose a category</option>');
                $.each(response.categories, function(index, category) {
                    dropdown.append($('<option>', {
                        value: category.id,
                        text: category.category_name
                    }));
                });
            },
            error: function(xhr) {
                console.error("Error fetching categories: ", xhr.responseText);
            }
        });
    }

    // Handling click events on nav-links to switch tabs without reloading the page
    $('.nav-link').click(function(event) {
        event.preventDefault();
        var tabid = $(this).attr('data-target').substring(1);
        var infoData = { tabid: tabid, _token: "{{ csrf_token() }}" };

        $.ajax({
            type: "POST",
            url: '/dashboard',
            data: infoData,
            success: function(response) {
                activateTab(tabid);

                if (tabid == 'services' && response.services) {
                    populateServicesTable(response.services);
                } else if (tabid == 'addservices') {
                    fetchAndPopulateCategories();
                }
            },
            error: function(xhr) {
                console.error('Error: ', xhr.responseText);
            }
        });
    });

    // AJAX submission for 'Add New Service' form
    $('#createServiceForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: '/createservices',
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                fetchAndUpdateServices();
                $('#createServiceForm')[0].reset();
            },
            error: function(xhr) {
                alert("Failed to add service. Please try again.");
            }
        });
    });

    // AJAX submission for 'Add New Category' form
    $('#addcategoryForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: '/createcategory',
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
              Toastify({
                text: response.message || "Category added successfully!",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
            }).showToast();
                activateTab('addservices');
                fetchAndPopulateCategories();
                $('#addcategoryForm')[0].reset();
            },
            error: function(xhr) {
                alert("Failed to add category. Please try again.");
            }
        });
    });

    // Function to fetch the updated list of services and populate the table
    function fetchAndUpdateServices() {
        $.ajax({
            type: "GET",
            url: '/fetch-services',
            success: function(response) {
                populateServicesTable(response.services);
                activateTab('services');
            },
            error: function(xhr) {
                console.error("Error fetching updated services: ", xhr.responseText);
            }
        });
    }

    // Delegated event handling for delete button clicks
    $(document).on('click', '.btn-delete', function() {
        var serviceId = $(this).data('service-id');
        if (confirm('Are you sure you want to delete this service?')) {
            $.ajax({
                type: "POST",
                url: '/delete-service',
                data: { id: serviceId, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    alert('Service deleted successfully!');
                    fetchAndUpdateServices();
                },
                error: function(xhr) {
                    alert('Error deleting service: ' + xhr.responseText);
                }
            });
        }
    });

    // Delegated event handling for edit button clicks
    $(document).on('click', '.btn-edit', function() {
        var serviceId = $(this).data('service-id');
        console.log("Edit service with ID:", serviceId);
        $('#editServiceModal').modal('show');
    });

    $('#viewdata').change(function(event) {
        var id = $(this).val();
        alert(id);
        activateTab('addservices');
    });
});
</script>
@endsection
