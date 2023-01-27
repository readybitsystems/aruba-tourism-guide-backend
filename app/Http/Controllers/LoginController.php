<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForgetPasswordEmail;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Country;
use App\Models\Place;
use App\Models\Tour;
use App\Models\LoginAttempt;
use App\Mail\ResetPasswordLinkMail;
use App\Mail\ResetPasswordTokenMail;

class LoginController extends Controller
{
    function login(LoginRequest $request)
    {
        $user = User::where("email", $request->email)->first();
        if ($user && HASH::check($request->password, $user->password)) {
            if ($user->active && $user->role == User::ROLE_USER) {
                request()->user               = $user;
                $login_attempt                = new LoginAttempt();
                $login_attempt->user_id       = $user->id;
                $login_attempt->access_token  = generate_token($user);
                $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));
                if (!$login_attempt->save()) return api_error();
                return (object) ['user' => $user, 'access_token' => $login_attempt->access_token];
            } else if ($user->role == User::ROLE_ADMIN) {
                request()->user               = $user;
                $login_attempt                = new LoginAttempt();
                $login_attempt->user_id       = $user->id;
                $login_attempt->access_token  = generate_token($user);
                $login_attempt->access_expiry = date("Y-m-d H:i:s", strtotime("1 year"));
                if (!$login_attempt->save())
                    return redirect(route('LoginPage'))->with(['req_error' => 'Email/Password not match']);
                session(['user_token' => $login_attempt->access_token]);
            //    return getTokenWeb();
                // session()->get('user_token')
                // return $login_attempt->access_token;
                return redirect(route('Dashboard'))->with(['req_success' => 'Admin Login Successfully']);
            } else {
                return response(["message" => "Your Account is not active yet!"], 400);
            }
        } else {
            return response(["message" => "Invalid email / password"], 400);
        }
    }

    public function forgetPasswordEmail(ForgetPasswordEmail $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->reset_token = rand(99999, 999999);
            if ($user->save()) {
                Mail::to($user->email)->send(new ResetPasswordLinkMail($user));
                if (count(Mail::failures()) > 0) return response("Email couldn\'t send!", 500);
                return response("We have sent you a Token on to your email address. Kindly open it and change your password!");
            }
        }
        return response("Invalid token!", 500);
    }

    public function forget_password_email_verification(Request $request)
    {
        $request->validate(['email' => 'bail|required|email']);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->reset_token = rand(9999999, 999999999);
            if ($user->save()) {
                Mail::to($user->email)->send(new ResetPasswordTokenMail($user));
                if (count(Mail::failures()) > 0) return api_error('Email couldn\'t send!');

                return response('We have sent you a Token on to your email address. Kindly open it and change your password!');
            }
        }
        return api_error('Invalid email!');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('reset_token', $request->reset_token)->first();
        if ($user) {
            $user->reset_token = NULL;
            $user->password = $request->password;
            if ($user->save()) return response("Your password has been updated successfully! You can now log into your profile again!");
        }
        return response("Invalid token!", 500);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = User::where('email', request()->user->email)->first();
        if ($user) {
            $user->password = $request->password;
            if ($user->save()) return response("Your password has been updated successfully!");
        }
        return response("", 500);
    }

    public function logout(Request $request)
    {
        if ($request->login_attempt) {
            $request->login_attempt->access_expiry = date("Y-m-d H:i:s");
            $request->login_attempt->save();
        }
        return redirect(route('LoginPage'));
    }

    public function login_page()
    {
        if (!isset(request()->user))
            return view('admin-db.login');
        return redirect(route('GetCountries'));
    }

    public function dashboard() {
        $data['users'] = User::where('role', 'user')->get()->count();
        $data['languages'] = Country::get()->count();
        $data['places'] = Place::get()->count();
        $data['tours'] = Tour::get()->count();
        return view('admin-db.index', $data);
    }
}
