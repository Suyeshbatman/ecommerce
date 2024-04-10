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
use Image;

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

        $request->session()->put('user_name', $userdata->name);
        $request->session()->put('user_id', $userdata->id);

        $userrole = UserRoles::where('userid',$userdata->id)->first();

        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);
        
        return response()->json(['userdata' => $userdata, 'tabid' => $tabid]);    
        
    }

    public function providerservices(Request $request)
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
            
            $categories = Categories::all(); 
            // print($categories);
            // exit;
            
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
        $user = User::where('id', $value)->first();

        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_id', $user->id);
        //$tab = $request->input('tab', 'revenue');
        $userrole = UserRoles::where('userid',$user->id)->first();

        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

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
        print($request->monday);
        exit;
        $request->validate([
            'category_id' => 'required',
            'services_id'    => 'required',
            'image'    => 'required',
            'difficulty' => 'required', 
            'rate' => 'required',
            'zip' => 'required',
            'city' => 'required',
        ]);

        $value = Session::get('user_id');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save( storage_path('public/images/' . $filename ) );
            // $person->image = $filename;
            // $person->save();
        };

        $data = $request->all();
        Services::create([
            'user_id' => $value,
            'category_id' => $data['category_id'],
            'services_id' => $data['services_id'],
            'image' => $filename,
            'difficulty' => $data['difficulty'],
            'rate' => $data['rate'],
            'zip' => $data['zip'],
            'city' => $data['city'],
        ]);

    

        //$services = Services::where('category_id', $catid)->get();
        $tabid = 'providerservices';

        //return response()->json(['services' => $services, 'tabid' => $tabid]);

    }
}
