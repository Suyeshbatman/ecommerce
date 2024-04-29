@extends('layouts.app')

@section('content')
@if (session('error'))
  <div class="alert alert-danger" role="alert">
    <p> {{session('error')}} </p>
  </div>
@endif

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Find The Services You Need</h1>
        </div>
    </div>
</header>
<!-- Container for dropdown filters -->
<div style="background-color: #f1f1f1; padding: 20px; text-align: center; display: flex; justify-content: center; align-items: center;">   
    <select style="margin-right: 10px; padding: 10px; width: 200px;" name="cat_id" id="category" class="filter-dropdown">
        <option value="">Filter by Category</option>
        @isset($categories)
        @foreach($categories as $cat)
            <option name="cat_id" id="cat_id" value="{{$cat->id}}">{{$cat->category_name}}</option>
        @endforeach
        @endisset
    </select>

    <select style="margin-right: 10px; padding: 10px; width: 200px;" name="serv_id" id="service" class="filter-dropdown">
        <option value="">Filter by Services</option>
        @isset($services)
        @foreach($services as $serv)
            <option name="serv_id" id="serv_id" value="{{$serv->id}}">{{$serv->service_name}}</option>
        @endforeach
        @endisset
    </select>
    <button id="clearFilters" style="padding: 10px; margin: 10px;">Clear Filters</button>
</div>

<section class="py-5" id="serviceSection">
    @isset($availableservices)
        @foreach($availableservices as $userEmail => $services)
            <div style="background-color: #f8f9fa; padding: 20px; margin: 0 -15px 20px -15px; border-radius: 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #333; font-size: 1.5rem;">Service Provider Information</h3>
                <p style="color: #666; display: inline-block; margin-right: 10px;">{{ $services[0]->name }}</p>
                <p style="color: #666; display: inline-block;">{{ $services[0]->email }}</p>
                <p style="color: #666; display: inline-block;">{{ $services[0]->phonenumber }}</p>
                <p style="color: #666; display: inline-block;">{{ $services[0]->zip }}</p>
                <p style="color: #666; display: inline-block;">{{ $services[0]->city }}</p>

            </div>
            <div class="container px-4 px-lg-5 mt-5" style="max-width: 2000px;">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach($services as $value)
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="{{ url('storage/images/'.$value->image)}}" style="width: 100%; height: 250px; object-fit: cover;"/>
                                <!-- Product details-->
                                <div class="card-body p-4" style="text-align: center;">
                                    <h4 class="fw-bolder" style="font-size: 1.25rem; font-weight: bold;">{{$value->category_name}}</h4>
                                    <h5 class="fw-bolder" style="font-size: 1.25rem; font-weight: bold;">{{$value->service_name}}</h5>
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <!-- Static stars for demo -->
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <div style="font-size: 1.1rem; font-weight: bold;">${{$value->rate}}</div>
                                    <p>{{$value->zip}}</p>
                                    <p>{{$value->city}}</p>
                                </div>
                                @if(Session::has('user_id'))
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" style="text-align: center;">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto btn-view" href="#viewdetails" data-service-id="{{$value->id}}" style="font-weight: bold;">View Details</a></div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endisset
</section>


<!-- Modal -->
<div class="modal fade" id="viewServiceModal" tabindex="-1" aria-labelledby="viewServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewServiceModalLabel">Book Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form starts here -->
        {!!Form::open(['method'=>'POST','url'=>'/requestavailableservice', 'id'=>'viewServiceModal'])!!}
        @csrf
          <input type="hidden" class="form-control" id="availability_id" name="availability_id" value="" >
          <div class="mb-3">
            <label for="category_name" class="form-label">Category</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="" readOnly={true}>
          </div>
          <div class="mb-3">
            <label for="service_name" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="" readOnly={true}>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" value="" readOnly={true}></textarea>
          </div>
          <div class="mb-3">
            <label for="rate" class="form-label">Rate : $</label>
            <input type="number" class="form-control" id="rate" name="rate" value="" readOnly={true}>
          </div>
          <div class="mb-3">
            <label for="zip" class="form-label">Zip</label>
            <input type="number" class="form-control" id="zip" name="zip" value="" readOnly={true}>
          </div>
          <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="" readOnly={true}>
          </div>
          <div class="mb-3">
          <label for="datetimepicker1">Select Date and Time</label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='datetime-local' id="datetimepicker1" name="datetimepicker1" class="form-control datetimepicker1"/>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Submit Request</button>
          {!!Form::close() !!}
        <!-- Form ends here -->
      </div>
    </div>
  </div>
