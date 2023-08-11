<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Models\Backend\Permission;
use App\Models\Backend\Role;
use App\Models\Backend\UserPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

    public function edit(User $user)
    {
        return view('admin.backend.pages.users.crud', [
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'selectedPermissions' => $user->permissions->pluck('id')->toArray(),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $userArray = ($request->password) ? collect($request->validated())->toArray() : collect($request->validated())->except('password')->toArray();

        $user->update($userArray);
        // Delete all the permissions associated with a specific user
        $user->permissions()->detach();
        $user->permissions()->sync($request->permissions);
        return redirect()
            ->route('backend.user-view')->with('success', "User updated successfully");
    }

    public function update_status(User $user)
    {
        $change_status = $user->status == 1 ? 0 : 1;
        $user->update([
            'status' => $change_status
        ]);
        return back()->with('success', 'Status changed successfully');
    }

    public function target(User $user){
        return view('admin.backend.pages.users.target',[
            "user" => $user
        ]);
    }

    public function post_target(Request $request, User $user){
        $validatedData = $request->validate([
            'standard_task' => 'required|integer|min:1',
            'standard_time' => 'required'
        ]);
        $user->update([
            'standard_time' => $validatedData['standard_time'],
            'standard_task' => $validatedData['standard_task'],
        ]);
        return redirect()->route('backend.user-view');
    }
    public function update_profile()
    {

        return view('admin.backend.pages.users.user_profile', [
            'user' => Auth::user()
        ]);
    }



    public function upload_photo()
    {
        return  view('admin.backend.pages.users.upload_photo');
    }

    public function post_upload_photo(Request $request)
    {


        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the max file size as per your requirements
        ]);

        $uploadedImage = $request->file('avatar');

        $imageName = time() . '_' . $uploadedImage->getClientOriginalName();



        $path = 'avatars/full/';
        $thumbnail_path = 'avatars/thumbnail/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (!file_exists($thumbnail_path)) {
            mkdir($thumbnail_path, 0777, true);
        }


        Image::make($uploadedImage)->save($path . $imageName);
        Image::make($uploadedImage)->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        }, 'top')->save(($thumbnail_path . $imageName));

        $user = Auth::user();
        $user->avatar = $imageName;
        $user->save();

        return redirect()->route('backend.user-update_profile');
    }

    public function update_password()
    {
        return view('admin.backend.pages.users.update_password');
    }

    public function post_update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the old password matches the user's current password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Incorrect old password. Please try again.']);
        }


        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('backend.user-update_profile');
    }

    public function user_permission(User $user)
    {
        return response()->json(User::find(request()->role_id)?->permissions);
    }
}
