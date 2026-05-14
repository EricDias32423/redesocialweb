<?php

namespace App\Http\Controllers;

use App\Models\RegularUser;
use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TwoFactorController extends Controller
{
    /**
     * Mostrar formulário de verificação 2FA
     */
    public function showVerifyForm(Request $request)
    {
        $userId = session('2fa_user_id');
        
        if (!$userId) {
        return redirect()->route('regular.login');        }
        
        return view('auth.verify-2fa', ['user_id' => $userId]);
    }

    /**
     * Verificar código 2FA
     */
    public function verify(Request $request)
{
    \Log::info('✅ STEP 1: Iniciando verify');
    \Log::info('✅ STEP 2: Request data: ' . json_encode($request->all()));
    
    $request->validate([
        'user_id' => 'required|exists:regular_users,id',
        'code' => 'required|string|size:6'
    ]);

    $user = RegularUser::find($request->user_id);
    \Log::info('✅ STEP 3: Usuário encontrado: ' . $user->id);
    \Log::info('✅ STEP 4: Código no banco: ' . $user->two_factor_code);
    \Log::info('✅ STEP 5: Código digitado: ' . $request->code);
    \Log::info('✅ STEP 6: Expira em: ' . $user->two_factor_expires_at);
    \Log::info('✅ STEP 7: Agora: ' . now());

    if (TwoFactorService::verifyCode($user, $request->code)) {
        \Log::info('✅ STEP 8: Código VÁLIDO!');
        
        if (session('2fa_enabling')) {
            \Log::info('✅ STEP 9: Está ativando 2FA');
            session()->forget('2fa_enabling');
            session()->forget('2fa_user_id');
            Auth::guard('regular')->login($user);
            \Log::info('✅ STEP 10: 2FA ATIVADO com sucesso!');
            return redirect()->route('regular.profile.edit')
                ->with('success', '2FA ativado com sucesso!');
        }
        
        \Log::info('✅ STEP 11: Login normal (não ativação)');
        Auth::guard('regular')->login($user);
        return redirect()->intended(route('regular.dashboard'))
            ->with('success', 'Login realizado com sucesso!');
    }

    \Log::info('❌ STEP 8: Código INVÁLIDO!');
    return back()
        ->withErrors(['code' => 'Código inválido ou expirado.'])
        ->withInput();
}

    /**
     * Reenviar código 2FA
     */
    public function resend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:regular_users,id'
        ]);

        $user = RegularUser::find($request->user_id);
        
        if (TwoFactorService::resendCode($user)) {
            return back()->with('success', 'Novo código enviado para seu e-mail!');
        }

        return back()->with('error', 'Erro ao reenviar código.');
    }
}