@extends('layouts.app')

@section('content')

@if (session('success'))
  <div class="alert alert-success" role="alert">
    <p> {{session('success')}} </p>
  </div>
@endif

<div style="width: 100%; margin: 20px auto; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #343a40; color: #ffffff;">
            <tr style="background-color: #0000;">
                <th style="padding: 8px; border: 1px solid #ddd;">Category Name</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Service Name</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Requested Date</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Requested Time</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Rate</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Zip</th>
                <th style="padding: 8px; border: 1px solid #ddd;">City</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Requested</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Accepted</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Start Time</th>
                <th style="padding: 8px; border: 1px solid #ddd;">End Time</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Cost</th>
            </tr>
        </thead>
        <tbody style="background-color: #f8f9fa; color: #333333;">
        @isset($cartdata)
        @foreach($cartdata as $value)
            <tr> 
                <td style="padding: 8px; border: 1px solid #ddd;" value="{{$value->category_id}}">{{ $value->category_name }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;" value="{{$value->services_id}}">{{ $value->service_name }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->requesteddate }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->requestedtime }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->rate }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->zip }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->city }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->requested }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->accepted }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->jobstarttime ?: 'Not Started' }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->jobendtime ?: 'Not Started' }}</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $value->cost ?: 'Not Started' }}</td>
            </tr>
        @endforeach
        @endisset
        </tbody>
    </table>
</div>




@endsection