<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function menuData($role)
    {
        return (object)DB::select("SELECT a.`id`, a.`label`,a.icon,
        IF (c.id <> '', 'true', 'false') AS selected
        FROM menus a
        LEFT JOIN (
            SELECT *
            FROM user_menus b
            WHERE b.`role_id` = ?
        ) AS c ON c.menu_id = a.`id`
        WHERE a.`is_active` = ?
        ORDER BY a.index", [$role,true]);
    }
}
