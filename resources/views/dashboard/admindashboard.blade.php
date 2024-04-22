@extends('layouts.app')
@section('superadmincontent')
<!-- @if (session('user_name'))
     <div class="alert alert-success">
         {{ session('user_name') }}
     </div>
@endif -->

<ul class="nav nav-pills nav-justified" style="font-weight: bold; font-size: 1.35rem; background-color: white;">
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
<div class="tab-pane active" id="users" style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: white">
        <!-- Table for Paid Subscribers (no changes needed here) -->
        <table class="table table-bordered" id="paidSubscribersTable">
    <thead style="background-color: #343a40; color: #ffffff;">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
        </tr>
    </thead>
    <tbody style="background-color: #f8f9fa; color: #333333;">
        @isset($paidsubscribers)
        @foreach ($paidsubscribers as $value)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{$value->name}}</td>
            <td>{{$value->email}}</td>
            <td>Admin</td>
        </tr>
        @endforeach
        @endisset
    </tbody>
</table>

<!-- Table for Unpaid Subscribers -->
<table class="table table-bordered" id="unpaidSubscribersTable">
    <thead style="background-color: #343a40; color: #ffffff;">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody style="background-color: #f8f9fa; color: #333333;">
        @isset($unpaidsubscribers)
        @foreach ($unpaidsubscribers as $value)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$value->name}}</td>
            <td>{{$value->email}}</td>
            <td>Normal</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm btn-add" data-user-id="{{$value->id}}">Add</button>
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>
</table>
    </div>

  <div class="tab-pane" id="services" style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: white">
    <table class="table table-bordered">
        <thead style="background-color: #343a40; color: #ffffff;">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Service Name</th>
                <th scope="col">Description</th>
                <th scope="col">Difficulty</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="tbody" style="background-color: #f8f9fa; color: #333333;">
            <!-- Table rows will be populated here dynamically -->
        </tbody>
    </table>
</div>

