<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatspotService;

class ChatspotController extends Controller
{
    protected $chatspot;

    public function __construct(ChatspotService $chatspot)
    {
        $this->chatspot = $chatspot;
    }

    public function handle(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'reply' => 'Kamu belum login.'
            ]);
        }

        $reply = $this->chatspot->processMessage($request->message, $user);

        return response()->json([
            'success' => true,
            'reply' => $reply,
            'user'   => [
                'id'    => $user->id,
                'name'  => $user->name,
                'role'  => $user->role,
            ],
        ]);
    }
}
