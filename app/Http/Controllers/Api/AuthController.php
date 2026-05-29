<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\Ong;
use App\Services\TwoFactorService;
use App\Jobs\SendTwoFactorCodeJob;

class AuthController extends Controller
{
    /**
     * Registrar um novo usuário comum
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:regular_users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'nullable|string|max:14|unique:regular_users',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|string|max:255',  
        ]);

        $user = RegularUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'cpf' => $validated['cpf'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'avatar' => $validated['avatar'] ?? null,
        ]);

        SendWelcomeEmailJob::dispatch($user, 'regular');

        // Gera token para o usuário (se estiver usando Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Usuário cadastrado com sucesso!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token
        ], 201);
    }
    /**
 * Registrar uma nova ONG
 */
public function registerOng(Request $request)
{
    $validated = $request->validate([
        'responsible_name' => 'required|string|max:255',
        'ong_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:ongs',
        'password' => 'required|string|min:8|confirmed',
        'cnpj' => 'nullable|string|max:18|unique:ongs',
        'description' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'logo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('logo')) {
        $path = $request->file('logo')->store('logos', 'public');
        $validated['logo'] = $path;
    }

    $validated['password'] = Hash::make($validated['password']);

    $ong = Ong::create($validated);

    // Disparar e-mail de boas-vindas
    SendWelcomeEmailJob::dispatch($ong, 'ong');

    // Gera token para a ONG
    $token = $ong->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'ONG cadastrada com sucesso!',
        'user' => [
            'id' => $ong->id,
            'name' => $ong->ong_name,
            'email' => $ong->email,
            'type' => 'ong'
        ],
        'token' => $token
    ], 201);
}

    /**
     * Login de usuário comum
     */
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Tenta encontrar em regular_users
    $user = RegularUser::where('email', $request->email)->first();

    // Se não encontrar, tenta em ongs
    if (!$user) {
        $user = Ong::where('email', $request->email)->first();
        
        // Para ONGs, não tem 2FA, login normal
        if ($user && Hash::check($request->password, $user->password)) {
            $user->tokens()->delete();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login da ONG realizado com sucesso!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->ong_name,
                    'email' => $user->email,
                    'type' => 'ong'
                ],
                'token' => $token
            ]);
        }
        
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas.'],
        ]);
    }

    // Verificar senha do usuário comum
    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas.'],
        ]);
    }

    // 🔐 VERIFICAÇÃO DE 2FA
    // Se 2FA já estiver ativado, enviar código
    if (TwoFactorService::isEnabled($user)) {
        TwoFactorService::sendCode($user);
        
        return response()->json([
            'success' => true,
            'message' => 'Código de verificação enviado para seu e-mail.',
            'two_factor_required' => true,
            'requires_2fa' => true,
            'requires_two_factor' => true,
            'user_id' => $user->id,
            'email' => $user->email
        ]);
    }

    // Se 2FA não estiver ativado, login normal
    $user->tokens()->delete();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login realizado com sucesso!',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => 'regular',
            'two_factor_enabled' => false
        ],
        'token' => $token
    ]);
}

    /**
     * Verificar o codigo 2FA antes de liberar o token da API.
     */
    public function verifyTwoFactor(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required_without:two_factor_code|string|size:6',
            'two_factor_code' => 'required_without:code|string|size:6',
            'user_id' => 'nullable|integer',
            'email' => 'nullable|email',
            'type' => 'nullable|in:regular,ong',
        ]);

        $code = $validated['code'] ?? $validated['two_factor_code'];

        if (empty($validated['user_id']) && empty($validated['email'])) {
            return response()->json([
                'success' => false,
                'message' => 'Informe o usuario para verificar o codigo.',
            ], 422);
        }

        $isOng = ($validated['type'] ?? null) === 'ong' || $request->is('api/ong/*');
        $model = $isOng ? Ong::class : RegularUser::class;

        $user = !empty($validated['user_id'])
            ? $model::find($validated['user_id'])
            : $model::where('email', $validated['email'])->first();

        if (!$user || !TwoFactorService::verifyCode($user, $code)) {
            return response()->json([
                'success' => false,
                'message' => 'Codigo invalido ou expirado.',
            ], 422);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso!',
            'user' => [
                'id' => $user->id,
                'name' => $isOng ? $user->ong_name : $user->name,
                'email' => $user->email,
                'type' => $isOng ? 'ong' : 'regular',
                'two_factor_enabled' => (bool) $user->two_factor_enabled,
            ],
            'token' => $token,
        ]);
    }

    /**
     * Reenviar codigo 2FA durante o login da API.
     */
    public function resendTwoFactorCode(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|integer',
            'email' => 'nullable|email',
            'type' => 'nullable|in:regular,ong',
        ]);

        if (empty($validated['user_id']) && empty($validated['email'])) {
            return response()->json([
                'success' => false,
                'message' => 'Informe o usuario para reenviar o codigo.',
            ], 422);
        }

        $isOng = ($validated['type'] ?? null) === 'ong' || $request->is('api/ong/*');
        $model = $isOng ? Ong::class : RegularUser::class;

        $user = !empty($validated['user_id'])
            ? $model::find($validated['user_id'])
            : $model::where('email', $validated['email'])->first();

        if (!$user || !TwoFactorService::isEnabled($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Nao foi possivel reenviar o codigo.',
            ], 422);
        }

        TwoFactorService::resendCode($user);

        return response()->json([
            'success' => true,
            'message' => 'Novo codigo enviado para seu e-mail.',
        ]);
    }

    public function enableTwoFactor(Request $request)
    {
        $user = $request->user();

        if (!($user instanceof RegularUser) && !($user instanceof Ong)) {
            return response()->json([
                'success' => false,
                'message' => '2FA disponivel apenas para usuarios comuns e ONGs.',
            ], 422);
        }

        TwoFactorService::sendCode($user);

        return response()->json([
            'success' => true,
            'message' => 'Codigo de confirmacao enviado para seu e-mail.',
        ]);
    }

    public function confirmTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = $request->user();

        if ((!($user instanceof RegularUser) && !($user instanceof Ong)) || !TwoFactorService::verifyCode($user, $request->code)) {
            return response()->json([
                'success' => false,
                'message' => 'Codigo invalido ou expirado.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => '2FA ativado com sucesso.',
        ]);
    }

    public function disableTwoFactor(Request $request)
    {
        $user = $request->user();

        if (!($user instanceof RegularUser) && !($user instanceof Ong)) {
            return response()->json([
                'success' => false,
                'message' => '2FA disponivel apenas para usuarios comuns e ONGs.',
            ], 422);
        }

        TwoFactorService::disable($user);

        return response()->json([
            'success' => true,
            'message' => '2FA desativado com sucesso.',
        ]);
    }

    // Em AuthController
