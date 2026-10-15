<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthCMController extends Controller
{
    public function showLogin()
    {
        return view('auth.loginCM');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user && ($user->role ?? 'user') === 'admin') {
                return redirect()->route('admin.events.index');
            }
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'Identifiants invalides']);
    }

    public function showRegister()
    {
        return view('auth.registerCM');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string','min:1' ,'max:255'],
            'email' => ['required', 'email', 'unique:users,email','min:6','max:255'],
            'password' => ['required', 'min:6', 'confirmed','max:255','regex:/[A-Z]/','regex:/[0-9]/'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
