@extends('layouts.app')

@section('content')

@if(Session::has('user_id'))
<div class="info-container">
  <h2>Provide Services!!</h2>
  <p>Subscribe to our website if you provide services of any kind!!</p>
  <p>Get access to 1000s of clients from our website!! Expand your Services!!</p>
  <p>Subscription Rate of $50 per month!!  </p>
  {!!Form::open(['method'=>'POST','url'=>'/subscribe','class'=>'form-inline'])!!}
    @csrf
    <input type="hidden" class="form-control" id="subscribe" name="subscribe" value="{{ Session::get('user_id')}}">
    <select name='months' id ='months' class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
        <option selected>Select Subscription Period</option>
        <option id='months' name='months' value="1">1 Month</option>
        <option id='months' name='months' value="2">2 Months</option>
        <option id='months' name='months' value="3">3 Months</option>
        <option id='months' name='months' value="5">5 Months</option>
        <option id='months' name='months' value="6">6 Months</option>
        <option id='months' name='months' value="9">9 Months</option>
        <option id='months' name='months' value="12">12 Months</option>
    </select>
  <button id="subscribe">Subscribe</button>
  {!!Form::close() !!}
</div>
@endif


@endsection