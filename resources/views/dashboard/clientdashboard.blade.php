@extends('layouts.app')
@section('admincontent')
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

    <a href="#" data-target="#providerservices" class="nav-link" id="providerservices_tab">Services</a>

  </li>
  <li class="nav-item">

    <a href="#" data-target="#appointments" class="nav-link" id="appointments_tab">Appointments</a>

  </li>
  <li class="nav-item">
    <!-- <button class="btn m-0 waves-effect waves-light" id="revenue" type="button"> -->
      <a href="#" data-target="#revenue" class="nav-link" id="revenue_tab">Revenue</a>
    <!-- </button> -->
  </li>
</ul>


<div class="tab-content">
  <div class="tab-pane active" id="users" style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color: white">
    <table class="userstable table-bordered" id="userstable" style="width: 100%; border-collapse: collapse;">
      <h1> User Data </h1>
      <thead style="background-color: #343a40; color: #ffffff;">
        <tr>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">#</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">First</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Last</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Handle</th>
          <th style="padding: 8px; border: 1px solid #ddd;">Actions</th>
        </tr>
      </thead>
      @isset($userdata)
      <tbody style="background-color: #f8f9fa; color: #333333;">
        <tr>
          <th scope="row" style="padding: 8px; border: 1px solid #ddd;">1</th>
          <td style="padding: 8px; border: 1px solid #ddd;">{{$userdata->name}}</td>
          <td style="padding: 8px; border: 1px solid #ddd;">{{$userdata->email}}</td>
          <td style="padding: 8px; border: 1px solid #ddd;">{{session('user_role')}}</td>
          <td>
              <button type="button" class="btn btn-primary btn-viewuserprofile" data-userprofile-id="{{$userdata->id}}" style="margin-right: 5px; padding: 5px 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Edit</button>
          </td>
        </tr>
      </tbody>
      @endisset
      <tbody class="tbody">
            <!-- Table rows will be populated here dynamically -->
      </tbody>
    </table>
      <table class="servicestable table-bordered" id="servicestable" style="width: 100%; border-collapse: collapse;">
      <h1> User Services Data </h1>
        <thead style="background-color: #343a40; color: #ffffff;">
          <tr>
            <th scope="col" style="padding: 8px; border: 1px solid #ddd;">#</th>
            <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Category Name</th>
            <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Service Name</th>
            <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Image</th>
            <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Rate</th>
            <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Zip</th>
            <th scope="col" style="padding: 8px; border: 1px solid #ddd;">City</th>
            <th style="padding: 8px; border: 1px solid #ddd;">Actions</th>
          </tr>
        </thead>
        
        @isset($availableservices)
        @foreach($availableservices as $key=>$value)
        <tbody style="background-color: #f8f9fa; color: #333333;">
          <tr>
            <th scope="row" style="padding: 8px; border: 1px solid #ddd;">{{$key + 1}}</th>
            <td style="padding: 8px; border: 1px solid #ddd;" value ="{{$value->category_id}}">{{$value->category_name}}</td>
            <td style="padding: 8px; border: 1px solid #ddd;" value ="{{$value->services_id}}">{{$value->service_name}}</td>
            <td><img src="{{ url('storage/images/'.$value->image)}}" style="opacity: 50; width: 100%; height: 100px;" /></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{$value->rate}}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{$value->zip}}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{$value->city}}</td>
            <td>
                <button type="button" class="btn btn-primary btn-edituserservice" data-edituserservice-id="{{$value->id}}" style="margin-right: 5px; padding: 5px 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Edit</button>
                <button type="button" class="btn btn-primary btn-deleteuserservice" data-deleteuserservice-id="{{$value->id}}" style="padding: 5px 10px; background-color: #f44336; color: white; border: none; cursor: pointer;">Delete</button>
            </td>
          </tr>
          </tbody>
        @endforeach
        @endisset
        
      </table>
    <tbody class="tbody">
            <!-- Table rows will be populated here dynamically -->
    </tbody>
  </div>

  <div class="tab-pane" id="providerservices">
    <h2>Add Service</h2>
    {!!Form::open(['method'=>'POST','url'=>'/createavailableservices', 'id'=>'addservicesForm', 'enctype' => 'multipart/form-data'])!!}
    @csrf
      <!-- New Categories Dropdown -->
      <input type="hidden" class="form-control" id="providerservices" name="providerservices">

    <div class="mb-3" class="d-flex justify-content-center">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id" required>
          <option selected disabled value="">Choose a category</option>
          <!-- Options will be populated here dynamically -->
        </select>
    </div>

    <div class="mb-3" id="serv" style="display:none;" class="d-flex justify-content-center">
        <label for="services_id" class="form-label">Services</label>
        <select class="form-select" id="services_id" name="services_id" required>
          <option selected disabled value="">Choose a service</option>
          <!-- Options will be populated here dynamically -->
        </select>
    </div>

    <div>
      <label for="image" class="form-label">Choose an Image</label>
      <div class="mb-4 d-flex justify-content-center" id="imagepreview">
          <img id="imagepreview" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg" alt="example placeholder" style="width: 300px;" />
      </div>
      <div class="d-flex justify-content-center">
          <div data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded">
              <label class="form-label text-white m-1" for="image">Choose file</label>
              <input type="file" class="form-control d-none" id="image" name="image" accept="image/*" required/>
          </div>
      </div>
    </div>

    <div class="mb-3" class="d-flex justify-content-center">
      <label for="difficulty" class="form-label">Difficulty</label>
      <input type="number" class="form-control" id="difficulty" name="difficulty" value="" readOnly={true}>
    </div>

    <div class="mb-3" class="d-flex justify-content-center">
      <label for="rate" class="form-label">Hourly Rate</label>
      <input type="number" class="form-control" id="rate" name="rate" required>
    </div>

    <div class="mb-3" class="d-flex justify-content-center">
      <label for="zip" class="form-label">Location:Zip Code</label>
      <input type="number" class="form-control" id="zip" name="zip" required>
    </div>

    <div class="mb-3" class="d-flex justify-content-center">
      <label for="city" class="form-label">City</label>
      <input type="text" class="form-control" id="city" name="city" required>
    </div>

      <button type="submit" class="btn btn-primary">Submit</button>
      {!!Form::close() !!}
  </div>

