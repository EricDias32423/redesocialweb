<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RegularUser;
use App\Models\Ong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Get user profile (requer token)
     */
    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }

            $userData = [
                'id' => $user->id,
                'name' => $user instanceof Ong ? $user->ong_name : $user->name,
                'email' => $user->email,
                'type' => $user instanceof Ong ? 'ong' : 'regular',
                'avatar' => $user instanceof Ong ? $user->logo : $user->avatar,
                'phone' => $user->phone,
                'created_at' => $user->created_at
            ];

            return response()->json([
                'success' => true,
                'data' => $userData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user profile (requer token)
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|url|max:255',
            ]);

            if ($user instanceof Ong) {
                if (isset($validated['name'])) {
                    $user->ong_name = $validated['name'];
                }
            } else {
                if (isset($validated['name'])) {
                    $user->name = $validated['name'];
                }
            }

            if (isset($validated['phone'])) {
                $user->phone = $validated['phone'];
            }

            if (isset($validated['avatar'])) {
                if ($user instanceof Ong) {
                    $user->logo = $validated['avatar'];
                } else {
                    $user->avatar = $validated['avatar'];
                }
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Perfil atualizado com sucesso!',
                'data' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload de avatar (requer token)
     */
    public function uploadAvatar(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }

            $request->validate([
                'avatar' => 'required|image|max:2048'
            ]);

            // Remover avatar antigo se existir
            if ($user instanceof Ong) {
                if ($user->logo) {
                    Storage::disk('public')->delete($user->logo);
                }
                $path = $request->file('avatar')->store('logos', 'public');
                $user->logo = $path;
            } else {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar atualizado com sucesso!',
                'avatar_url' => Storage::url($path)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remover avatar (requer token)
     */
    public function removeAvatar(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }

            if ($user instanceof Ong) {
                if ($user->logo) {
                    Storage::disk('public')->delete($user->logo);
                    $user->logo = null;
                }
            } else {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                    $user->avatar = null;
                }
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar removido com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover avatar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atividades do usuário (requer token)
     */
    public function activities(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado'
                ], 401);
            }

            $activities = [];

            if ($user instanceof Ong) {
                // Últimos posts da ONG
                $posts = $user->posts()->latest()->take(10)->get();
                foreach ($posts as $post) {
                    $activities[] = [
                        'type' => 'post_created',
                        'description' => "Você criou o post: {$post->title}",
                        'created_at' => $post->created_at->diffForHumans(),
                        'url' => "/posts/{$post->id}"
                    ];
                }
            } else {
                // Últimos comentários do usuário
                $comments = $user->comments()->latest()->take(10)->get();
                foreach ($comments as $comment) {
                    $activities[] = [
                        'type' => 'comment_made',
                        'description' => "Você comentou: " . substr($comment->content, 0, 50),
                        'created_at' => $comment->created_at->diffForHumans(),
                        'url' => "/posts/{$comment->post_id}"
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $activities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao carregar atividades: ' . $e->getMessage()
            ], 500);
        }
    }
}