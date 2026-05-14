<?php

namespace App\Http\Controllers;

use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    use App\Services\TwoFactorService;

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Autenticar para verificar senha
    if (Auth::guard('regular')->attempt($credentials, $request->boolean('remember'))) {
        $user = Auth::guard('regular')->user();
        
        // Verificar se 2FA está ativado
        if (TwoFactorService::isEnabled($user)) {
            // Enviar código e salvar user_id na sessão
            TwoFactorService::sendCode($user);
            session(['2fa_user_id' => $user->id]);
            
            Auth::guard('regular')->logout();
            $request->session()->invalidate();
            
            return redirect()->route('2fa.verify')
                ->with('info', 'Digite o código de verificação enviado para seu e-mail.');
        }
        
        // Sem 2FA, login normal
        $request->session()->regenerate();
        return redirect()->intended(route('regular.dashboard'));
    }

    return back()->withErrors([
        'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
    ])->onlyInput('email');
}

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'ong_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048'
        ], [
            'name.required' => 'O nome do responsável é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
            'password.confirmed' => 'A confirmação de senha não coincide',
            'ong_name.required' => 'O nome da ONG é obrigatório',
            'logo.image' => 'O arquivo deve ser uma imagem',
            'logo.max' => 'A imagem deve ter no máximo 2MB'
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($validated);
        
        Auth::login($user);

        return redirect('/')
            ->with('success', 'Cadastro realizado com sucesso! Bem-vindo à Rede Social de ONGs!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'Logout realizado com sucesso! Volte sempre!');
    }
}