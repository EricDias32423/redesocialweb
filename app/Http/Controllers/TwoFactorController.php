<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\RegularUser;
use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function showVerifyForm(Request $request)
    {
        $userId = session('2fa_user_id');

        if (!$userId) {
            return redirect()->route('regular.login');
        }

        $userType = session('2fa_user_type', 'regular');

        return view('auth.verify-2fa', [
            'user_id' => $userId,
            'user_type' => $userType,
            'login_route' => $this->loginRoute($userType),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'user_type' => 'nullable|in:regular,ong',
            'code' => 'required|string|size:6',
        ]);

        $userType = session('2fa_user_type', 'regular');

        if (!$this->sessionMatchesRequest($request, $userType)) {
            return redirect()->route($this->loginRoute($userType))
                ->withErrors(['email' => 'Sessao de verificacao expirada. Faca login novamente.']);
        }

        $user = $this->findPendingUser((int) $request->user_id, $userType);

        if (!$user) {
            return redirect()->route($this->loginRoute($userType))
                ->withErrors(['email' => 'Conta nao encontrada. Faca login novamente.']);
        }

        if (TwoFactorService::verifyCode($user, $request->code)) {
            if (session('2fa_enabling')) {
                session()->forget(['2fa_enabling', '2fa_user_id', '2fa_user_type', '2fa_remember']);
                Auth::guard($userType)->login($user);

                return redirect()->route($userType === 'ong' ? 'ong.profile.edit' : 'regular.profile.edit')
                    ->with('success', '2FA ativado com sucesso!');
            }

            $remember = session('2fa_remember', false);
            session()->forget(['2fa_user_id', '2fa_user_type', '2fa_remember']);

            Auth::guard($userType)->login($user, $remember);
            $request->session()->regenerate();

            return redirect()->intended(route($userType === 'ong' ? 'ong.dashboard' : 'regular.dashboard'))
                ->with('success', 'Login realizado com sucesso!');
        }

        return back()
            ->withErrors(['code' => 'Codigo invalido ou expirado.'])
            ->withInput();
    }

    public function resend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'user_type' => 'nullable|in:regular,ong',
        ]);

        $userType = session('2fa_user_type', 'regular');

        if (!$this->sessionMatchesRequest($request, $userType)) {
            return redirect()->route($this->loginRoute($userType))
                ->withErrors(['email' => 'Sessao de verificacao expirada. Faca login novamente.']);
        }

        $user = $this->findPendingUser((int) $request->user_id, $userType);

        if (!$user) {
            return redirect()->route($this->loginRoute($userType))
                ->withErrors(['email' => 'Conta nao encontrada. Faca login novamente.']);
        }

        if (TwoFactorService::resendCode($user)) {
            return back()->with('success', 'Novo codigo enviado para seu e-mail!');
        }

        return back()->with('error', 'Erro ao reenviar codigo.');
    }

    private function sessionMatchesRequest(Request $request, string $userType): bool
    {
        return (int) session('2fa_user_id') === (int) $request->user_id
            && (!$request->filled('user_type') || $request->user_type === $userType);
    }

    private function findPendingUser(int $userId, string $userType): RegularUser|Ong|null
    {
        return $userType === 'ong'
            ? Ong::find($userId)
            : RegularUser::find($userId);
    }

    private function loginRoute(string $userType): string
    {
        return $userType === 'ong' ? 'ong.login' : 'regular.login';
    }
}
