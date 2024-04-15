@extends('layouts.app')
@section('content')
@isset($invalid)
@if (!empty($invalid))
<div class="alert alert-danger" role="alert">
  {{$invalid}}
</div>
@endif
@endisset
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    {!!Form::open(['method'=>'POST','url'=>'/login'])!!}
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" aria-describedby="emailHelp" placeholder="Enter email">
                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" placeholder="Password">
                            <span class="text-danger">@error('password') {{$message}} @enderror</span>
                        </div>
                        <!-- <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <button type="submit" class="btn btn-primary">Login</button> 
                    {!!Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
