<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'label' =>  'Dashboard',
            'active_value'  =>  '/',
            'url'   =>  '/',
            'icon'  =>  'fa-solid fa-gauge-high',
            'index' =>  1
        ]);

        Menu::create([
            'label' =>  'Logout',
            'active_value'  =>  '',
            'url'   =>  'javascript:;',
            'icon'  =>  'fa-solid fa-arrow-right-to-bracket',
            'index' =>  9999
        ]);

        Menu::create([
            'label' =>  'Manajemen Role Menu',
            'active_value'  =>  'management/menus*',
            'url'   =>  '/management/menus',
            'icon'  =>  'fa-solid fa-grip',
            'index' =>  9998
        ]);

        Menu::create([
            'label' =>  'Manajemen User',
            'active_value'  =>  'users*',
            'url'   =>  '/users',
            'icon'  =>  'fa-solid fa-users',
            'index' =>  9997
        ]);

        Menu::create([
            'label' =>  'Manajemen Role',
            'active_value'  =>  'master/roles*',
            'url'   =>  '/master/roles',
            'icon'  =>  'fa-solid fa-tag',
            'index' =>  9996
        ]);
    }
}
