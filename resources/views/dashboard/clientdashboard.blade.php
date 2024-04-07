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
        <tr>
          <th scope="row">1</th>
          <td>{{$userdata->name}}</td>
          <td>{{$userdata->email}}</td>
          <td>Admin</td>
        </tr>
      @endisset
      </tbody>
    </table>
  </div>

  <div class="tab-pane" id="providerservices">
    <h2>Add Service</h2>
    {!!Form::open(['method'=>'POST','url'=>'/addservices','class'=>'form-inline'])!!}
    @csrf
      <!-- New Categories Dropdown -->
      <input type="hidden" class="form-control" id="providerservices" name="providerservices">

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id" required>
          <option selected disabled value="">Choose a category</option>
          <!-- Options will be populated here dynamically -->
        </select>
    </div>

    <div class="mb-3">
        <label for="services_id" class="form-label">Services</label>
        <select class="form-select" id="services_id" name="services_id" required>
          <option selected disabled value="">Choose a service</option>
          <!-- Options will be populated here dynamically -->
        </select>
    </div>

    <div id="weekday-container">
        <div>
            <input type="checkbox" id="monday" name="monday">
            <label for="monday">Monday</label>
            <div class="show times" type= "hidden" id="mondaycheck" name="mondaycheck">
              <input type="checkbox" id="monday-morning" name="monday-time">
              <label for="monday-morning">Morning</label>
              <input type="checkbox" id="monday-afternoon" name="monday-time">
              <label for="monday-afternoon">Afternoon</label>
              <input type="checkbox" id="monday-evening" name="monday-time">
              <label for="monday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="tuesday" name="tuesday">
            <label for="tuesday">Tuesday</label>
            <div class="show times" id="tuesdaycheck" name="tuesdaycheck">
              <input type="checkbox" id="tuesday-morning" name="tuesday-time">
              <label for="tuesday-morning">Morning</label>
              <input type="checkbox" id="tuesday-afternoon" name="tuesday-time">
              <label for="tuesday-afternoon">Afternoon</label>
              <input type="checkbox" id="tuesday-evening" name="tuesday-time">
              <label for="tuesday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="wednesday" name="wednesday">
            <label for="wednesday">Wednesday</label>
            <div class="show times" id="wednesdaycheck" name="wednesdaycheck">
              <input type="checkbox" id="wednesday-morning" name="wednesday-time">
              <label for="wednesday-morning">Morning</label>
              <input type="checkbox" id="wednesday-afternoon" name="wednesday-time">
              <label for="wednesday-afternoon">Afternoon</label>
              <input type="checkbox" id="wednesday-evening" name="wednesday-time">
              <label for="wednesday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="thursday" name="thursday">
            <label for="thursday">Thursday</label>
            <div class="show times" id="thursdaycheck" name="thursdaycheck">
              <input type="checkbox" id="thursday-morning" name="thursday-time">
              <label for="thursday-morning">Morning</label>
              <input type="checkbox" id="thursday-afternoon" name="thursday-time">
              <label for="thursday-afternoon">Afternoon</label>
              <input type="checkbox" id="thursday-evening" name="thursday-time">
              <label for="thursday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="friday" name="friday">
            <label for="friday">Friday</label>
            <div class="show times" id="fridaycheck" name="fridaycheck">
              <input type="checkbox" id="friday-morning" name="friday-time">
              <label for="friday-morning">Morning</label>
              <input type="checkbox" id="friday-afternoon" name="friday-time">
              <label for="friday-afternoon">Afternoon</label>
              <input type="checkbox" id="friday-evening" name="friday-time">
              <label for="friday-evening">Evening</label>
            </div>
        </div>
    </div>

      <div class="mb-3">
        <label for="rate" class="form-label">Hourly rate</label>
        <input type="number" class="form-control" id="rate" name="rate" required>
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
    $('.nav-link').click(function(event) {
        event.preventDefault();
        var tabid = $(this).attr('data-target').substring(1);
        var url = '/clientdashboard';
        var infoData = { tabid: tabid, _token: "{{csrf_token()}}" };
        var clickedTabLink = $(this);
        console.log(infoData);
        $.post(url, infoData, function(response) {
            $('.tab-pane.active .table .tbody').empty();

            if (response.tabid == 'users') {
              //console.log(response);
              $('#users .table .tbody').append(response.userdata);

            } else if (response.tabid == 'providerservices') {
              var dropdown = $('#category_id');
                dropdown.empty();
                dropdown.append('<option selected disabled value="">Choose a category</option>');
                $.each(response.categories, function(index, category) {
                    dropdown.append($('<option>', {
                        value: category.id,
                        text: category.category_name
                    }));
                });
 
            } else if (response.tabid == 'appointments') {

            }
            
            $('.tab-pane').removeClass('active');
            $('#' + response.tabid).addClass('active');
            $('.nav-link').removeClass('active');
            clickedTabLink.addClass('active');
        })
    });

    $('#category_id').change(function(event) {
      event.preventDefault();
      var catid = $(this).val();
      //alert(catid);
      var url = '/getservices';
      var infoData = { catid: catid, _token: "{{csrf_token()}}" };
      $.post(url, infoData, function(response) {
        //console.log(response);
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

    $('#monday:checkbox').bind('change', function(event) {
      event.preventDefault();
      if ($(this).is(':checked')) {
        $('#mondaycheck').toggle();
      }
    });
});

// function editService(serviceIndex) {
//     // Placeholder function for future edit functionality
//     console.log("Edit service at index:", serviceIndex);
// }

</script>

@endsection