public function loginOng(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $ong = Ong::where('email', $request->email)->first();

    if (!$ong || !Hash::check($request->password, $ong->password)) {
        throw ValidationException::withMessages([
            'email' => ['Credenciais inválidas.'],
        ]);
    }

    if (TwoFactorService::isEnabled($ong)) {
        TwoFactorService::sendCode($ong);

        return response()->json([
            'success' => true,
            'message' => 'Codigo de verificacao enviado para o e-mail da ONG.',
            'two_factor_required' => true,
            'requires_2fa' => true,
            'requires_two_factor' => true,
            'user_id' => $ong->id,
            'email' => $ong->email,
            'type' => 'ong',
        ]);
    }

    $ong->tokens()->delete();
    $token = $ong->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login da ONG realizado com sucesso!',
        'user' => [
            'id' => $ong->id,
            'name' => $ong->ong_name,
            'email' => $ong->email,
            'type' => 'ong'
        ],
        'token' => $token
    ]);
}

    /**
     * Logout do usuário
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso!'
        ]);
    }

    /**
     * Obter dados do usuário autenticado
     */
    public function me(Request $request)
{
    try {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);
        }
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'cpf' => $user->cpf,
                'phone' => $user->phone,
                'avatar' => $user->avatar,
                'created_at' => $user->created_at
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao carregar usuário: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Atualizar dados do usuário
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|string|max:255',
            'current_password' => 'required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }
        if (isset($validated['avatar'])) {
            $user->avatar = $validated['avatar'];
        }
        if (isset($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Dados atualizados com sucesso!',
            'user' => $user
        ]);
    }

    /**
     * Deletar conta do usuário
     */
    public function destroy(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Conta deletada com sucesso!'
        ]);
    }
}
