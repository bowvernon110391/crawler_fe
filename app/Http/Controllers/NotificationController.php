<?php

namespace App\Http\Controllers;

use App\Models\SSO\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    // index to get notifications for an active user
    public function index() {
        // for now, just return it
        $notifications = User::find(2)->notifications()->unread()->cursorPaginate();
        return Response()->json($notifications);
    }
}
