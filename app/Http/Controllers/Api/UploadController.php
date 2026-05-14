<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('uploads', 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
            'path' => $path
        ]);
    }

    public function file(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
            'path' => $path
        ]);
    }
}