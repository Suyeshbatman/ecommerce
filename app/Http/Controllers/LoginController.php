<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Roles;
use App\Models\Subscriptions;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    
    public function index(Request $request)
    {
        if (Session::has('user_id')){
            $value = Session::get('user_id');

            $user = User::where('id', $value)->first();

            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_id', $user->id);
                $userrole = UserRoles::where('userid',$user->id)->first();
    
                if(!empty($userrole)){
                    $role = Roles::where('id',$userrole->roleid)->first();
                }
                $request->session()->put('user_role', $role->rolename);
    
                if ($role->rolename === 'Superadmin') {
    
                    $userdata = User::all();
                    $data = Roles::all();
                    return view('dashboard.admindashboard',['userdata'=>$userdata,'data'=>$data]);
                    //return view('dashboard.admindashboard');
    
                } elseif ($role->rolename === 'Admin') {
                    $userdata = User::all();
                    return view('dashboard.clientdashboard',['userdata'=>$userdata,'data'=>$data]);
                    //return view('dashboard.clientdashboard');
    
                } else {
                    return redirect(route('home'));
                }      
		}
        else {           
            return view('auth.login'); 
        }                  
        
    }

    public function redirect()
    {
        $invalid = "Invalid Username/Password"; 
                  
        return view('auth.login',['invalid'=>$invalid]); 
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'email'           => 'required|max:255|email',
            'password'           => 'required|min:5|max:10',
        ]);

        $user = User::where('email', $request->email)->first();

		if (!empty($user)) {          
			if (!Hash::check($request->password, $user->password)) {
                return redirect()->route('redirect');
			}
            else {
                $request->session()->put('user_name', $user->name);
                $request->session()->put('user_id', $user->id);
                $userrole = UserRoles::where('userid',$user->id)->first();
    
                if(!empty($userrole)){

                    $role = Roles::where('id',$userrole->roleid)->first();
                
                    $request->session()->put('user_role', $role->rolename);
    
                    if ($role->rolename === 'Superadmin') {

                        $unpaidsubscribers = DB::table('users')
                                ->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                                ->where('paid', '=', 'N')
                                ->select('users.*')
                                ->get();
                        $paidsubscribers = DB::table('users')
                                ->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                                ->where('paid', '=', 'Y')
                                ->select('users.*')
                                ->get();

                        return view('dashboard.admindashboard',['unpaidsubscribers' => $unpaidsubscribers, 'paidsubscribers' => $paidsubscribers]);
                        //return view('dashboard.admindashboard');
        
                    } elseif ($role->rolename === 'Admin') {

                        $value = Session::get('user_id');
                        $userdata = User::where('id', $value)->first();
                        $availableservices = DB::table('available__services')
                                ->join('services', 'available__services.services_id', '=', 'services.id')
                                ->join('categories', 'available__services.category_id', '=', 'categories.id')
                                ->where('user_id', $value)
                                ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                                ->get();

                        return view('dashboard.clientdashboard',['userdata'=>$userdata, 'availableservices'=>$availableservices]);  

		            } elseif ($role->rolename === 'Normal') {
                        // return view('dashboard.clientdashboard',['userdata'=>$userdata,'data'=>$data]);
                        $value = Session::get('user_id');
                        $userdata = User::where('id', $value)->first();
                        $availableservices = DB::table('available__services')
                                ->join('services', 'available__services.services_id', '=', 'services.id')
                                ->join('categories', 'available__services.category_id', '=', 'categories.id')
                                ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                                ->get();
                
                        return view('landing.home',['userdata'=>$userdata, 'availableservices'=>$availableservices]);                                 
                    } else{

                        return redirect(route('home'));
                    }
                } 
		    }
        }
        else {
            return redirect(route('home'));
        } 
        
    }

    public function register(Request $request)
    {
        if (Session::has('user_id')){
            $value = Session::get('user_id');

            $user = User::where('id', $value)->first();

            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_id', $user->id);
            $userrole = UserRoles::where('userid',$user->id)->first();
    
                if(!empty($userrole)){
                    $role = Roles::where('id',$userrole->roleid)->first();
                }
                $request->session()->put('user_role', $role->rolename);
    
                if ($role->rolename === 'Superadmin') {
    
                    $userdata = User::all();
                    $data = UserRoles::where('userid',$userdata->id);
                    return view('dashboard.admindashboard',['userdata'=>$userdata,'data'=>$data]);
                    //return view('dashboard.admindashboard');
    
                } elseif ($role->rolename === 'Admin') {
                    return view('dashboard.clientdashboard',['userdata'=>$userdata,'data'=>$data]);
                    //return view('dashboard.clientdashboard');
    
                } else {
                    return redirect(route('home'));
                }      
		}
        else {
        return view('auth.register');
        }
        
    }

    public function registeruser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email'    => 'required|max:255|email|unique:users',
            'password' => 'required|min:5|max:10', 
        ]);

        $data = $request->all();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);    

        $newuser = User::where('email', $data['email'])->first();

        UserRoles::create([
            'userid' => $newuser->id,
            'roleid' => '3',
        ]); 


        return redirect(route('login'))->with("success", "User Created!!! Login Required");
    }

    public function logout()
    {
        if (Session::has('user_name')){
            Session::pull('user_name');
            Session::flush();
        }
        return redirect(route('login'));
        
    }

    public function subscribeuser(Request $request)
    {
        if (!empty($request)){
        $value = $request->subscribe;
        $interval = $request->months;
        }else{
            return view('auth.register');
        }
        
        if (!empty($value)){
            
            $user = User::where('id', $value)->first();

            $userrole = UserRoles::where('userid',$user->id)->first();

            if(!empty($userrole)){

                $request->session()->put('user_name', $user->name);
                $request->session()->put('user_id', $user->id);

                $role = Roles::where('id',$userrole->roleid)->first();
                $request->session()->put('user_role', $role->rolename);
    
                if ($role->rolename === 'Superadmin') {
    
                    $userdata = User::all();
                    $data = Roles::all();
                    return view('dashboard.admindashboard',['userdata'=>$userdata,'data'=>$data]);
                    //return view('dashboard.admindashboard');
    
                } elseif ($role->rolename === 'Admin') {
                    return view('dashboard.clientdashboard',['userdata'=>$userdata,'data'=>$data]);
                    //return view('dashboard.clientdashboard');
    
                } elseif ($role->rolename === 'Normal') {
                    // print($value);
                    // exit;
                    $currentDateTime = Carbon::now();
                    //$newDateTime = Carbon::now()->addMonth();
                    $newDateTime = Carbon::now()->addMonth($interval);
                    // print($currentDateTime);
                    // print($newDateTime);
                    // exit;
        
                Subscriptions::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'request' => 'Y',
                    'request_interval' => $interval,
                    'paid' => 'N',
                    'start_date' => $currentDateTime,
                    'end_date' => $newDateTime,
                ]);   
                $value = Session::get('user_id');
                $userdata = User::where('id', $value)->first();
                $availableservices = DB::table('available__services')
                        ->join('services', 'available__services.services_id', '=', 'services.id')
                        ->join('categories', 'available__services.category_id', '=', 'categories.id')
                        ->select('available__services.id','available__services.category_id','categories.category_name', 'available__services.services_id','services.service_name', 'services.description', 'available__services.image', 'available__services.rate', 'available__services.zip','available__services.city')
                        ->get();
        
                return view('home',['userdata'=>$userdata, 'availableservices'=>$availableservices]);  
                //return redirect(route('home'))->with("success", "Requested for Subscription!!!  We will contact you soon.");
                }      
                
            }else{
                return view('auth.login'); 
            }     
		}
        else {           
            return view('auth.login'); 
        }                  
        
    }
}
