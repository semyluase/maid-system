<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Master\Maid\Maid;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role->id == 1 || auth()->user()->role->id == 3) {
            $maidMalaysia = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->latest()
                ->country("MY")
                ->get())->count();

            $maidSingapore = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->latest()
                ->country("SG")
                ->get())->count();

            $maidHongkong = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->latest()
                ->country("HK")
                ->get())->count();

            $maidTaiwan = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->latest()
                ->country("TW")
                ->get())->count();

            $maidBrunei = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->latest()
                ->country("BN")
                ->get())->count();

            $maidAllFormat = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->latest()
                ->country("ALL")
                ->get())->count();

            $maidBookmark = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_bookmark', true)
                ->latest()
                ->get())->count();

            $maidUploaded = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_uploaded', true)
                ->latest()
                ->get())->count();

            $maidTaken = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', true)
                ->latest()
                ->get())->count();

            $announcement = Announcement::latest()
                ->first();

            $role = Role::where('slug', 'agency')
                ->first();

            $agency = User::where('role_id', $role->id)
                ->limit(5)
                ->latest()
                ->get();

            return view('dashboard.index', [
                'title' =>  'Dashboard',
                'pageTitle' =>  'Dashboard',
                'totalMalaysia' =>  $maidMalaysia,
                'totalSingapore' =>  $maidSingapore,
                'totalTaiwan' =>  $maidTaiwan,
                'totalBrunei' =>  $maidBrunei,
                'totalHongkong' =>  $maidHongkong,
                'totalAllFormat' =>  $maidAllFormat,
                'totalBookmark' =>  $maidBookmark,
                'totalUploaded' =>  $maidUploaded,
                'totalTaken' =>  $maidTaken,
                'announcement' =>  $announcement,
                'agencies'  =>  $agency,
                'js'    =>  ['assets/js/apps/dashboard.js']
            ]);
        }

        $announcement = Announcement::latest()
            ->first();

        $maidBookmark = collect(Maid::where('is_active', true)
            ->where('is_trash', false)
            ->where('is_blacklist', false)
            ->where('is_delete', false)
            ->where('is_bookmark', true)
            ->where('user_bookmark', auth()->user()->id)
            ->latest()
            ->get())->count();

        $maidUploaded = collect(Maid::where('is_active', true)
            ->where('is_trash', false)
            ->where('is_blacklist', false)
            ->where('is_delete', false)
            ->where('is_uploaded', true)
            ->where('user_uploaded', auth()->user()->id)
            ->latest()
            ->get())->count();

        $maidTaken = collect(Maid::where('is_active', true)
            ->where('is_trash', false)
            ->where('is_blacklist', false)
            ->where('is_delete', false)
            ->where('is_taken', true)
            ->where('user_taken', auth()->user()->id)
            ->latest()
            ->get())->count();

        return view('dashboard.userIndex', [
            'title' =>  'Dashboard',
            'pageTitle' =>  'Dashboard',
            'totalBookmark' =>  $maidBookmark,
            'totalUploaded' =>  $maidUploaded,
            'totalTaken' =>  $maidTaken,
            'announcement' =>  $announcement,
            'js'    =>  ['assets/js/apps/dashboard.js']
        ]);
    }
}
