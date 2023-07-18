<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PermissionRequest;
use App\Models\Backend\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        return view('admin.backend.pages.permission.index', [
            'permissions' => Permission::all()
        ]);
    }
    public function create(){
        return view('admin.backend.pages.permission.crud');
    }

    public function store(PermissionRequest $request){

        Permission::create($request->validated());
        return redirect()->route("backend.permission-create")->with("success", "Permission created successfully.");
    }

    public function edit(Permission $permission){
        return view('admin.backend.pages.permission.crud',[
            'permission' => $permission
        ]);
    }
    public function update(PermissionRequest $request, Permission $permission){
        $permission->update($request->validated());
        return redirect()
            ->route('backend.permission-view')->with('success', "Permission updated successfully");
    }

    public function update_status(Permission $permission){
        $change_status = $permission->status == 1? 0 : 1;
        $permission->update([
            'status' => $change_status
        ]);
        return back()->with('success','Status changed successfully');
    }
}
