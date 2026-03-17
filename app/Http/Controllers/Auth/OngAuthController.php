<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OngAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.ong.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'responsible_name' => 'required|string|max:255',
            'ong_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ongs',
            'password' => 'required|string|min:8|confirmed',
            'cnpj' => 'nullable|string|unique:ongs',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        
        $ong = Ong::create($validated);
        
        Auth::guard('ong')->login($ong);
        
        return redirect()->route('ong.dashboard')
            ->with('success', 'ONG cadastrada com sucesso!');
    }

    public function showLoginForm()
    {
        return view('auth.ong.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('ong')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('ong.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('ong')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}