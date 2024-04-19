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
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
                //$imagefile->move('images', $filename);
                // $person->image = $filename;
                // $person->save();
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
}
