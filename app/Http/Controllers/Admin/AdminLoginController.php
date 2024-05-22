<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Handle login attempt for admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            // Login berhasil, redirect ke dashboard admin
            return redirect()->route('admin.dashboard');
        }
    
        // Login gagal, kembali ke form login dengan pesan error
        return back()->withErrors(['username' => 'These credentials do not match our records.']);
    }
    public function logout()
    {
        Auth::guard('admin')->logout();  // Memastikan logout dilakukan pada guard admin

        request()->session()->invalidate();  // Menghapus data sesi
        request()->session()->regenerateToken();  // Membuat ulang CSRF token

        return redirect('/admin/login');  // Mengarahkan kembali ke halaman login admin
    }
    

    
}
