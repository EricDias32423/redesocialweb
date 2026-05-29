<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RegularUser;
use App\Models\Ong;
use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    /**
     * Enviar código por e-mail para redefinição de senha
     */
    public function forgot(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validated['email'];

        $user = $this->findUserByEmail($email);

        // Sempre retornar sucesso para não vazar existência de contas
        if ($user) {
            TwoFactorService::sendCode($user);
        }

        return response()->json(['message' => 'Se uma conta existir com esse e-mail, um código foi enviado.'], 200);
    }

    /**
     * Resetar senha usando código enviado por e-mail
     */
    public function resetWithCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = $this->findUserByEmail($validated['email']);

        if (!$user) {
            return response()->json(['message' => 'E-mail ou código inválido.'], 422);
        }

        // Verifica código e expiração (não ativa 2FA aqui)
        if (!isset($user->two_factor_code) || $user->two_factor_code !== $validated['code'] ||
            !isset($user->two_factor_expires_at) || now()->greaterThan($user->two_factor_expires_at)) {
            return response()->json(['message' => 'E-mail ou código inválido ou expirado.'], 422);
        }

        $user->password = Hash::make($validated['password']);
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Senha alterada com sucesso.'], 200);
    }

    /**
     * Buscar modelo de usuário apropriado pelo e-mail
     */
    protected function findUserByEmail(string $email)
    {
        $user = RegularUser::where('email', $email)->first();
        if ($user) return $user;

        $ong = Ong::where('email', $email)->first();
        if ($ong) return $ong;

        $u = User::where('email', $email)->first();
        if ($u) return $u;

        return null;
    }
}
