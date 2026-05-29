<?php

namespace App\Services;

use App\Jobs\SendTwoFactorCodeJob;
use App\Mail\TwoFactorCodeMail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class TwoFactorService
{
    /**
     * Gerar código aleatório de 6 dígitos
     */
    public static function generateCode(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Salvar código no banco e enviar por e-mail
     */
    public static function sendCode(Model $user): bool
    {
        $code = self::generateCode();
        
        // Salvar código e expiração (2 minutos para testes)
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = Carbon::now()->addMinutes(2);
        $user->save();
        
        // Enviar e-mail: se a fila for síncrona, enviar direto; caso contrário, dispatch para a fila
        if (config('queue.default') === 'sync') {
            $name = $user->name ?? $user->ong_name ?? $user->responsible_name ?? 'usuario';
            Mail::to($user->email)->send(new TwoFactorCodeMail($code, $name));
        } else {
            // Disparar job para enviar e-mail (background)
            SendTwoFactorCodeJob::dispatch($user, $code);
        }
        
        return true;
    }

    /**
     * Verificar se o código é válido
     */
   public static function verifyCode(Model $user, string $code): bool
{
    \Log::info('🔑 VERIFY: Verificando código');
    \Log::info('🔑 VERIFY: two_factor_code: ' . $user->two_factor_code);
    \Log::info('🔑 VERIFY: two_factor_expires_at: ' . $user->two_factor_expires_at);
    \Log::info('🔑 VERIFY: code input: ' . $code);
    
    if ($user->two_factor_code === $code && 
        $user->two_factor_expires_at && 
        now()->lessThan($user->two_factor_expires_at)) {
        
        \Log::info('🔑 VERIFY: Código VÁLIDO! Ativando 2FA...');
        
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->two_factor_enabled = true;
        $user->save();
        
        \Log::info('🔑 VERIFY: two_factor_enabled agora é: ' . $user->two_factor_enabled);
        
        return true;
    }
    
    \Log::info('🔑 VERIFY: Código INVÁLIDO ou EXPIRADO');
    return false;
}
    /**
     * Verificar se o usuário tem 2FA ativado
     */
    public static function isEnabled(Model $user): bool
    {
        return $user->two_factor_enabled;
    }

    /**
     * Desabilitar 2FA
     */
    public static function disable(Model $user): void
    {
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->two_factor_enabled = false;
        $user->save();
    }

    /**
     * Verificar se o código expirou
     */
    public static function isExpired(Model $user): bool
    {
        if (!$user->two_factor_expires_at) {
            return true;
        }
        
        return Carbon::now()->greaterThan($user->two_factor_expires_at);
    }

    /**
     * Reenviar código
     */
    public static function resendCode(Model $user): bool
    {
        // Limpar código antigo
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();
        
        // Enviar novo código
        return self::sendCode($user);
    }
}
