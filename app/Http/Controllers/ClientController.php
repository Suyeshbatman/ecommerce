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
use App\Models\Subscriptions;
use App\Models\UserCart;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function index(Request $request)
    { 
        if ($request->tabid == 'users'){

            return $this->user($request);

        }elseif($request->tabid == 'providerservices'){

            return $this->providerservices($request);

        }elseif($request->tabid == 'appointments'){

            return $this->appointments($request);

        }else{

            return $this->revenue($request);
            // return redirect()->action("SuperadminController@revenue", [$request]);
        }
    }

    public function user(Request $request)
    {
        $tabid = 'users';

        $value = Session::get('user_id');
        $userdata = User::where('id', $value)->first();
        $availableservices = DB::table('available__services')
                ->join('services', 'available__services.services_id', '=', 'services.id')
                ->join('categories', 'available__services.category_id', '=', 'categories.id')
                ->where('user_id', $value)
                ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                ->get();
        
        return response()->json(['userdata' => $userdata,'availableservices'=>$availableservices,'tabid' => $tabid]);    
        
    }

    public function providerservices(Request $request)
    {
        $request = request();
            $tabid = $request->tabid;
            $value = Session::get('user_id');
            // print($value);
            // exit;
            $user = User::where('id', $value)->first();

            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_id', $user->id);
            //$tab = $request->input('tab', 'services');
            $userrole = UserRoles::where('userid',$user->id)->first();
    
            $role = Roles::where('id',$userrole->roleid)->first();
            $request->session()->put('user_role', $role->rolename);
            
            $categories = Categories::all(); 
            
            return response()->json(['tabid' => $tabid, 'categories' => $categories]);         
        
    }

    public function appointments(Request $request)
    {
        $tabid = $request->tabid; 
        $value = Session::get('user_id');
        $user = User::where('id', $value)->first();
    
        // Preserving session setup
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);
        $userrole = UserRoles::where('userid',$user->id)->first();
        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);
    
        // Check if the requested tab is 'addservices'
            // Fetch categories and return only the names
            $categories = Categories::all();
            return response()->json(['categories' => $categories, 'tabid' => $tabid]);
    }
    

    public function revenue(Request $request)
    {
        $request = request();
        // print($request);
        // exit;
        $tabid = $request->tabid;
        $value = Session::get('user_id');
        // print($value);
        // exit;
        $user = User::where('id', $value)->first();

        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);
        //$tab = $request->input('tab', 'revenue');
        $userrole = UserRoles::where('userid',$user->id)->first();

        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

        $usedata = User::all();

        return response()->json(['usedata' => $usedata, 'tabid' => $tabid]);

        //return view('dashboard.admindashboard',['usedata'=>$usedata,'tabid'=>$tabid]);
        //return view('dashboard.admindashboard');                  
        
    }

    public function getservices(Request $request)
    {
        $catid = $request->catid;
        $value = Session::get('user_id');

        $services = Services::where('category_id', $catid)->get();
        $tabid = 'providerservices';

        return response()->json(['services' => $services, 'tabid' => $tabid]);

    }

    public function getdifficulty(Request $request)
    {
        $servid = $request->servid;

        $difficulty = Services::where('id', $servid)->pluck('difficulty');
        //$tabid = 'providerservices';

        return response()->json(['difficulty' => $difficulty]);

    }

    public function createavailableservices(Request $request)
    {

        $value = Session::get('user_id');
        $request->validate([
            'category_id' => 'required',
            'services_id'    => 'required',
            'image'    => 'required',
            'difficulty' => 'required', 
            'rate' => 'required',
            'zip' => 'required',
            'city' => 'required',
        ]);

        $checkservice = Available_Services::where([
            ['user_id', $value],
            ['services_id', $request->services_id],
        ])->first();

        if(!empty($checkservice)){
    
            $categories = Categories::all(); 
            //$request->session()->flash('error', 'You have already requested for the service on that particular date. Please change the date if you require the service on another date. Thank You!!');

            return response()->json(['error' => true, 'activateTab' => 'providerservices', 'categories' => $categories]);

        }else{

            if($request->hasFile('image')){
                $imagefile = $request->file('image');
                $filename = time() . '.' . $imagefile->getClientOriginalExtension();
                $imagefile->storeAs('public/images', $filename);
                //print()
            };
    
            $data = $request->all();
            Available_Services::create([
                'user_id' => $value,
                'category_id' => $data['category_id'],
                'services_id' => $data['services_id'],
                'image' => $filename,
                'difficulty' => $data['difficulty'],
                'rate' => $data['rate'],
                'zip' => $data['zip'],
                'city' => $data['city'],
            ]);
    
            
            $userdata = User::where('id', $value)->first();
            $availableservices = DB::table('available__services')
                    ->join('services', 'available__services.services_id', '=', 'services.id')
                    ->join('categories', 'available__services.category_id', '=', 'categories.id')
                    ->where('user_id', $value)
                    ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                    ->get();
    
            //return view('dashboard.clientdashboard',['userdata'=>$userdata, 'availableservices'=>$availableservices]);

            return response()->json(['success' => true, 'activateTab' => 'providerservices', 'userdata' => $userdata, 'availableservices' => $availableservices]);

        }
    }

    public function fetchuserdata()
    {
        $tabid = 'users';

        $value = Session::get('user_id');
        $userdata = User::where('id', $value)->get();
        $availableservices = DB::table('available__services')
                ->join('services', 'available__services.services_id', '=', 'services.id')
                ->join('categories', 'available__services.category_id', '=', 'categories.id')
                ->where('user_id', $value)
                ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                ->get();
        
        return response()->json(['userdata' => $userdata,'availableservices'=>$availableservices,'tabid' => $tabid]);    
        
    }

    public function getuserdata(Request $request)
    {
        $value = $request->user_id;
        $userdata = User::where('id', $value)->first();
        
        if ($userdata) {
            return response()->json([
                'status' => 'success',
                'userdata' => [
                    'id' => $userdata->id,
                    'name' => $userdata->name,
                    'email' => $userdata->email,
                    'phonenumber' => $userdata->phonenumber,
                    'address' => $userdata->address,
                    'zip' => $userdata->zip,
                    'city' => $userdata->city,
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ]);
        }  
        
    }

    public function edituserprofile(Request $request)
    {
        $value = $request->user_id;
        //$userdata = User::where('id', $value)->first();

        $request->validate([
            'first_name' => 'required',
            'email'    => 'required',
            'phonenumber' => 'required',
            'address'    => 'required',
            'zip1' => 'required',
            'city1'    => 'required',
        ]);

        
        $user = User::find($value);
        $user->name = $request->first_name;
        $user->email = $request->email; 
        $user->phonenumber = $request->phonenumber;
        $user->address = $request->address;
        $user->zip = $request->zip1;
        $user->city = $request->city1;  
        $data = $request->all();
        $user->update($data);

        $userdata = User::where('id', $value)->first();

        $availableservices = DB::table('available__services')
                ->join('services', 'available__services.services_id', '=', 'services.id')
                ->join('categories', 'available__services.category_id', '=', 'categories.id')
                ->where('user_id', $value)
                ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                ->get();
        
        return view('dashboard.clientdashboard',['userdata'=>$userdata, 'availableservices'=>$availableservices]);   
        
    }

    public function getservicedata(Request $request)
    {

        $user = Session::get('user_id');

        $value = $request->availability_id;
        $servicedata = DB::table('available__services')
                        ->join('services', 'available__services.services_id', '=', 'services.id')
                        ->join('categories', 'available__services.category_id', '=', 'categories.id')
                        ->where('available__services.id', $value)
                        ->where('available__services.user_id', $user)
                        ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                        ->first();
        
        if ($servicedata) {
            return response()->json([
                'status' => 'success',
                'servicedata' => [
                    'id' => $servicedata->id,
                    'category_name' => $servicedata->category_name,
                    'service_name' => $servicedata->service_name,
                    'image' => $servicedata->image,
                    'rate' => $servicedata->rate,
                    'zip' => $servicedata->zip,
                    'city' => $servicedata->city,
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ]);
        }  
        
    }

    public function edituserservice(Request $request)
    {
        $value = Session::get('user_id');

        $request->validate([
            'rate2' => 'required',
            'zip2' => 'required',
            'city2' => 'required',
        ]);

        
        $service = Available_Services::find($request->availability_id);
        //$service->image = $filename;
        $service->rate = $request->rate2;   
        $service->zip = $request->zip2; 
        $service->city = $request->city2; 
        $data = $request->all();
        $service->update($data);

        $userdata = User::where('id', $value)->first();

        $availableservices = DB::table('available__services')
                ->join('services', 'available__services.services_id', '=', 'services.id')
                ->join('categories', 'available__services.category_id', '=', 'categories.id')
                ->where('user_id', $value)
                ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                ->get();
        
        return view('dashboard.clientdashboard',['userdata'=>$userdata, 'availableservices'=>$availableservices]);   
        
    }

    public function deleteuserService(Request $request)
    {
        $cartcheck = UserCart::where([
            ['availability_id', $request->availabilityid],
        ])
        ->get();

        if ($cartcheck->isNotEmpty()) {
            // Check if any of the entries are not completed
            $incompleteExists = $cartcheck->contains(function ($value) {
                return $value->completed === 'N';
            });
        
            if ($incompleteExists) {
                // If any record has 'completed' as 'N', return an error response
                return response()->json([
                    'success' => false,
                    'error' => 'Service requested has not been completed. Check Appointments tab for details.'
                ], 404);
            } else {
                // If all records are 'completed' as 'Y', proceed to delete
                DB::transaction(function () use ($request) {
                    // Delete all UserCart entries
                    UserCart::where('availability_id', $request->availabilityid)->delete();
                    
                    // Attempt to find and delete the service entry
                    $deleteservice = Available_Services::find($request->availabilityid);
                    if ($deleteservice) {
                        $deleteservice->delete();
                        return response()->json(['success' => true, 'message' => 'Service and associated cart data deleted successfully.']);
                    } else {
                        return response()->json(['success' => false, 'error' => 'Service not found.'], 404);
                    }
                });
        
                // Return success response outside of transaction for clarity
                return response()->json(['success' => true, 'message' => 'Service and associated cart data deleted successfully.']);
            }
        } else {
            // If there are no entries, respond accordingly
            return response()->json([
                'success' => false,
                'error' => 'No service found to delete.'
            ], 404);
        }

    }

    public function fetchappointmentdata()
    {
        $value = Session::get('user_id');
        
        $combinedInfo = DB::table('available__services')
        ->join('services', 'available__services.services_id', '=', 'services.id')
        ->join('categories', 'available__services.category_id', '=', 'categories.id')
        ->join('user_carts', 'available__services.id', '=', 'user_carts.availability_id')
        ->leftJoin('users', 'user_carts.normaluser_id', '=', 'users.id')  
        ->where('available__services.user_id', $value)  
        ->select(
            'available__services.id as available_service_id',
            'available__services.category_id',
            'categories.category_name',
            'available__services.services_id',
            'services.service_name',
            'available__services.rate',
            'user_carts.id',
            'user_carts.normaluser_id',
            'user_carts.requesteddate',
            'user_carts.requestedtime',
            'user_carts.accepted',
            'user_carts.completed',
            'users.name as user_name',  
            'users.email as user_email'  
        )
        ->get();

        return response()->json(['success' => true, 'combinedInfo' => $combinedInfo]);       
    }

    public function appointmentactions(Request $request)
    {
        $cost = Usercart::where('id',$request->cart_id)->first();
        try{
            if($request->role === "accept"){
                $cart = UserCart::find($request->cart_id);
                $data = $request->only(['accepted']);
                $data['accepted'] = 'Y';   
                $cart->update($data);
                return response()->json(['status' => 'success', 'message' => 'Successfully accepted!!']);
            }else if($request->role === "reject"){
                if($cost->accepted == 'Y' && $cost->jobstarttime !== null){
                    return response()->json(['status' => 'error', 'message' => 'Cannot reject, the job already started!!'], 400);
                    
                }else{
                    $cart = UserCart::find($request->cart_id);
                    $data = $request->only(['accepted']);
                    $data['accepted'] = 'R';  
                    $cart->update($data);
                    return response()->json(['status' => 'success', 'message' => 'Successfully rejected!!']);
                }
            }else if($request->role === "startjob"){

                if($cost->accepted == 'Y' && $cost->jobstarttime == null){
                    $cart = UserCart::find($request->cart_id);
                    $data = $request->only(['jobstarttime']);
                    $starttime = Carbon::now()->format('H:i:s');
                    $data['jobstarttime'] = $starttime;   
                    $cart->update($data);
                    return response()->json(['status' => 'success', 'message' => 'Successfully started job!!']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Cannot start job!!'], 400);
                }

            }else if ($request->role === "endjob") {
                $cart = UserCart::find($request->cart_id);
            
                if (!$cart || $cart->jobstarttime === null) {
                    return response()->json(['status' => 'error', 'message' => 'Cannot end job before starting it!!'], 400);
                }
            
                // Update job end time and completed status
                $endtime = Carbon::now()->format('H:i:s');
                $cart->jobendtime = $endtime;
                $cart->completed = 'Y';
                $cart->save();
            
                // Refresh cart to ensure it reflects the latest data
                $cart->refresh();
            
                $rate = Available_Services::where('id', $cart->availability_id)->first()->rate;
                $startTime = Carbon::createFromFormat('H:i:s', $cart->jobstarttime);
                $endTime = Carbon::createFromFormat('H:i:s', $cart->jobendtime);
            
                $durationInMinutes = $endTime->diffInMinutes($startTime);
                if ($durationInMinutes == 0) {
                    $durationInMinutes = 1;
                }
                $durationInHours = $durationInMinutes / 60.0;  // Convert minutes to hours correctly
            
                $costcalculation = $durationInHours * $rate;
                $costcalculation = ceil($costcalculation * 100) / 100;
            
                // Update the cost
                $cart->cost = $costcalculation;
                $cart->save();
            
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Successfully finished job!! Please check revenue tab for details!!'
                ]);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Invalid action!!'], 400);
            }  
        
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function fetchrevenuedata()
    {
        $value = Session::get('user_id');
        
        $combinedInfo = DB::table('available__services')
            ->join('services', 'available__services.services_id', '=', 'services.id')
            ->join('categories', 'available__services.category_id', '=', 'categories.id')
            ->join('user_carts', 'available__services.id', '=', 'user_carts.availability_id')
            ->leftJoin('users', 'user_carts.normaluser_id', '=', 'users.id')
            ->where('available__services.user_id', $value)
            ->select(
                'available__services.id as available_service_id',
                'available__services.category_id',
                'categories.category_name',
                'available__services.services_id',
                'services.service_name',
                'available__services.rate',
                'user_carts.id as user_cart_id',
                'user_carts.normaluser_id',
                'user_carts.requesteddate',
                'user_carts.requestedtime',
                'user_carts.accepted',
                'user_carts.completed',
                'user_carts.jobstarttime',
                'user_carts.jobendtime',
                'user_carts.cost',  
                'users.name as user_name',
                'users.email as user_email'
            )
            ->get();

        // Calculate the total cost separately
        $totalCost = DB::table('available__services')
            ->join('user_carts', 'available__services.id', '=', 'user_carts.availability_id')
            ->where('available__services.user_id', $value)
            ->sum('user_carts.cost');

        return response()->json([
            'success' => true, 
            'combinedInfo' => $combinedInfo, 
            'totalCost' => $totalCost
        ]);      
    }
}