<div class="tab-pane" id="addservices" style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: white">
  @isset($tabid)
  <input type="hidden" class="form-control" id="viewdata" value="{{$tabid}}" name="viewdata">
  @endisset

  <div class="card" style="border: 1px solid #ccc;">
    <div class="card-header" style="background-color: #000; color: #fff;">
      <h2>Add New Category</h2>
    </div>
    <div class="card-body" style="background-color: #e9ecef; color: #000;">
      {!! Form::open(['method'=>'POST','url'=>'/createcategory', 'id'=>'addcategoryForm']) !!}
      @csrf
        <div style="margin-bottom: 1rem;">
          <label for="category_name" style="display: block; color: #000;">Category Name</label>
          <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <div style="margin-bottom: 1rem;">
          <button type="submit" id="registercategory" class="btn btn-primary">Submit</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  <div class="card mt-4" style="border: 1px solid #ccc;">
    <div class="card-header" style="background-color: #000; color: #fff;">
      <h2>Add New Service</h2>
    </div>
    <div class="card-body" style="background-color: #e9ecef; color: #000;">
      {!! Form::open(['method'=>'POST','url'=>'/createservices', 'id'=>'createServiceForm']) !!}
      @csrf
        <div style="margin-bottom: 1rem;">
          <label for="category_id" style="display: block; color: #000;">Category</label>
          <select class="form-control" id="editCategoryId" name="category_id" required>
            <option selected disabled value="">Choose a category</option>
            <!-- Options will be dynamically populated -->
          </select>
        </div>

        <div style="margin-bottom: 1rem;">
          <label for="service_name" style="display: block; color: #000;">Service Name</label>
          <input type="text" class="form-control" id="service_name" name="service_name" required>
        </div>

        <div style="margin-bottom: 1rem;">
          <label for="description" style="display: block; color: #000;">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div style="margin-bottom: 1rem;">
          <label for="difficulty" style="display: block; color: #000;">Difficulty</label>
          <input type="number" class="form-control" id="difficulty" name="difficulty" min="1" step="1" required>
        </div>

        <div style="margin-bottom: 1rem;">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>




  <div class="tab-pane" id="revenue" style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: white">
  
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
        <form class="editServiceForm" id="editServiceForm">
        <input type="hidden" class="form-control" id="editServiceId" name="service_id" value="">
          <div class="mb-3">
            <label for="editcategoryid" class="form-label">Category</label>
            <select class="form-select" id="editcategoryid" name="category_id" value="">
              <!-- Categories options will be populated here dynamically -->
            </select>
          </div>
          <div class="mb-3">
            <label for="editServiceName" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="editServiceName" name="service_name" value="">
          </div>
          <div class="mb-3">
            <label for="editServiceDescription" class="form-label">Description</label>
            <textarea class="form-control" id="editServiceDescription" name="description" value=""></textarea>
          </div>
          <div class="mb-3">
            <label for="editDifficulty" class="form-label">Difficulty</label>
            <input type="number" class="form-control" id="editDifficulty" name="difficulty" value="">
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
    var categoriesCache;
    // Function to populate the services table
    function populateServicesTable(services) {
        var tbody = $('#services .table tbody');
        tbody.empty(); // Clear existing rows
        $.each(services, function(index, service) {
            var row = `<tr>
                <th scope="row">${index + 1}</th>
                <td data-service-name="${service.service_name}" value="">${service.service_name}</td>
                <td data-description="${service.description}" value="">${service.description}</td>
                <td data-difficulty="${service.difficulty}" value="">${service.difficulty}</td>
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
                var dropdown = $('#editCategoryId');
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
                } else if (tabid == 'revenue') {
                    populateRevenueTable(response);
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

    function populateRevenueTable(data) {
        var monthly_fee = 20; // To change montly fee
        var revenueTab = $('#revenue');
        revenueTab.empty(); // Clear existing content

        if (!data.success) {
            revenueTab.html('<p>Error loading revenue data. Please try again.</p>');
            return;
        }

        var html = `
            <h2>Revenue Statistics</h2>
            <p><strong>Total Subscribed Users:</strong> ${data.totalSubscribedUsers}</p>
            <p><strong>Total Subscription Months:</strong> ${data.totalMonthsSubscribed}</p>
            <p><strong>Total Revenue: $</strong> ${data.totalMonthsSubscribed * monthly_fee}</p>
            <h3>Subscribed Users</h3>
            <table class="table table-bordered">
                <thead style="background-color: #343a40; color: #ffffff;">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Months Subscribed</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                    </tr>
                </thead>
                <tbody style="background-color: #f8f9fa; color: #333333;">
                    ${data.subscribedUsers.map((user, index) => `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.request_interval}</td>
                            <td>${user.start_date}</td>
                            <td>${user.end_date}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
        revenueTab.html(html);
    }

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
        
        var serviceName = $(this).data('service-name'); // Ensure data attribute is data-service-name
        var serviceDescription = $(this).data('description'); // Ensure data attribute is data-description
        var serviceDifficulty = $(this).data('difficulty'); // Ensure data attribute is data-difficulty
        console.log(serviceDifficulty);

        // Populate the modal inputs immediately
        $('#editServiceId').val(serviceId);
        $('#editServiceName').val(serviceName);
        $('#editServiceDescription').val(serviceDescription);
        $('#editDifficulty').val(serviceDifficulty);

        $.ajax({
            type: "GET",
            url: "/fetch-categories",
            success: function(response) {
                var dropdown = $('#editcategoryid');
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
       // console.log("Edit service with ID:", serviceId);
        $('#editServiceModal').modal('show');
    });

    $(document).on('click', '.btn-add', function() {
    var addButton = $(this);
    var userId = addButton.data('user-id');
    
    // Executing AJAX directly without confirmation prompt
    $.ajax({
        type: "POST",
        url: "{{ route('update.paid.status') }}",
        data: { userId: userId, _token: "{{ csrf_token() }}" },
        success: function(response) {
            console.log("Response received: ", response);
            if(response.success) {
                // Toastify success message
                Toastify({
                    text: "Subscription updated successfully! User is now a paid subscriber.",
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: 'right', // `left`, `center` or `right`
                    backgroundColor: "#4CAF50",
                    className: "info",
                }).showToast();

                var row = addButton.closest('tr');

                // Update the role to 'Admin'
                row.find('td:eq(2)').text('Admin');

                // Remove the 'Action' cell
                row.find('td:last').remove();

                // Append to the Paid Subscribers table
                $('#paidSubscribersTable tbody').append(row.fadeIn("slow"));

                // Update indices in the Paid Subscribers Table
                $('#paidSubscribersTable tbody tr').each(function(index) {
                    $(this).find('th').eq(0).text(index + 1);
                });

                // Update indices in the Unpaid Subscribers Table
                $('#unpaidSubscribersTable tbody tr').each(function(index) {
                    $(this).find('th').eq(0).text(index + 1);
                });

            } else {
                // Toastify failure message
                Toastify({
                    text: "Failed to update subscription: " + response.message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: 'right',
                    backgroundColor: "#FF5733",
                    className: "info",
                }).showToast();
            }
        },
        error: function(xhr) {
            console.log("AJAX error: ", xhr.responseText);
            // Toastify error message
            Toastify({
                text: "Failed to update subscription. Please try again.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: 'right',
                backgroundColor: "#FF5733",
                className: "info",
            }).showToast();
        }
    });
});


    $('#viewdata').change(function(event) {
        var id = $(this).val();
        alert(id);
        activateTab('addservices');
    });
});
</script>
@endsection
