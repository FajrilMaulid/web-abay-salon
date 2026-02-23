<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_logged_in' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->name]);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $admin->name . '!');
        }

        return back()->with('error', 'Email atau password salah.')->withInput();
    }

    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name']);
        return redirect()->route('admin.login')->with('success', 'Anda telah logout.');
    }
}
