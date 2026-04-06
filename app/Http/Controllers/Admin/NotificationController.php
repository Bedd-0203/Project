<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Report::with('user')
            ->latest()
            ->paginate(20);

        $pendingCount = Report::where('status', 'pending')->count();

        return view('admin.notifications.index', compact('notifications', 'pendingCount'));
    }
}