<?php

namespace App\Http\Controllers\Regular;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class OngController extends Controller
{

/**
 * Support an ONG.
 */
public function support(Ong $ong)
{
    if (!Auth::guard('regular')->check()) {
        return redirect()->route('regular.login')
            ->with('error', 'Faça login para apoiar ONGs.');
    }
    
    $user = Auth::guard('regular')->user();
    
    // Verifica se já não apoia (evita duplicatas)
    if (!$user->supportedOngs()->where('ong_id', $ong->id)->exists()) {
        $user->supportedOngs()->attach($ong->id);
    }
    
    return redirect()->route('regular.ongs.show', $ong)
        ->with('success', 'Agora você está apoiando esta ONG!');
}

/**
 * Unsupport an ONG.
 */
public function unsupport(Ong $ong)
{
    if (!Auth::guard('regular')->check()) {
        return redirect()->route('regular.login');
    }
    
    $user = Auth::guard('regular')->user();
    
    // Remove o apoio
    $user->supportedOngs()->detach($ong->id);
    
    return redirect()->route('regular.ongs.show', $ong)
        ->with('success', 'Você deixou de apoiar esta ONG.');
}
    /**
     * Display a listing of all ONGs.
     */
    public function index(Request $request)
    {
        $query = Ong::query();
        
        // Busca por nome ou descrição
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ong_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filtrar por categoria (se implementado)
        if ($request->has('category') && $request->category != '') {
            // Implementar filtro por categoria se tiver esse campo
        }
        
        $ongs = $query->withCount('posts')->latest()->paginate(12);
        
        return view('regular.ongs.index', compact('ongs'));
    }

    /**
     * Display the specified ONG.
     */
    public function show(Ong $ong)
{
    $ong->loadCount('posts');
    
    // Verificar se o usuário atual apoia esta ONG
    $userSupported = false;
    if (Auth::guard('regular')->check()) {
        $user = Auth::guard('regular')->user();
        $userSupported = $user->supportedOngs()
            ->where('ong_id', $ong->id)
            ->exists();
    }
    
    // Estatísticas da ONG
    $stats = [
        'total_posts' => $ong->posts()->count(),
        'total_followers' => $ong->supporters()->count(), // Conta quantos apoiadores
        'total_projects' => 0, // Implementar depois se necessário
    ];
    
    // Posts da ONG
    $posts = $ong->posts()->withCount('comments')->latest()->paginate(10);
    
    // Apoiadores recentes (últimos 5)
    $recentSupporters = $ong->supporters()
        ->latest()
        ->take(5)
        ->get();
    
    return view('regular.ongs.show', compact('ong', 'stats', 'posts', 'userSupported', 'recentSupporters'));
}

    /**
     * Support an ONG.
     */
    

    /**
     * Get ONGs that the user supports.
     */
    public function myOngs()
    {
        if (!Auth::guard('regular')->check()) {
            return redirect()->route('regular.login');
        }
        
        // Implementar lista de ONGs apoiadas pelo usuário
        $ongs = collect([]); // Substituir por consulta real
        
        return view('regular.my-ongs', compact('ongs'));
    }
}