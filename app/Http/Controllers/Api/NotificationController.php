<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // Placeholder - implementar depois
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    public function markAsRead($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Notificação marcada como lida'
        ]);
    }

    public function markAllAsRead()
    {
        return response()->json([
            'success' => true,
            'message' => 'Todas notificações marcadas como lidas'
        ]);
    }
}