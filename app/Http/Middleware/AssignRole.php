<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\User;
use App\Roles;
use App\UserRoles;

class AssignRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        echo'<pre>';
        print_r($user);
        exit;
        $userrole = UserRoles::where('userid',$user->id)->first();

        if(!empty($userrole)){
            $role = Roles::where('id',$userrole->roleid)->first();
        }

        if ($role->rolename === 'Superadmin') {

            $request->request->add(['roles' => 'superadmin']); //add request

        } elseif ($role->rolename === 'Admin') {
            $request->request->add(['roles' => 'admin']); //add request

        } else {
            $request->request->add(['roles' => 'normaluser']); //add request

        }
        return $next($request);
    }
}
