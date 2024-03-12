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
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
          </tr>
        </thead>
        <tbody class="tbody">
        @isset($udata)
        @php
    $udataA = json_decode($udata);
@endphp
          @foreach ($udataA as $value)
          {{$value}}
          <tr>
            <th scope="row">1</th>
            <td>{{$value->name}}</td>
          </tr>
          @endforeach
        @endisset
        </tbody>
    </table>
  </div>

  <div class="tab-pane" id="addservices">
    ghasfghfasghdfasgjhd
  </div>

  <div class="tab-pane" id="revenue">
    ghasfghfasdjkgsbdfjkgsdjkfsdjkfsghdfasgjhd
  </div>
</div>


<script>
$(document).ready(function() {
    var token ="{{csrf_token()}}";
    // Add click event listeners to each tab link
    $('.nav-link').click(function(event) {
        event.preventDefault(); // Prevent the default behavior of the link
        
        // Get the target tab id
        var tabid = $(this).attr('data-target').substring(1); // Remove '#' from target id
        // Get the URL from the href attribute of the clicked link
        var url = ('/dashboard');
        var infoData= {tabid:tabid,_token:token};
        var clickedTabLink = $(this);

        //Simulate fetching content for the tab
        $.post(url, infoData, function(response) {
          if (response) { // Check if 'udata' exists in the response
              var tabid = response.tabid;
              var udata = response.udata; // Check if response is not empty or null
             
                // Remove active class from all tab panes
                $('.tab-pane').removeClass('active');
                  //console.log(udata);
                // Set the fetched data into the target tab content
                $('#' + tabid).html(udata);
                // Add active class to the target tab content
                $('#' + tabid).addClass('active');
                // Remove active class from all tab links
                $('.nav-link').removeClass('active');
                // Add active class to clicked tab link
                clickedTabLink.addClass('active');
                // clickedTabLink.addClass('active');
                // $(this).addClass('active');
            } else {
                // Handle the case when response is empty or null
                // For example, display a message or do nothing
                console.error('Empty response received.');
            }
        });
    });
});
</script>

@endsection