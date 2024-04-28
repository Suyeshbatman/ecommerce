<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Roles;
use App\Models\Categories;
use App\Models\Services;
use App\Models\Available_Services;
use App\Models\UserCart;
use App\Models\Subscriptions;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use DateTime;

class HomeController extends Controller
{

    public function fetchavailableservice(Request $request)
    {
        $servicedata = DB::table('available__services')
                ->join('services', 'available__services.services_id', '=', 'services.id')
                ->join('categories', 'available__services.category_id', '=', 'categories.id')
                ->where('available__services.id', $request->available_id)
                ->select('available__services.id', 'available__services.user_id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                ->first();
        
        //return response()->json(['servicedata' => $servicedata]);

        if ($servicedata) {
            return response()->json([
                'status' => 'success',
                'servicedata' => [
                    'id' => $servicedata->id,
                    'category_name' => $servicedata->category_name,
                    'service_name' => $servicedata->service_name,
                    'description' => $servicedata->description,
                    'rate' => $servicedata->rate,
                    'zip' => $servicedata->zip,
                    'city' => $servicedata->city,
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found.'
            ]);
        }
        
    }

    public function requestavailableservice(Request $request)
    {
        $value = Session::get('user_id');
        $request->validate([
            'datetimepicker1' => 'required',
        ]);

        // $requestdata = Available_Services::where('id', $request->availability_id)->first();
        $data = $request->datetimepicker1;

        $dateObject = new \DateTime($data);
        $date = $dateObject->format('Y-m-d');
        $time = $dateObject->format('H:i');

        $cartcheck = UserCart::where([
                    ['availability_id', $request->availability_id],
                    ['normaluser_id', $value],
                    ['requesteddate', $date],
                ])
                ->first();

        if (!empty($cartcheck)){
            $userdata = User::where('id', $value)->first();
            $availableservices = DB::table('available__services')
                    ->join('services', 'available__services.services_id', '=', 'services.id')
                    ->join('users', 'available__services.user_id', '=', 'users.id')
                    ->join('categories', 'available__services.category_id', '=', 'categories.id')
                    ->select('users.name', 'users.email','available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                    ->orderBy('users.name', 'asc')
                    ->get();

            $groupedServices = $availableservices->groupBy('email');

            $categories = Categories::all();
            $services = Services::all();   
            $request->session()->flash('error', 'You have already requested for the service on that particular date. Please change the date if you require the service on another date. Thank You!!');       

            return view('landing.home',['availableservices'=>$groupedServices, 'categories'=>$categories, 'services'=> $services]);  

        }else{

            UserCart::create([
                'normaluser_id' => $value,
                'availability_id' => $request->availability_id,
                'requesteddate' => $date,
                'requestedtime' => $time,
                'requested' => 'Y',
                'accepted' => 'N',
                'jobstarttime' => null,
                'jobendtime' => null,
                'completed' => 'N',
                'cost' => null,
            ]);
    
            $cartdata = DB::table('user_carts')
                    ->join('available__services', 'user_carts.availability_id', '=', 'available__services.id')
                    ->join('categories', 'available__services.category_id', '=', 'categories.id')
                    ->join('services', 'available__services.services_id', '=', 'services.id')
                    ->where('normaluser_id', $value)
                    ->select('user_carts.id','user_carts.requesteddate','user_carts.requestedtime','user_carts.requested','user_carts.accepted','user_carts.jobstarttime','user_carts.jobendtime','user_carts.completed','user_carts.cost','available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                    ->get();
    
            $request->session()->flash('success', 'You have successfully requested for the service on that particular date. Please change the date if you require the service on another date. Thank You!!');
            
            return view('landing.cart',['cartdata'=>$cartdata]);

        }
        
    }

    public function getcartdata(Request $request){

        $value = Session::get('user_id');

        $cartdata = DB::table('user_carts')
        ->join('available__services', 'user_carts.availability_id', '=', 'available__services.id')
        ->join('categories', 'available__services.category_id', '=', 'categories.id')
        ->join('services', 'available__services.services_id', '=', 'services.id')
        ->where('normaluser_id', $value)
        ->select('user_carts.id','user_carts.requesteddate','user_carts.requestedtime','user_carts.requested','user_carts.accepted','user_carts.jobstarttime','user_carts.jobendtime','user_carts.completed','user_carts.cost','available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
        ->get();

        return view('landing.cart',['cartdata'=>$cartdata]);
    }

    public function filterbycategory(Request $request){
        $catid = $request->filterValue;
        $availableservices = DB::table('available__services')
                    ->join('services', 'available__services.services_id', '=', 'services.id')
                    ->join('users', 'available__services.user_id', '=', 'users.id')
                    ->join('categories', 'available__services.category_id', '=', 'categories.id')
                    ->select('users.name', 'users.email','available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                    ->where('categories.id', $catid)
                    ->orderBy('users.name', 'asc')
                    ->get();

            $groupedServices = $availableservices->groupBy('email');

            $categories = Categories::all();
            $services = Services::where('category_id', $catid)->get(); 

            return response()->json(['success' => true, 'availableservices' => $groupedServices, 'categories'=>$categories, 'services'=>$services]);  

    }

    public function filterbyservice(Request $request){
        $servid = $request->filterValue;
        $availableservices = DB::table('available__services')
                    ->join('services', 'available__services.services_id', '=', 'services.id')
                    ->join('users', 'available__services.user_id', '=', 'users.id')
                    ->join('categories', 'available__services.category_id', '=', 'categories.id')
                    ->select('users.name', 'users.email','available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                    ->where('services.id', $servid)
                    ->orderBy('users.name', 'asc')
                    ->get();

            $groupedServices = $availableservices->groupBy('email');

            $categories = Categories::all();
            $services = Services::all();  

            return response()->json(['success' => true, 'availableservices' => $groupedServices, 'categories'=>$categories, 'services'=>$services]);  

    }

    public function filterbyprovider(Request $request){
        $providerid = $request->filterValue;
        $availableservices = DB::table('available__services')
                    ->join('services', 'available__services.services_id', '=', 'services.id')
                    ->join('users', 'available__services.user_id', '=', 'users.id')
                    ->join('categories', 'available__services.category_id', '=', 'categories.id')
                    ->select('users.name', 'users.email','available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                    ->where('available__services.user_id', $providerid)
                    ->orderBy('users.name', 'asc')
                    ->get();

            $groupedServices = $availableservices->groupBy('email');

            $categories = Categories::all();
            $services = Services::where('category_id', $catid)->get();
            $providers = DB::table('available__services')
                        ->join('users', 'available__services.user_id', '=', 'users.id')
                        ->select('users.name', 'users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();
            $groupedproviders = $providers->groupBy('email');  

            return response()->json(['success' => true, 'availableservices' => $groupedServices, 'categories'=>$categories, 'services'=>$services, 'providers'=>$groupedproviders]);  

    }
}
