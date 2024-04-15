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

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Find The Services You Need</h1>
        </div>
    </div>
</header>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
          @isset($availableservices)
          @foreach($availableservices as $value)
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="{{ url('storage/images/'.$value->image)}}"/>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h4 class="fw-bolder">{{$value->category_name}}</h4>
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{$value->service_name}}</h5>
                              <!-- Product reviews-->
                            <div class="d-flex justify-content-center small text-warning mb-2">
                              <div class="bi-star-fill"></div>
                              <div class="bi-star-fill"></div>
                              <div class="bi-star-fill"></div>
                              <div class="bi-star-fill"></div>
                              <div class="bi-star-fill"></div>
                            </div>
                            <!-- Product price-->
                            ${{$value->rate}}
                            <p>{{$value->zip}}</p>
                            <p>{{$value->city}}</p>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View Details</a></div>
                    </div>
                </div>
            </div>
          @endforeach
          @endisset
        </div>
    </div>
</section>

@endsection