<div class="tab-pane" id="appointments" style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  <table class="table table-bordered" id="appointmentstable" style="width: 100%; border-collapse: collapse;">
      <h1> Appointment Data </h1>
      <thead style="background-color: #343a40; color: #ffffff;">
        <tr>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">#</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Category Name</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Service Name</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">User Name</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Email</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Rate</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Requested Date</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Requested Time</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Accepted</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Completed</th>
          <th style="padding: 8px; border: 1px solid #ddd;">Actions</th>
        </tr>
      </thead>
      <tbody class="tbody" style="background-color: #f8f9fa; color: #333333;">
            <!-- Table rows will be populated here dynamically -->
      </tbody>
  </table>
</div>


<div class="tab-pane" id="revenue" style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  <table class="table table-bordered" id="revenuetable" style="width: 100%; border-collapse: collapse;">
      <h1> Appointment Data </h1>
      <thead style="background-color: #343a40; color: #ffffff;">
        <tr>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">#</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Category Name</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Service Name</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">User Name</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Email</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Rate</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Requested Date</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Requested Time</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Accepted</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Completed</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Start Time</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">End Time</th>
          <th scope="col" style="padding: 8px; border: 1px solid #ddd;">Cost</th>
        </tr>
      </thead>
      <tbody class="tbody" style="background-color: #f8f9fa; color: #333333;">
            <!-- Table rows will be populated here dynamically -->
      </tbody>
      <tfoot class="tfoot" style="background-color: #f8f9fa; color: #333333;">
        <!-- Total cost will be displayed here -->
      </tfoot>
  </table>
</div>
</div>


<!-- Modal to edit user profile-->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUserModalLabel">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form starts here -->
        {!!Form::open(['method'=>'POST','url'=>'/edituserprofile', 'id'=>'editUserForm', 'enctype' => 'form-data'])!!}
        @csrf
          <input type="hidden" class="form-control" id="user_id" name="user_id" value="" >
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <textarea class="form-control" id="email" name="email" value=""></textarea>
          </div>
          <div class="mb-3">
            <label for="phonenumber" class="form-label">Phone Number</label>
            <input type="number" class="form-control" id="phonenumber" name="phonenumber" value="">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="">
          </div>
          <div class="mb-3">
            <label for="zip1" class="form-label">Zip</label>
            <input type="number" class="form-control" id="zip1" name="zip1" value="">
          </div>
          <div class="mb-3">
            <label for="city1" class="form-label">City</label>
            <input type="text" class="form-control" id="city1" name="city1" value="">
          </div>
          <button type="submit" class="btn btn-primary">Edit Profile</button>
          {!!Form::close() !!}
        <!-- Form ends here -->
      </div>
    </div>
  </div>
</div>


