<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ContactPerson;
use App\Models\Master\Maid\Maid;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role->id == 1 || auth()->user()->role->id == 3) {
            $maidCount = collect(Maid::where('is_active', true)
                ->where('is_trash', false)
                ->where('is_blacklist', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->latest()
                ->get())->count();

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
                ->country("FM")
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

            $contactPersons = ContactPerson::contactSorted()->orderBy('sort')->orderBy('id')->get();

            $role = Role::where('slug', 'agency')
                ->first();

            $agency = User::where('role_id', $role->id)
                ->limit(5)
                ->latest()
                ->get();

            return view('dashboard.index', [
                'title' =>  'Dashboard',
                'pageTitle' =>  'Dashboard',
                'totalCount' =>  $maidCount,
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
                'contactPersons'    =>  $contactPersons,
                'agencies'  =>  $agency,
                'js'    =>  ['assets/js/apps/dashboard.js']
            ]);
        }

        $announcement = Announcement::latest()
            ->first();

        $contactPersons = ContactPerson::contactSorted()->orderBy('sort')->orderBy('id')->get();

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
            'contactPersons'    =>  $contactPersons,
            'js'    =>  ['assets/js/apps/dashboard.js']
        ]);
    }

    public function announcement()
    {
        $announcement = Announcement::latest()
            ->first();

        $contactPersons = ContactPerson::contactSorted()->orderBy('sort')->orderBy('id')->get();

        $path = public_path('assets/image/header/header.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataLogo = file_get_contents($path);
        $baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($dataLogo);

        $path = public_path('assets/image/symbol/whatsapp-line.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataWhatsapp = file_get_contents($path);
        $baseWhatsapp = 'data:image/' . $type . ';base64,' . base64_encode($dataWhatsapp);

        $path = public_path('assets/image/symbol/facebook-circle-fill.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataFacebook = file_get_contents($path);
        $baseFacebook = 'data:image/' . $type . ';base64,' . base64_encode($dataFacebook);

        $path = public_path('assets/image/symbol/instagram-line.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataInstagram = file_get_contents($path);
        $baseInstagram = 'data:image/' . $type . ';base64,' . base64_encode($dataInstagram);

        $path = public_path('assets/image/symbol/line-fill.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataLine = file_get_contents($path);
        $baseLine = 'data:image/' . $type . ';base64,' . base64_encode($dataLine);

        $html = view('dashboard.user.pdf.announcement', [
            'announcement'  =>  $announcement,
            'contactPersons'    =>  $contactPersons,
            'header'    =>  $baseLogo,
            'whatsapp'    =>  $baseWhatsapp,
            'facebook'    =>  $baseFacebook,
            'instagram'    =>  $baseInstagram,
            'line'    =>  $baseWhatsapp,
        ]);

        PDF::createPDF($html, 'announcement.pdf', true);
        exit;
    }
}
