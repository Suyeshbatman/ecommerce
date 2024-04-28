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
use App\Models\Subscriptions;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SuperadminController extends Controller
{
    public function index(Request $request)
    {
        $tabid = $request->tabid;
        
        if ($request->tabid == 'users'){

            return $this->superuser($request);

        }elseif($request->tabid == 'services'){

            return $this->superservices($request);

        }elseif($request->tabid == 'addservices'){

            return $this->addservices($request);

        }else{

            return $this->revenue($request);
            // return redirect()->action("SuperadminController@revenue", [$request]);
        }
    }

    public function superuser(Request $request)
    {
        $request = request();
        $tabid = $request->tabid;
        // print($request);
        // exit;
        $value = Session::get('user_id');
        // print($value);
        // exit;
        $user = User::where('id', $value)->first();

        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);
        $tab = $request->input('tab', 'users');
        $userrole = UserRoles::where('userid',$user->id)->first();

        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

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

        $normalusers = DB::table('users')
                        ->leftJoin('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                        ->whereNull('subscriptions.user_id')
                        ->select('users.*')
                        ->get(); 
        
        return response()->json(['unpaidsubscribers' => $unpaidsubscribers, 'paidsubscribers' => $paidsubscribers,'normalusers' => $normalusers,'tabid' => $tabid]);

        // return view('dashboard.admindashboard')->with(['userdata' => $userdata, 'tabid' => $tabid])
        //                                         ->with(['jsonData' => json_encode(['udata' => $udata, 'tabid' => $tabid])]);

        // return view('dashboard.admindashboard',['userdata'=>$userdata,'tab'=>$tab]);
        //return view('dashboard.admindashboard');      
        
    }

    public function superservices(Request $request)
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
            //$tab = $request->input('tab', 'services');
            $userrole = UserRoles::where('userid',$user->id)->first();
    
            $role = Roles::where('id',$userrole->roleid)->first();
            $request->session()->put('user_role', $role->rolename);

            $services = Services::all();


            return response()->json(['services' => $services, 'tabid' => $tabid]);          
        
    }

    public function addservices(Request $request)
    {
        $tabid = $request->tabid; 
        $value = Session::get('user_id');
        $user = User::where('id', $value)->first();

        // Preserving session setup
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);
        $userrole = UserRoles::where('userid', $user->id)->first();
        $role = Roles::where('id', $userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

        // Fetch categories and return them to the frontend
        $categories = Categories::all();
        
        // Return categories data along with the tab ID
        return response()->json(['categories' => $categories, 'tabid' => $tabid]);
    }
    

    public function revenue(Request $request)
    {
        $request = request();
        $tabid = $request->tabid;
        $user = User::where('id', Session::get('user_id'))->first();
        
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);

        $userrole = UserRoles::where('userid', $user->id)->first();
        $role = Roles::where('id', $userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

        // Fetch all records where 'paid' is 'Y'
        $subscriptions = DB::table('subscriptions')
                        ->join('users', 'subscriptions.user_id', '=', 'users.id')
                        ->where('subscriptions.paid', '=', 'Y')
                        ->select('users.name', 'users.email', 'subscriptions.request_interval', 'subscriptions.start_date', 'subscriptions.end_date')
                        ->get();

        $totalSubscribedUsers = $subscriptions->count();
        $totalMonthsSubscribed = $subscriptions->sum('request_interval');

        // Returning data as JSON
        return response()->json([
            'success' => true,
            'tabid' => $tabid,
            'totalSubscribedUsers' => $totalSubscribedUsers,
            'totalMonthsSubscribed' => $totalMonthsSubscribed,
            'subscribedUsers' => $subscriptions
        ]);              
        
    }

    public function registerservices(Request $request)
    {
        // print($request);
        // exit;
        $request->validate([
            'category_id' => 'required',
            'service_name'    => 'required',
            'description'    => 'required',
            'difficulty' => 'required', 
        ]);

        $data = $request->all();
        Services::create([
            'category_id' => $data['category_id'],
            'service_name' => $data['service_name'],
            'description' => $data['description'],
            'difficulty' => $data['difficulty'],
        ]);      

        $value = Session::get('user_id');
        $tabid = $request->addservices;
        // print($value);
        // exit;
        $user = User::where('id', $value)->first();

        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);
        $tab = $request->input('tab', 'users');
        $userrole = UserRoles::where('userid',$user->id)->first();

        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

        $services = Services::all(); // Fetch updated list of services
        return response()->json(['success' => true, 'activateTab' => 'services', 'services' => $services]);
    }

    public function registercategory(Request $request)
    {
        // print($request);
        // exit;
        $request->validate([
            'category_name'    => 'required',
        ]);

        $data = $request->all();
        Categories::create([
            'category_name' => $data['category_name'],
        ]);      

        $value = Session::get('user_id');
        $tabid = $request->addservices;
        // print($value);
        // exit;
        $user = User::where('id', $value)->first();

        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);
        $tab = $request->input('tab', 'users');
        $userrole = UserRoles::where('userid',$user->id)->first();

        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

        $categories = Categories::all();
        return response()->json(['success' => true, 'activateTab' => 'addservices', 'categories' => $categories]);
    }

    public function fetchServices()
    {
        $services = Services::all(); // Fetch all services
        return response()->json(['services' => $services]);
    }

    public function fetchCategories()
    {
        $categories = Categories::all();
        return response()->json(['categories' => $categories]);
    }

    public function deleteService(Request $request)
    {
        $service = Services::find($request->id);
        if ($service) {
            $service->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'Service not found'], 404);
        }
    }

    public function updatePaidStatus(Request $request)
    {
        $userId = $request->input('userId');
        $subscription = DB::table('subscriptions')
                            ->where('user_id', $userId)
                            ->update(['paid' => 'Y']);

        $role = DB::table('user_roles')
                    ->where('userid', $userId)
                    ->update(['roleid' => 2]);



        if ($subscription) {
            $users = User::all(); // Fetch updated list of users
            return response()->json(['success' => true, 'message' => 'User status updated successfully.', 'users' => $users]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update subscription.']);
        }
     }
     
    
}
