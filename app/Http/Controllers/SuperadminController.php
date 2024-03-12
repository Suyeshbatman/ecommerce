<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Roles;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

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

        $userdata = User::all();
        
        return response()->json(['userdata' => $userdata, 'tabid' => $tabid]);

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

            $udata = User::all();

            return response()->json(['udata' => $udata, 'tabid' => $tabid]);

            // return view('dashboard.admindashboard')->with(['udata' => $udata, 'tabid' => $tabid])
            //                                         ->with(['jsonData' => json_encode(['udata' => $udata, 'tabid' => $tabid])]);
            //return view('dashboard.admindashboard', compact('udata', 'tabid'));             
        
    }

    public function addservices(Request $request)
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
        //$tab = $request->input('tab', 'addservices');
        $userrole = UserRoles::where('userid',$user->id)->first();

        $role = Roles::where('id',$userrole->roleid)->first();
        $request->session()->put('user_role', $role->rolename);

        $usdata = User::all();

        return response()->json(['usdata' => $usdata, 'tabid' => $tabid]);

        //return view('dashboard.admindashboard',['usdata'=>$udata,'tabid'=>$tabid]);
        //return view('dashboard.admindashboard');          
        
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
}
