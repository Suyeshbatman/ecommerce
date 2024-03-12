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
        
                        $userdata = User::all();
                        $data = Roles::all();

                        return view('dashboard.admindashboard',['userdata'=>$userdata,'data'=>$data]);
                        return view('dashboard.admindashboard');
        
                    } elseif ($role->rolename === 'Admin') {
                        // return view('dashboard.clientdashboard',['userdata'=>$userdata,'data'=>$data]);
                        return view('dashboard.clientdashboard');                                   
		            }  
                } else {
                    $request->session()->put('user_name', $user->name);
                    $request->session()->put('user_id', $user->id);

                    return redirect(route('home'));
                } 
		    }
        }
        else {
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_id', $user->id);

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
}