</div>

@if(Session::has('user_id') && !Session::has('subscription'))
<div class="info-container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2 style="color: #343a40; text-align: center;">Provide Services!!</h2>
    <p style="color: #666; font-size: 16px; line-height: 1.5;">Subscribe to our website if you provide services of any kind!!</p>
    <p style="color: #666; font-size: 16px; line-height: 1.5;">Get access to 1000s of clients from our website!! Expand your Services!!</p>
    <p style="color: #666; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Subscription Rate of $20 per month!!</p>
    {!! Form::open(['method'=>'POST', 'url'=>'/subscribe', 'class'=>'form-inline']) !!}
    @csrf
    <div style="text-align: center;">
      <input type="hidden" class="form-control" id="subscribe" name="subscribe" value="{{ Session::get('user_id')}}">
        <select name="months" id="months" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="margin-right: 10px; width: auto; display: inline-block;" >
            <option value="" disabled selected>Select Subscription Period</option>
            <option value="1">1 Month</option>
            <option value="2">2 Months</option>
            <option value="3">3 Months</option>
            <option value="5">5 Months</option>
            <option value="6">6 Months</option>
            <option value="9">9 Months</option>
            <option value="12">12 Months</option>
        </select>
        <button type="submit" id="subscribe-button" style="background-color: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">Subscribe</button>
    </div>
    {!! Form::close() !!}
</div>
@endif

