@extends('layouts.app')
@section('admincontent')
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
  <div class="tab-pane active" id="users">
    <table class="userstable table-bordered" id="userstable">
      <h1> User Data </h1>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      @isset($userdata)
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>{{$userdata->name}}</td>
          <td>{{$userdata->email}}</td>
          <td>Admin</td>
        </tr>
      </tbody>
      @endisset
      <tbody class="tbody">
            <!-- Table rows will be populated here dynamically -->
      </tbody>
    </table>
    <table class="servicestable table-bordered" id="servicestable">
    <h1> User Services Data </h1>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Category Name</th>
          <th scope="col">Service Name</th>
          <th scope="col">Image</th>
          <th scope="col">Rate</th>
          <th scope="col">Zip</th>
          <th scope="col">City</th>
        </tr>
      </thead>
      
      @isset($availableservices)
      @foreach($availableservices as $value)
      <tbody>
        <tr>
          <th scope="row" value ="{{$value->id}}">1</th>
          <td value ="{{$value->category_id}}">{{$value->category_name}}</td>
          <td value ="{{$value->services_id}}">{{$value->service_name}}</td>
          <td><img src="{{ url('storage/images/'.$value->image)}}" style="opacity: 50; width: 100%; height: 100px;" /></td>
          <td>{{$value->rate}}</td>
          <td>{{$value->zip}}</td>
          <td>{{$value->city}}</td>
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

<div class="tab-pane" id="appointments">
  appointments
</div>


  <div class="tab-pane" id="revenue">
    ghasfghfasdjkgsbdfjkgsdjkfsdjkfsghdfasgjhd
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
                  //fetchAndPopulateCategories();
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


    // $('.nav-link').click(function(event) {
    //     event.preventDefault();
    //     var tabid = $(this).attr('data-target').substring(1);
    //     var url = '/clientdashboard';
    //     var infoData = { tabid: tabid, _token: "{{csrf_token()}}" };
    //     var clickedTabLink = $(this);
    //     console.log(infoData);
    //     $.post(url, infoData, function(response) {
    //         $('.tab-pane.active .table .tbody').empty();

    //         if (response.tabid == 'users') {
    //           //console.log(response);
    //           $('#users .userstable .tbody').append(response.userdata);
    //           $('#users .servicestable .tbody').append(response.userdata);

    //         } else if (response.tabid == 'providerservices') {
    //           var dropdown = $('#category_id');
    //             dropdown.empty();
    //             dropdown.append('<option selected disabled value="">Choose a category</option>');
    //             $.each(response.categories, function(index, category) {
    //                 dropdown.append($('<option>', {
    //                     value: category.id,
    //                     text: category.category_name
    //                 }));
    //             });
 
    //         } else if (response.tabid == 'appointments') {

    //         }
            
    //         $('.tab-pane').removeClass('active');
    //         $('#' + response.tabid).addClass('active');
    //         $('.nav-link').removeClass('active');
    //         clickedTabLink.addClass('active');
    //     })
    // });

    $('#category_id').change(function(event) {
      event.preventDefault();
      var catid = $(this).val();
      $('#serv').show('fast');
      //alert(catid);
      var url = '/getservices';
      var infoData = { catid: catid, _token: "{{csrf_token()}}" };
      $.post(url, infoData, function(response) {
        console.log(response.services);
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
                          <th scope="row">${index + 1}</th>
                          <td>${user.name}</td>
                          <td>
                              <button type="button" class="btn btn-primary btn-edit" data-user-id="${user.id}">Edit</button>
                          </td>
                          </tr>`;
                tbody.append(row);
            });
          }

          if (response.availableservices && response.availableservices.length > 0) {
            var tbody = $('#services .table tbody');
            tbody.empty(); // Clear existing rows
            $.each(response.availableservices, function(index, addedservices) {
              var imageUrl = imageurl + addedservices.image; 
                var row = `<tr>
                    <th scope="row">${index + 1}</th>
                    <td value ="${addedservices.category_id}">${addedservices.category_name}</td>
                    <td value ="${addedservices.services_id}">${addedservices.service_name}</td>
                    <td><img src="${imageUrl}" style="opacity: 50; width: 100%; height: 100px;" /></td>
                    <td>{{$value->rate}}</td>
                    <td>{{$value->zip}}</td>
                    <td>{{$value->city}}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-edit" data-availability-id="${addedservices.id}">Edit</button>
                    </td>
                </tr>`;
                tbody.append(row);
            });
          } 
          activateTab('users');
      },
      error: function(xhr) {
          console.error("Error fetching data: ", xhr.responseText);
      }
    });
  }

  // function fetchAndPopulateUsers() {
  //   $.ajax({
  //       type: "GET",
  //       url: "/path-to-fetch-users",
  //       success: function(response) {
  //           var usersHtml = "";
  //           response.users.forEach(function(user) {
  //               usersHtml += `<tr><td>${user.name}</td><td>${user.email}</td></tr>`; // Assuming you are populating a table
  //           });
  //           $('#usersTableBody').html(usersHtml); // Assuming 'usersTableBody' is the ID of the tbody element in your users table
  //       },
  //       error: function(xhr) {
  //           console.error("Error fetching users: ", xhr.responseText);
  //       }
  //   });
  // }

  // function fetchAndPopulateProducts() {
  //   $.ajax({
  //       type: "GET",
  //       url: "/path-to-fetch-products",
  //       success: function(response) {
  //           var productsHtml = "";
  //           response.products.forEach(function(product) {
  //               productsHtml += `<tr><td>${product.name}</td><td>${product.description}</td><td>${product.price}</td></tr>`; // Modify according to your product attributes
  //           });
  //           $('#productsTableBody').html(productsHtml); // Assuming 'productsTableBody' is the ID of the tbody element in your products table
  //       },
  //       error: function(xhr) {
  //           console.error("Error fetching products: ", xhr.responseText);
  //       }
  //   });
  // }

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

});

</script>

@endsection