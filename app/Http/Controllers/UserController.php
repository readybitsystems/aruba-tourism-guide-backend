<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserRequest2;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->per_page ?? 5;
        
        $users = User::when($request->search, function ($query) use ($request) {
            $query->where('user_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('id', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE',  '%' . $request->search . '%');
        })->when($request->active, function ($query) {

            $query->whereRaw('flags & ?', [User::FLAG_ACTIVE]);

        })->where('role', '!=', 'admin')->paginate($perPage);
        
        return view('admin-db.users.index',['users' => $users]);
    }

    public function store(StoreUserRequest $request) // user registration
    {
        $user            = new User();
        $user->user_name = $request->user_name;
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        $user->password  = $request->password;
        $user->addFlag(User::FLAG_ACTIVE);
        $user->verification_code = rand(9999, 99999);
        if ($user->save()) {
            Mail::to($request->email)->send(new SendEmail($user));
            if (count(Mail::failures()) > 0) return response('Email couldn\'t send!', 500);

            if ($user->save()) {
                return redirect()
                    ->route('GetUsers')
                    ->with('success', 'user has been added successfully.');
            }
        }
        return response('User not added', 500);
    }


    public function addUserForm(REQUEST $request) // user registration
    {
        return view('admin-db.users.create');
    }

    public function me() // me call
    {
        $user = request()->user;
        if ($user)
            return $user;
        return response('user not found', 500);
    }
    public function edit(User $user)
    {
        return view('admin-db.users.edit', ['user' => $user]);
    }


    public function show(User $user)
    {
        if ($user)
            return $user;
        return response('User not found', 500);
    }

    public function profilePicture(User $user) // download user profile
    {
        return Storage::download($user->profile_image);
    }

    public function update(UpdateUserRequest $request, User $user) // update user
    {
        $user->user_name    = $request->input('user_name', $user->user_name);
        $user->email        = $request->input('email', $user->email);
        $user->phone        = $request->input('phone', $user->phone);
        if ($request->has('password') && filled($request->password))
            $user->password = $request->password;
        if ($request->has('role') && filled($request->role)) {
            $user->role = $request->role;
        }
        if ($user->save()) {
            if ($request->hasFile('profile_image')) {
                if ($user->user_profile) Storage::delete($user->user_profile);
                $profile_image = $request->file('profile_image')->store('users/' . $user->user_name);
                $user->user_profile = $profile_image;
                if ($user->save()) {
                    return $user;
                }
                return response('Profile did not update', 500);
            }
            if ($request->has('platform') && $request->filled('platform') && $request->platform == 'app') return $user;

            return redirect()
                    ->route('GetUsers')
                    ->with('success', 'user has been updated successfully.');
        }
    }
    
    public function destroy(User $user)
    {
        if ($user->delete()) 
        return redirect()
            ->route('GetUsers')
            ->with('success', 'User has been delete successfully.');
        return response('something went wrong. try later!');
    }

    public function editProfile(User $user)
    {
        $user = User::where('role', 'admin')->first();
        
        
        return view('admin-db.profile',['user' => $user]);
        
    }
    
    public function updateProfile(UpdateUserRequest $request)
    {
        $user = User::where('id', request()->user->id)->first();
        $user->user_name    = $request->input('user_name', $user->user_name);
        $user->phone    = $request->input('phone', $user->phone);
        if ($request->has('password') && $request->filled('password')) $user->password = $request->password;

        if (!$user->save())
            return response('There is some error!', 500);

        if (!is_dir(public_path("assets/users/" . request()->user->id))) {
            mkdir(public_path("assets/users/" .request()->user->id), 0777, true);
        }
        if ($request->has('profile_image')) {
            $image = addFile($request->file('profile_image'), public_path("assets/users/" .request()->user->id));
            $user->user_profile = $image;
            $user->save();
        }
        $user->save();
        return $user;
    }

    public function updateProfile2(UpdateUserRequest2 $request)
    {
        $user = User::where('id', request()->user->id)->first();
        $user->user_name    = $request->input('user_name', $user->user_name);
        $user->phone    = $request->input('phone', $user->phone);
        if ($request->has('password') && $request->filled('password')) $user->password = $request->password;

        if (!$user->save())
            return redirect()->back();

        if (!is_dir(public_path("assets/users/" . request()->user->id))) {
            mkdir(public_path("assets/users/" .request()->user->id), 0777, true);
        }
        if ($request->has('user_profile')) {
            $image = addFile($request->file('user_profile'), public_path("assets/users/" .request()->user->id));
            $user->user_profile = $image;
            $user->save();
        }
        $user->save();
        return redirect()->back();
    }

    
}