<!-- Modal to edit services provided by user-->
<div class="modal fade" id="viewUserserviceModal" tabindex="-1" aria-labelledby="viewUserserviceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUserserviceModalLabel">Edit Services</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form starts here -->
        {!!Form::open(['method'=>'POST','url'=>'/edituserservice', 'id'=>'editUserserviceForm', 'enctype' => 'multipart/form-data'])!!}
        @csrf
          <input type="hidden" class="form-control" id="availability_id" name="availability_id" value="" >
          <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="" readOnly={true}>
          </div>
          <div class="mb-3">
            <label for="service_name" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="" readOnly={true}>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Change Image</label>
            <div class="mb-4 d-flex justify-content-center">
                <img id="imagepreview2" src="" alt="example placeholder" style="width: 300px;" />
            </div>
            <div class="d-flex justify-content-center">
                <div data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded">
                    <label class="form-label text-white m-1" for="image2">Choose file</label>
                    <input type="file" class="form-control d-none" id="image2" name="image2" accept="image/*"/>
                </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="rate2" class="form-label">Rate</label>
            <input type="number" class="form-control" id="rate2" name="rate2" value="">
          </div>
          <div class="mb-3">
            <label for="zip2" class="form-label">Zip</label>
            <input type="number" class="form-control" id="zip2" name="zip2" value="">
          </div>
          <div class="mb-3">
            <label for="city2" class="form-label">City</label>
            <input type="text" class="form-control" id="city2" name="city2" value="">
          </div>
          <button type="submit" class="btn btn-primary">Edit Service</button>
          {!!Form::close() !!}
        <!-- Form ends here -->
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var imageurl = 'storage/images/';

  function activateTab(tabId) {
        $('.tab-pane').removeClass('active');
        $('#' + tabId).addClass('active');
        $('.nav-link').removeClass('active');
        $(`[data-target="#${tabId}"]`).addClass('active');
  }

  $('.nav-link').click(function(event) {
      event.preventDefault();
      var tabid = $(this).attr('data-target').substring(1);
      var infoData = { tabid: tabid, _token: "{{ csrf_token() }}" };
      $.ajax({
          type: "POST",
          url: '/clientdashboard',
          data: infoData,
          success: function(response) {
              activateTab(tabid);
              if (tabid == 'users') {
                  fetchAndPopulateData();
              } else if (tabid == 'providerservices' && response.categories) {
                  populatecategories(response.categories);
              } else if (tabid == 'appointments') {
                  fetchAndPopulateAppointments();
              } else if (tabid == 'revenue') {
                  fetchAndPopulateRevenue();
              }

          },
          error: function(xhr) {
              console.error('Error: ', xhr.responseText);
          }
      });
  });


  function populatecategories() {
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


  $('#category_id').change(function(event) {
    event.preventDefault();
    var catid = $(this).val();
    $('#serv').show('fast');
    //alert(catid);
    var url = '/getservices';
    var infoData = { catid: catid, _token: "{{csrf_token()}}" };
    $.post(url, infoData, function(response) {
      //console.log(response.services);
        var dropdown = $('#services_id');
        dropdown.empty();
        dropdown.append('<option selected disabled value="">Choose a service</option>');
        $.each(response.services, function(index, service) {
            dropdown.append($('<option>', {
                value: service.id,
                text: service.service_name
            }));
        });

    });

  });

  $('#services_id').change(function(event) {
    event.preventDefault();
    var servid = $(this).val();
    var url = '/getdifficulty';
    var infoData = { servid: servid, _token: "{{csrf_token()}}" };
    $.post(url, infoData, function(response) {
      //console.log(response.difficulty);
      var insert = $('#difficulty');
      insert.val(response.difficulty);
    });
  });


  document.getElementById('image').addEventListener('change', function(event) {
          //alert("vayo");
      var file = event.target.files[0];
      var reader = new FileReader();

      reader.onload = function(e) {
          var imagepreview = document.getElementById('imagepreview');
          imagepreview.innerHTML = '';
          var imgElement = document.createElement('img');
          imgElement.src = e.target.result;
          imgElement.style.maxWidth = '100%';
          imgElement.style.maxHeight = '100%';
          imagepreview.appendChild(imgElement);
      };

      reader.readAsDataURL(file);
  });
    
  function fetchAndPopulateData() {
    $.ajax({
      type: "GET",
      url: "/fetchuserdata", // This URL should return both users and products data
      success: function(response) {
          if (response.userdata && response.userdata.length > 0) {
            var tbody = $('#users .table tbody');
            tbody.empty(); // Clear existing rows
            $.each(response.userdata, function(index, user) {
                var row = `<tr>
                          <th scope="row" style="padding: 8px; border: 1px solid #ddd;">${index + 1}</th>
                          <td style="padding: 8px; border: 1px solid #ddd;">${user.name}</td>
                          <td style="padding: 8px; border: 1px solid #ddd;">
                              <button type="button" class="btn btn-primary btn-edit" data-user-id="${user.id}">Edit</button>
                          </td>
                          </tr>`;
                tbody.append(row);
            });
          }

          if (response.availableservices && response.availableservices.length > 0) {
            var tbody = $('#appointments .table tbody');
            tbody.empty(); // Clear existing rows
            $.each(response.availableservices, function(index, addedservices) {
              var imageUrl = imageurl + addedservices.image; 
                var row = `<tr>
                    <th scope="row" style="padding: 8px; border: 1px solid #ddd;">${index + 1}</th>
                    <td style="padding: 8px; border: 1px solid #ddd;" value ="${addedservices.category_id}">${addedservices.category_name}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;" value ="${addedservices.services_id}">${addedservices.service_name}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><img src="${imageUrl}" style="opacity: 50; width: 100%; height: 100px;" /></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${addedservices.rate}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${addedservices.zip}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${addedservices.city}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        <button type="button" class="btn btn-primary btn-edit" data-availability-id="${addedservices.id}">Edit</button>
                    </td>
                </tr>`;
                tbody.append(row);
            });
          } 
      },
      error: function(xhr) {
          console.error("Error fetching data: ", xhr.responseText);
      }
    });
  }

  function fetchAndPopulateAppointments() {
    $.ajax({
      type: "GET",
      url: "/fetchappointmentdata", // This URL should return both users and products data
      success: function(response) {
          if (response.combinedInfo && response.combinedInfo.length > 0) {
            var tbody = $('#appointments .table tbody');
            tbody.empty(); // Clear existing rows
            $.each(response.combinedInfo, function(index, info) {
                var row = `<tr>
                    <th scope="row" style="padding: 8px; border: 1px solid #ddd;">${index + 1}</th>
                    <td style="padding: 8px; border: 1px solid #ddd;" value ="${info.category_id}">${info.category_name}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;" value ="${info.services_id}">${info.service_name}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${info.user_name}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${info.user_email}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${info.rate}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${info.requesteddate}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${info.requestedtime}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${info.accepted}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${info.completed}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        <button type="button" class="btn btn-action btn-success" data-role="accept" data-usercart-id="${info.id}">Accept</button>
                        <button type="button" class="btn btn-action btn-danger" data-role="reject" data-usercart-id="${info.id}">Reject</button>
                        <button type="button" class="btn btn-action btn-warning" data-role="startjob" data-usercart-id="${info.id}">Start Job</button>
                        <button type="button" class="btn btn-action btn-success" data-role="endjob" data-usercart-id="${info.id}">End Job</button>
                    </td>
                </tr>`;
                tbody.append(row);
            });
          } 
      },
      error: function(xhr) {
          console.error("Error fetching data: ", xhr.responseText);
      }
    });
  }

  function fetchAndPopulateRevenue() {
    $.ajax({
        type: "GET",
        url: "/fetchrevenuedata",  // This URL should return both users, products data, and totalCost
        success: function(response) {
            if (response.combinedInfo && response.combinedInfo.length > 0) {
                var tbody = $('#revenue .table tbody');
                var tfoot = $('#revenue .table tfoot');
                tbody.empty(); // Clear existing rows
                tfoot.empty(); // Clear existing footer

                $.each(response.combinedInfo, function(index, info) {
                    var row = `<tr>
                        <th scope="row">${index + 1}</th>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.category_name}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.service_name}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.user_name}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.user_email}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.rate}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.requesteddate}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.requestedtime}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.accepted}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.completed}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.jobstarttime ? `${info.jobstarttime}` : 'Job Not Started'}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.jobendtime ? `${info.jobendtime}` : 'Job Not Completed'}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${info.cost ? `$${info.cost}` : 'Not Available Yet'}</td>
                    </tr>`;
                    tbody.append(row);
                });

                // Append the total cost row in the footer
                var totalRow = `<tr>
                    <td colspan="10" style="text-align: right;">Total Cost:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${response.totalCost ? `$${response.totalCost }` : 'Not Available Yet'}</td>
                </tr>`;
                tfoot.append(totalRow);
            } else {
                console.log('No data to display.');
            }
        },
        error: function(xhr) {
            console.error("Error fetching data: ", xhr.responseText);
        }
    });
}


  $('#addservicesForm').submit(function(event) {
      event.preventDefault();
      var formData = new FormData(this);

      $.ajax({
          type: "POST",
          url: $(this).attr('action'),
          data: formData,
          processData: false,  // tell jQuery not to process the data
          contentType: false,  // tell jQuery not to set contentType
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function(response) {
            if(response.success){
              Toastify({
                text: response.message || "Service added successfully!",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
              }).showToast();
                  fetchAndPopulateData(); // Fetch and populate users
                  activateTab('users');
                  window.location.reload();
                  
            }else if(response.error){
              Toastify({
                text: response.message || "Failed to add service. Service already exists. Please try again.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF0000",
              }).showToast();
                  activateTab('providerservices');
                  populatecategories();
                  $('#addserviceForm')[0].reset();
            }
            
          },
          error: function(xhr) {
            console.error("Error fetching categories: ", xhr.responseText);
          }
      });
  });

  $(document).on('click', '.btn-viewuserprofile', function() {
    event.preventDefault();
    var user_id = $(this).data('userprofile-id');
    var uurl = '/getuserdata'
    var infoData = { user_id: user_id, _token: "{{ csrf_token() }}" };
    $.ajax({
        type: "POST",
        url: uurl,
        data: infoData,
      success: function(response) {
        if (response.status === 'success') {

          console.log(response.userdata.zip);

          $('#user_id').val(response.userdata.id);
          $('#first_name').val(response.userdata.name);
          $('#email').val(response.userdata.email);
          $('#phonenumber').val(response.userdata.phonenumber);
          $('#address').val(response.userdata.address);
          $('#zip1').val(response.userdata.zip);
          $('#city1').val(response.userdata.city);


        } else {
            console.error('Error: ', response.message);
            $('#viewUserModal .modal-body').html('<p>Error loading service details.</p>');
        }
      },
      error: function(xhr) {
          console.error('Error: ', xhr.responseText);
          $('#viewUserModal .modal-body').html('<p>Error loading service details.</p>');
      }
    });

    $('#viewUserModal').modal('show');
  });


  $(document).on('click', '.btn-edituserservice', function() {
    event.preventDefault();
    var availability_id = $(this).data('edituserservice-id');
    var surl = '/getservicedata'
    var infoData = { availability_id: availability_id, _token: "{{ csrf_token() }}" };
    $.ajax({
        type: "POST",
        url: surl,
        data: infoData,
      success: function(response) {
        if (response.status === 'success') {

          var imageUrl = imageurl + response.servicedata.image; 

          $('#availability_id').val(response.servicedata.id);
          $('#category_name').val(response.servicedata.category_name);
          $('#service_name').val(response.servicedata.service_name);
          $('#imagepreview2').attr('src', imageUrl);
          $('#rate2').val(response.servicedata.rate);
          $('#zip2').val(response.servicedata.zip);
          $('#city2').val(response.servicedata.city);

        } else {
            console.error('Error: ', response.message);
            $('#viewUserserviceModal .modal-body').html('<p>Error loading service details.</p>');
        }
      },
      error: function(xhr) {
          console.error('Error: ', xhr.responseText);
          $('#viewUserserviceModal .modal-body').html('<p>Error loading service details.</p>');
      }
    });

    $('#viewUserserviceModal').modal('show');
    
  });

  $(document).on('click', '.btn-deleteuserservice', function() {
      var availabilityid = $(this).data('deleteuserservice-id');
      if (confirm('Are you sure you want to delete this service?')) {
          $.ajax({
              type: "POST",
              url: '/deleteuserservice',
              data: { availabilityid: availabilityid, _token: "{{ csrf_token() }}" },
              success: function(response) {
                  alert('Service deleted successfully!');
                  activateTab('users');
                  fetchAndPopulateData();
                  
              },
              error: function(xhr) {
                  alert('Error deleting service: ' + xhr.responseText);
              }
          });
      }
  });


  $(document).on('click', '.btn-action', function() {
    event.preventDefault();
    var role = $(this).data('role');
    var cart_id = $(this).data('usercart-id');
    var Url = '/appointmentactions'
    var infoData = { role: role, cart_id: cart_id, _token: "{{ csrf_token() }}" };
    $.ajax({
        type: "POST",
        url: Url,
        data: infoData,
      success: function(response) {
        if (response.status === 'success') {
          activateTab('appointments');
          fetchAndPopulateAppointments(); // Fetch and populate appointments 
          alert(response.message);
        }else {
            // Handle non-successful responses
            alert('Error: ' + response.message);
        }
      },
      error: function(xhr) {
            var response = JSON.parse(xhr.responseText);
            var errorMessage = response.message || (xhr.status + ': ' + xhr.statusText);
            alert('Error - ' + errorMessage);
      }
    });
  });

  

});

</script>

@endsection