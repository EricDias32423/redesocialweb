<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        
        $ongs = Ong::where('ong_name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->limit(5)
            ->get();

        $posts = Post::where('title', 'like', "%{$search}%")
            ->orWhere('content', 'like', "%{$search}%")
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'ongs' => $ongs,
                'posts' => $posts
            ]
        ]);
    }

    public function ongs(Request $request)
    {
        $search = $request->get('q');
        
        $ongs = Ong::where('ong_name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $ongs
        ]);
    }

    public function posts(Request $request)
    {
        $search = $request->get('q');
        
        $posts = Post::where('title', 'like', "%{$search}%")
            ->orWhere('content', 'like', "%{$search}%")
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
}