<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function check()
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications;
        
        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->data['message'],
                ];
            }),
        ]);
    }
    
    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

public function deleteReadNotifications()
{
    $user = Auth::user();
    $user->readNotifications()->delete();

    return back()->with('success', 'Read notifications deleted successfully.');
}
}