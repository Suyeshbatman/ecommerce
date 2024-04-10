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
    {!!Form::open(['method'=>'POST','url'=>'/createavailableservices', 'enctype' => 'multipart/form-data'])!!}
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

    <div id="weekday-container">
      <label for="availability">Availability</label>
        <div>
            <input type="checkbox" id="monday" name="monday">
            <label for="monday">Monday</label>
            <div class="show times"style="display:none;" id="mondaycheck" name="mondaycheck">
              <input type="checkbox" id="monday_morning" name="monday_morning" value ="1">
              <label for="monday-morning">Morning</label>
              <input type="checkbox" id="monday_afternoon" name="monday_afternoon" value ="1">
              <label for="monday-afternoon">Afternoon</label>
              <input type="checkbox" id="monday_evening" name="monday_evening" value ="1">
              <label for="monday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="tuesday" name="tuesday">
            <label for="tuesday">Tuesday</label>
            <div class="show times" style="display:none;" id="tuesdaycheck" name="tuesdaycheck">
              <input type="checkbox" id="tuesday_morning" name="tuesday_morning" value ="1">
              <label for="tuesday-morning">Morning</label>
              <input type="checkbox" id="tuesday_afternoon" name="tuesday_afternoon" value ="1">
              <label for="tuesday-afternoon">Afternoon</label>
              <input type="checkbox" id="tuesday_evening" name="tuesday_evening" value ="1">
              <label for="tuesday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="wednesday" name="wednesday">
            <label for="wednesday">Wednesday</label>
            <div class="show times" style="display:none;" id="wednesdaycheck" name="wednesdaycheck">
              <input type="checkbox" id="wednesday_morning" name="wednesday_morning" value ="1">
              <label for="wednesday-morning">Morning</label>
              <input type="checkbox" id="wednesday_afternoon" name="wednesday_afternoon" value ="1">
              <label for="wednesday-afternoon">Afternoon</label>
              <input type="checkbox" id="wednesday_evening" name="wednesday_evening" value ="1">
              <label for="wednesday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="thursday" name="thursday">
            <label for="thursday">Thursday</label>
            <div class="show times" style="display:none;" id="thursdaycheck" name="thursdaycheck">
              <input type="checkbox" id="thursday_morning" name="thursday_morning" value ="1">
              <label for="thursday-morning">Morning</label>
              <input type="checkbox" id="thursday_afternoon" name="thursday_afternoon" value ="1">
              <label for="thursday-afternoon">Afternoon</label>
              <input type="checkbox" id="thursday_evening" name="thursday_evening" value ="1">
              <label for="thursday-evening">Evening</label>
            </div>
        </div>
        <div>
            <input type="checkbox" id="friday" name="friday">
            <label for="friday">Friday</label>
            <div class="show times" style="display:none;" id="fridaycheck" name="fridaycheck">
              <input type="checkbox" id="friday_morning" name="friday_morning" value ="1">
              <label for="friday-morning">Morning</label>
              <input type="checkbox" id="friday_afternoon" name="friday_afternoon" value ="1">
              <label for="friday-afternoon">Afternoon</label>
              <input type="checkbox" id="friday_evening" name="friday_evening" value ="1">
              <label for="friday-evening">Evening</label>
            </div>
        </div>
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

    $('#monday:checkbox').change(function(event) {
      if($(this).is(":checked")){  //Return true/false 
            $('#mondaycheck').fadeIn('fast');
      }else{
            $('#mondaycheck').fadeOut('fast'); 
      }
    });
    $('#tuesday:checkbox').change(function(event) {
      if($(this).is(":checked")){  //Return true/false 
            $('#tuesdaycheck').fadeIn('fast');
      }else{
            $('#tuesdaycheck').fadeOut('fast'); 
      }
    });
    $('#wednesday:checkbox').change(function(event) {
      if($(this).is(":checked")){  //Return true/false 
            $('#wednesdaycheck').fadeIn('fast');
      }else{
            $('#wednesdaycheck').fadeOut('fast'); 
      }
    });
    $('#thursday:checkbox').change(function(event) {
      if($(this).is(":checked")){  //Return true/false 
            $('#thursdaycheck').fadeIn('fast');
      }else{
            $('#thursdaycheck').fadeOut('fast'); 
      }
    });
    $('#friday:checkbox').change(function(event) {
      if($(this).is(":checked")){  //Return true/false 
            $('#fridaycheck').fadeIn('fast');
      }else{
            $('#fridaycheck').fadeOut('fast'); 
      }
    });
});

</script>

@endsection