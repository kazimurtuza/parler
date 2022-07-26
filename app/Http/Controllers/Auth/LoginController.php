<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Array_;

class LoginController extends Controller
{
    public function showLogin()
    {
        $common_data = new Array_();
        $common_data->title = 'Login';
        $common_data->page_title = 'Login';

        return view('admin.auth.login')->with(compact('common_data'));
    }

    public function submitLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);


        $user = User::where('email', $request->email)->first();
        /*if ($user->email_verified_at == null) {
            return redirect()->back()->with(['failed' => 'Your email is not verified.']);
        }*/

        if ($user->deleted == 1) {
            return redirect()->back()->with(['failed' => 'Account Deleted!'])->withInput($request->all());
        }

        if ($user->status == 0) {
            return redirect()->back()->with(['failed' => 'Inactive Account. Please contact wth admin.'])->withInput($request->all());
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with(['failed' => 'Invalid Password!'])->withInput($request->all());
        }

        Auth::login($user, $request->remember);

        return redirect()->route('admin.index')->with(['success' => 'Login Success', 'alert_type' => 'toastr']);
    }


    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect()->route('auth.login')->with(['success' => 'Logout Success.']);
        } else {
            return redirect()->route('auth.login')->with(['failed' => 'You are not logged in!']);
        }
    }
}
