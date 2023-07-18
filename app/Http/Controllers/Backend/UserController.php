<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Models\Backend\Permission;
use App\Models\Backend\Role;
use App\Models\Backend\UserPermission;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.backend.pages.users.index', [
            'users' => User::orderBy('id', 'desc')->get(),
        ]);
    }
    public function create()
    {
        return view('admin.backend.pages.users.crud', [
            'roles' => Role::all(),
            'permissions' => Permission::all()
        ]);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        $user->permissions()->detach();
        $user->permissions()->sync($request->permissions);
        return redirect()->route('backend.user-view')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user){
        return view('admin.backend.pages.users.crud',[
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'selectedPermissions' => $user->permissions->pluck('id')->toArray(),
        ]);
    }

    public function update(UserRequest $request, User $user){
        $userArray = ($request->password)? collect($request->validated())->toArray(): collect($request->validated())->except('password')->toArray();

        $user->update($userArray);
        // Delete all the permissions associated with a specific user
        $user->permissions()->detach();
        $user->permissions()->sync($request->permissions);
        return redirect()
                ->route('backend.user-view')->with('success', "User updated successfully");
    }

    public function update_status(User $user){
        $change_status = $user->status == 1? 0 : 1;
        $user->update([
            'status' => $change_status
        ]);
        return back()->with('success','Status changed successfully');
    }
    public function update_profile()
    {
        return view('admin.backend.pages.users.user_profile');
    }

    public function user_permission(User $user){
        return response()->json(User::find(request()->role_id)?->permissions);
    }
}
