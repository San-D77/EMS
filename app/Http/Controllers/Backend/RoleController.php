<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RoleRequest;
use App\Models\Backend\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        return view('admin.backend.pages.role.index', [
            'roles' => Role::all()
        ]);
    }
    public function create(){
        return view('admin.backend.pages.role.crud');
    }

    public function store(RoleRequest $request){

        Role::create($request->validated());
        return redirect()->route("backend.role-create")->with("success", "Role created successfully.");
    }

    public function edit(Role $role){
        return view('admin.backend.pages.role.crud',[
            'role' => $role
        ]);
    }
    public function update(RoleRequest $request, Role $role){
        $role->update($request->validated());
        return redirect()
            ->route('backend.role-view')->with('success', "Role updated successfully");
    }

    public function update_status(Role $role){
        $change_status = $role->status == 1? 0 : 1;
        $role->update([
            'status' => $change_status
        ]);
        return back()->with('success','Status changed successfully');
    }
}
