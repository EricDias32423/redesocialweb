<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RegularUserProfileController extends Controller
{
    /**
     * Exibir formulário de edição do perfil
     */
    public function edit()
    {
        $user = Auth::guard('regular')->user();
        return view('profile.regular.edit', compact('user'));
    }

    /**
     * Atualizar perfil do usuário
     */
    public function update(Request $request)
    {
        $user = Auth::guard('regular')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('regular_users')->ignore($user->id)
            ],
            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('regular_users')->ignore($user->id)
            ],
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048', // 2MB max
            'current_password' => 'nullable|required_with:new_password|current_password:regular',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está em uso',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'avatar.image' => 'O arquivo deve ser uma imagem',
            'avatar.max' => 'A imagem deve ter no máximo 2MB',
            'current_password.required_with' => 'A senha atual é obrigatória para alterar a senha',
            'current_password.current_password' => 'A senha atual está incorreta',
            'new_password.min' => 'A nova senha deve ter no mínimo 8 caracteres',
            'new_password.confirmed' => 'A confirmação da nova senha não coincide',
        ]);

        // Atualizar avatar se enviado
        if ($request->hasFile('avatar')) {
            // Remover avatar antigo se existir
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
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

        return redirect()->route('regular.profile.edit')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Excluir conta do usuário
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password:regular',
        ], [
            'password.required' => 'A senha é obrigatória para excluir a conta',
            'password.current_password' => 'A senha está incorreta',
        ]);

        $user = Auth::guard('regular')->user();

        // Remover avatar se existir
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Remover comentários do usuário (se houver)
        // $user->comments()->delete();

        // Remover curtidas do usuário (se houver)
        // $user->likes()->delete();

        Auth::guard('regular')->logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sua conta foi excluída com sucesso!');
    }

    /**
     * Upload de avatar via AJAX
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = Auth::guard('regular')->user();

        // Remover avatar antigo se existir
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Avatar atualizado com sucesso!',
            'avatar_url' => asset('storage/' . $path)
        ]);
    }

    /**
     * Remover avatar
     */
    public function removeAvatar()
    {
        $user = Auth::guard('regular')->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Avatar removido com sucesso!'
        ]);
    }

    /**
     * Configurações de privacidade
     */
    public function privacySettings()
    {
        $user = Auth::guard('regular')->user();
        return view('profile.regular.privacy', compact('user'));
    }

    /**
     * Atualizar configurações de privacidade
     */
    public function updatePrivacy(Request $request)
    {
        $user = Auth::guard('regular')->user();
        
        $validated = $request->validate([
            'show_email' => 'boolean',
            'show_phone' => 'boolean',
            'show_birth_date' => 'boolean',
        ]);

        // Salvar configurações (criar campo settings JSON no model)
        $settings = array_merge($user->settings ?? [], $validated);
        $user->update(['settings' => $settings]);

        return back()->with('success', 'Configurações de privacidade atualizadas!');
    }
}