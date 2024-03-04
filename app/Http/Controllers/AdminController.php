<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\User;
use App\UserRoles;
use App\Roles;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roleid' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        
        $roles = Roles_Users::where('userid',$request->userid)->get();

        if(empty($roles)){
            $userrole = new Roles_Users;
            $userrole->userid = $request->input('userid');
            $userrole->roleid = $request->input('roleid');

            $userrole->save();
        }else{
            $userrole = Roles_Users::findorFail($request->userid);
            $userrole->roleid = $request->input('roleid');

            $userrole->save();
        }
        

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usersdata = User::where('id',$id)->first();

        $roledata = Roles::all();
        
        return view('/superadmin.assignroles',['usersdata'=>$usersdata, 'roledata'=>$roledata]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
