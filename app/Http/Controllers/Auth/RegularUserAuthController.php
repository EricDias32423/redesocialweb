<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegularUserAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.regular.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:regular_users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'nullable|string|unique:regular_users',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        $user = RegularUser::create($validated);
        
        Auth::guard('regular')->login($user);
        
        // Redirecionar para o dashboard (NÃO para o profile)
        return redirect()->route('regular.dashboard')
            ->with('success', 'Cadastro realizado com sucesso! Bem-vindo!');
    }

    public function showLoginForm()
    {
        return view('auth.regular.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('regular')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('regular.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('regular')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}