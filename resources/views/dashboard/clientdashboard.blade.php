@extends('layouts.app')
@section('admincontent')
<!-- @if (session('user_name'))
     <div class="alert alert-success">
         {{ session('user_name') }}
     </div>
@endif -->
<ul class="nav nav-pills nav-justified">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Edit Info</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Services</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Appointments</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Revenue</a>
  </li>
</ul>
@endsection