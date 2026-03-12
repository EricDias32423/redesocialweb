<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * ===========================================
     * MÉTODOS PARA WEB (Views Blade)
     * ===========================================
     */

    /**
     * Exibir formulário de edição do perfil (Web)
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Atualizar perfil (Web)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'ong_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048', // 2MB max
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'O nome do responsável é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está em uso',
            'ong_name.required' => 'O nome da ONG é obrigatório',
            'logo.image' => 'O arquivo deve ser uma imagem',
            'logo.max' => 'A imagem deve ter no máximo 2MB',
            'current_password.required_with' => 'A senha atual é obrigatória para alterar a senha',
            'current_password.current_password' => 'A senha atual está incorreta',
            'new_password.min' => 'A nova senha deve ter no mínimo 8 caracteres',
            'new_password.confirmed' => 'A confirmação da nova senha não coincide',
        ]);

        // Atualizar logo se enviada
        if ($request->hasFile('logo')) {
            // Remover logo antiga se existir
            if ($user->logo) {
                Storage::disk('public')->delete($user->logo);
            }
            
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Atualizar senha se fornecida
        if ($request->filled('new_password')) {
            $validated['password'] = Hash::make($request->new_password);
        }

        // Remover campos que não estão na tabela
        unset($validated['current_password']);
        unset($validated['new_password']);
        unset($validated['new_password_confirmation']);

        // Atualizar usuário
        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Excluir conta do usuário (Web)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ], [
            'password.required' => 'A senha é obrigatória para excluir a conta',
            'password.current_password' => 'A senha está incorreta',
        ]);

        $user = Auth::user();

        // Remover logo se existir
        if ($user->logo) {
            Storage::disk('public')->delete($user->logo);
        }

        // Remover todos os posts do usuário (e suas imagens)
        foreach ($user->posts as $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sua conta foi excluída com sucesso!');
    }

    /**
     * ===========================================
     * MÉTODOS PARA API (JSON)
     * ===========================================
     */

    /**
     * Exibir dados do perfil (API)
     */
    public function show()
    {
        $user = Auth::user()->load('posts');
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Atualizar perfil (API)
     */
    public function updateApi(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'ong_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Verificar senha atual se estiver tentando alterar a senha
        if ($request->has('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'A senha atual está incorreta'
                ], 422);
            }
            $validated['password'] = Hash::make($request->new_password);
        }

        // Atualizar logo se enviada
        if ($request->hasFile('logo')) {
            // Remover logo antiga se existir
            if ($user->logo) {
                Storage::disk('public')->delete($user->logo);
            }
            
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Remover campos que não estão na tabela
        unset($validated['current_password']);
        unset($validated['new_password']);
        unset($validated['new_password_confirmation']);

        // Atualizar usuário
        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Perfil atualizado com sucesso!',
            'data' => $user->fresh()
        ]);
    }

    /**
     * Excluir conta (API)
     */
    public function destroyApi(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        // Verificar senha
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Senha incorreta'
            ], 422);
        }

        // Remover logo se existir
        if ($user->logo) {
            Storage::disk('public')->delete($user->logo);
        }

        // Remover todos os posts do usuário (e suas imagens)
        foreach ($user->posts as $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
        }

        // Remover tokens de API
        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Conta excluída com sucesso!'
        ]);
    }

    /**
     * Upload de logo via API (endpoint específico)
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Remover logo antiga se existir
        if ($user->logo) {
            Storage::disk('public')->delete($user->logo);
        }

        $path = $request->file('logo')->store('logos', 'public');
        $user->update(['logo' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Logo atualizada com sucesso!',
            'logo_url' => asset('storage/' . $path)
        ]);
    }

    /**
     * Remover logo (API)
     */
    public function removeLogo()
    {
        $user = Auth::user();

        if ($user->logo) {
            Storage::disk('public')->delete($user->logo);
            $user->update(['logo' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo removida com sucesso!'
        ]);
    }

    /**
     * Estatísticas do perfil (API)
     */
    public function stats()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_posts' => $user->posts()->count(),
                'total_views' => $user->posts()->sum('views'), // Se tiver campo views
                'member_since' => $user->created_at->format('d/m/Y'),
                'last_update' => $user->updated_at->format('d/m/Y H:i'),
                'posts_per_month' => $user->posts()
                    ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) total')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get()
            ]
        ]);
    }
}