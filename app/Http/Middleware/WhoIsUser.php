<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\User;
use App\UserRoles;
use App\Roles;

class WhoIsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $userrole = UserRoles::where('userid',$user->id)->first();

        if(!empty($userrole)){
            $role = Roles::where('id',$userrole->roleid)->first();
        }

        // $request->request->add(['role' => $role->rolename]);

        // view()->share(['request'=> $request]);

        if ($role->rolename === 'SuperAdmin') {

            $request->request->add(['roles' => 'superadmin']); //add request

        } elseif ($role->rolename === 'Admin') {

            $request->request->add(['roles' => 'admin']); //add request

        } else {

            $request->request->add(['roles' => 'normaluser']); //add request

        }
        
        return $next($request);
    }
}
