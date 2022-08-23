<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserMenu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id','id');
    }

    public static function data_menu()
    {
        $role = Auth::user()->role_id;
        return (object) DB::select("
        SELECT a.* FROM menus a
        INNER JOIN user_menus b
        ON a.id = b.menu_id
        WHERE a.is_active = true
        AND b.role_id = '$role'
        ORDER BY a.index
        ");
    }

    public static function createMenu()
    {
        $menu = '';
        $active = '';
        $dataMenu = static::data_menu();

        if ($dataMenu) {
            foreach ($dataMenu as $row) {
                $active = Request::is($row->active_value) ? 'active' : '';

                $url = $row->url === 'javascript:;' ? $row->url : url('').$row->url;

                $logout = $row->label === 'Logout' ? 'onclick="loggedOut(\''.csrf_token().'\')"' : '';

                $item = '
                <li class="sidebar-item '.$active.'">
                    <a href="'.$url.'" class="sidebar-link" '.$logout.'>
                        <i class="'.$row->icon.'"></i>
                        <span>'.$row->label.'</span>
                    </a>
                </li>
                ';

                $menu .= $item;
            }
        }

        return $menu;
    }
}
