<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        if (auth()->user()->role->id == 1) {
            Notification::where('to_role', 1)
                ->where('is_readed', false)
                ->update([
                    'is_readed' =>  true,
                ]);
            return view('notification.index', [
                'title' =>  'Notification',
                'pageTitle' =>  'Notification',
                'js'    =>  ['']
            ]);
        }

        if (auth()->user()->role->id == 2) {
            Notification::where('to_user', auth()->user()->id)
                ->where('is_readed', false)
                ->update([
                    'is_readed' =>  true,
                ]);

            return view('notification.userIndex', [
                'title' =>  'Notification',
                'pageTitle' =>  'Notification',
                'js'    =>  ['']
            ]);
        }
    }
}