<script>
$(document).ready(function() {
      // Show Model to select the services and book appointment
      $(document).on('click', '.btn-view', function() {
        event.preventDefault();
        var available_id = $(this).data('service-id');
        var infoData = { available_id: available_id, _token: "{{ csrf_token() }}" };
        $.ajax({
            type: "POST",
            url: '/getavailableservice',
            data: infoData,
          success: function(response) {
            if (response.status === 'success') {

              //console.log(response.servicedata.id);

              $('#availability_id').val(response.servicedata.id);
              $('#category_name').val(response.servicedata.category_name);
              $('#service_name').val(response.servicedata.service_name);
              $('#description').val(response.servicedata.description);
              $('#rate').val(response.servicedata.rate);
              $('#zip').val(response.servicedata.zip);
              $('#city').val(response.servicedata.city);

            } else {
                console.error('Error: ', response.message);
                $('#viewServiceModal .modal-body').html('<p>Error loading service details.</p>');
            }
          },
          error: function(xhr) {
              console.error('Error: ', xhr.responseText);
              $('#viewServiceModal .modal-body').html('<p>Error loading service details.</p>');
          }
        });

        $('#viewServiceModal').modal('show');
      });

    $('.filter-dropdown').change(function(event) {
        event.preventDefault();
        var filterType = this.id; 
        var filterValue = $(this).val();
        var url = '/filter-by-' + filterType; // Adjust this if necessary
        var infoData = { filterType: filterType, filterValue: filterValue, _token: "{{csrf_token()}}" };

        $.post(url, infoData, function(response) {
            // Assuming the response contains services and possibly updated filter options
            updateServices(response);
            updateFilters(filterType, response);
        });
    });
  // document.addEventListener('DOMContentLoaded', function () {
  //   var select = document.getElementById('months');
  //   var button = document.getElementById('subscribe-button');

  //   select.addEventListener('change', function() {
  //     if (this.value) {  // If some value is selected
  //       button.style.display = 'inline-block';  // Show the button
  //     } else {
  //       button.style.display = 'none';  // Hide the button if no value is selected
  //     }
  //   });
  // });

    function updateServices(data) {
      var section = $('#serviceSection');
      section.empty(); // Clear previous contents

      $.each(data.availableservices, function(userEmail, services) {
          // Assuming the first service has representative data for the provider
          var providerContent = `
            <div style="background-color: #f8f9fa; padding: 20px; margin: 0 -15px 20px -15px; border-radius: 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #333; font-size: 1.5rem;">Service Provider Information</h3>
                <p style="color: #666; display: inline-block;">${services[0].name}</p>
                <p style="color: #666; display: inline-block;">${services[0].email}</p>
                <p style="color: #666; display: inline-block;">${services[0].phonenumber}</p>
                <p style="color: #666; display: inline-block;">${services[0].uzip}</p>
                <p style="color: #666; display: inline-block;">${services[0].ucity}</p>
            </div>
            <div class="container px-4 px-lg-5 mt-5" style="max-width: 2000px;">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        `;
          $.each(services, function(index, service) {
            providerContent += `
                  <div class="col mb-5">
                      <div class="card h-100">
                          <!-- Product image-->
                          <img class="card-img-top" src="{{ url('storage/images/` + service.image + `')}}" style="width: 100%; height: 250px; object-fit: cover;"/>
                          <!-- Product details-->
                          <div class="card-body p-4" style="text-align: center;">
                              <h4 class="fw-bolder" style="font-size: 1.25rem; font-weight: bold;">${service.category_name}</h4>
                              <h5 class="fw-bolder" style="font-size: 1.25rem; font-weight: bold;">${service.service_name}</h5>
                              <div class="d-flex justify-content-center small text-warning mb-2">
                                  <div class="bi-star-fill"></div>
                                  <div class="bi-star-fill"></div>
                                  <div class="bi-star-fill"></div>
                                  <div class="bi-star-fill"></div>
                                  <div class="bi-star-fill"></div>
                              </div>
                              <div style="font-size: 1.1rem; font-weight: bold;">$${service.rate}</div>
                              <p>${service.zip}</p>
                              <p>${service.city}</p>
                          </div>
                          @if(Session::has('user_id'))
                              <!-- Product actions-->
                              <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" style="text-align: center;">
                                  <div class="text-center"><a class="btn btn-outline-dark mt-auto btn-view" href="#viewdetails" data-service-id="${service.id}" style="font-weight: bold;">View Details</a></div>
                              </div>
                          @endif
                      </div>
                  </div>
              `;
          });

          providerContent += '</div></div>'; // Close container and row divs
          section.append(providerContent); // Append the whole structure to the main container
      });
    }

  function updateFilters(filterType, response) {
    var changedFilterId = filterType; // This is the ID of the dropdown that triggered the change
    if(filterType === "category"){
        var selectCategory = $('#category');
        var currentValue = selectCategory.val(); // Store current value to possibly reselect it

        selectCategory.empty().append('<option selected disabled>Choose a Category</option>');
        $.each(response.categories, function(index, category) {
            selectCategory.append($('<option>', {
                value: category.id,
                text: category.category_name,
                selected: category.id == currentValue
            }));
        });

        // Reset and repopulate the service dropdown
        var selectService = $('#service');
        selectService.empty().append('<option selected disabled>Choose a Service</option>');
        $.each(response.services, function(index, service) {
            selectService.append($('<option>', {
                value: service.id,
                text: service.service_name
            }));
        });
    }else if (filterType === "service"){
        var selectService = $('#service');
        var currentValue = selectService.val(); // Store current value to possibly reselect it
        selectService.empty().append('<option selected disabled>Choose a Service</option>');
        $.each(response.services, function(index, service) {
            selectService.append($('<option>', {
                value: service.id,
                text: service.Service_name,
                selected: service.id == currentValue
            }));
        });

        // Reset and repopulate the category dropdown
        var selectCategory = $('#category');
        selectCategory.empty().append('<option selected disabled>Choose a Category</option>');
        $.each(response.categories, function(index, category) {
            selectCategory.append($('<option>', {
                value: category.id,
                text: category.category_name,
            }));
        });
    }
  }

  $('#clearFilters').click(function() {
        window.location.reload();  // Refreshes the current page
  });

});


</script>

@endsection