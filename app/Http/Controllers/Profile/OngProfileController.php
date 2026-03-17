<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OngProfileController extends Controller
{
    /**
     * Exibir formulário de edição do perfil
     */
    public function edit()
    {
        $ong = Auth::guard('ong')->user();
        return view('profile.ong.edit', compact('ong'));
    }

    /**
     * Atualizar perfil da ONG
     */
    public function update(Request $request)
    {
        $ong = Auth::guard('ong')->user();

        $validated = $request->validate([
            'responsible_name' => 'required|string|max:255',
            'ong_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('ongs')->ignore($ong->id)
            ],
            'cnpj' => [
                'nullable',
                'string',
                'max:18',
                Rule::unique('ongs')->ignore($ong->id)
            ],
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'current_password' => 'nullable|required_with:new_password|current_password:ong',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'responsible_name.required' => 'O nome do responsável é obrigatório',
            'ong_name.required' => 'O nome da ONG é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está em uso',
            'cnpj.unique' => 'Este CNPJ já está cadastrado',
            'logo.image' => 'O arquivo deve ser uma imagem',
            'logo.max' => 'A imagem deve ter no máximo 2MB',
            'website.url' => 'Digite uma URL válida',
            'facebook.url' => 'Digite uma URL válida',
            'instagram.url' => 'Digite uma URL válida',
            'twitter.url' => 'Digite uma URL válida',
            'current_password.required_with' => 'A senha atual é obrigatória para alterar a senha',
            'current_password.current_password' => 'A senha atual está incorreta',
            'new_password.min' => 'A nova senha deve ter no mínimo 8 caracteres',
            'new_password.confirmed' => 'A confirmação da nova senha não coincide',
        ]);

        // Atualizar logo se enviada
        if ($request->hasFile('logo')) {
            // Remover logo antiga se existir
            if ($ong->logo) {
                Storage::disk('public')->delete($ong->logo);
            }
            
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Organizar redes sociais em array JSON
        $socialMedia = [];
        if ($request->filled('facebook')) $socialMedia['facebook'] = $request->facebook;
        if ($request->filled('instagram')) $socialMedia['instagram'] = $request->instagram;
        if ($request->filled('twitter')) $socialMedia['twitter'] = $request->twitter;
        
        $validated['social_media'] = !empty($socialMedia) ? json_encode($socialMedia) : null;

        // Atualizar senha se fornecida
        if ($request->filled('new_password')) {
            $validated['password'] = Hash::make($request->new_password);
        }

        // Remover campos que não estão na tabela
        unset($validated['current_password']);
        unset($validated['new_password']);
        unset($validated['new_password_confirmation']);
        unset($validated['facebook']);
        unset($validated['instagram']);
        unset($validated['twitter']);

        // Atualizar ONG
        $ong->update($validated);

        return redirect()->route('ong.profile.edit')
            ->with('success', 'Perfil da ONG atualizado com sucesso!');
    }

    /**
     * Excluir conta da ONG
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password:ong',
        ], [
            'password.required' => 'A senha é obrigatória para excluir a conta',
            'password.current_password' => 'A senha está incorreta',
        ]);

        $ong = Auth::guard('ong')->user();

        // Remover logo se existir
        if ($ong->logo) {
            Storage::disk('public')->delete($ong->logo);
        }

        // Remover todos os posts da ONG (e suas imagens)
        foreach ($ong->posts as $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
        }

        Auth::guard('ong')->logout();
        $ong->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Conta da ONG excluída com sucesso!');
    }

    /**
     * Upload de logo via AJAX
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:2048',
        ]);

        $ong = Auth::guard('ong')->user();

        // Remover logo antiga se existir
        if ($ong->logo) {
            Storage::disk('public')->delete($ong->logo);
        }

        $path = $request->file('logo')->store('logos', 'public');
        $ong->update(['logo' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Logo atualizada com sucesso!',
            'logo_url' => asset('storage/' . $path)
        ]);
    }

    /**
     * Remover logo
     */
    public function removeLogo()
    {
        $ong = Auth::guard('ong')->user();

        if ($ong->logo) {
            Storage::disk('public')->delete($ong->logo);
            $ong->update(['logo' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo removida com sucesso!'
        ]);
    }

    /**
     * Estatísticas detalhadas da ONG
     */
    public function statistics()
    {
        $ong = Auth::guard('ong')->user();
        
        $statistics = [
            'total_posts' => $ong->posts()->count(),
            'total_views' => $ong->posts()->sum('views'),
            'total_comments' => $this->getTotalComments($ong),
            'total_likes' => $this->getTotalLikes($ong),
            'posts_per_month' => $this->getPostsPerMonth($ong),
            'most_commented_posts' => $this->getMostCommentedPosts($ong),
            'most_liked_posts' => $this->getMostLikedPosts($ong),
        ];

        return view('ong.statistics', compact('statistics'));
    }

    /**
     * Métodos privados para estatísticas
     */
    private function getTotalComments($ong)
    {
        $total = 0;
        foreach ($ong->posts as $post) {
            $total += $post->comments()->count();
        }
        return $total;
    }

    private function getTotalLikes($ong)
    {
        $total = 0;
        foreach ($ong->posts as $post) {
            $total += $post->likes()->count();
        }
        return $total;
    }

    private function getPostsPerMonth($ong)
    {
        return $ong->posts()
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    private function getMostCommentedPosts($ong)
    {
        return $ong->posts()
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();
    }

    private function getMostLikedPosts($ong)
    {
        return $ong->posts()
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(5)
            ->get();
    }
}