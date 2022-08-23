<?php

namespace Database\Seeders;

use App\Models\UserMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserMenu::create([
            'menu_id'   =>  1,
            'role_id'   =>  1,
        ]);

        UserMenu::create([
            'menu_id'   =>  2,
            'role_id'   =>  1,
        ]);

        UserMenu::create([
            'menu_id'   =>  3,
            'role_id'   =>  1,
        ]);

        UserMenu::create([
            'menu_id'   =>  4,
            'role_id'   =>  1,
        ]);

        UserMenu::create([
            'menu_id'   =>  5,
            'role_id'   =>  1,
        ]);

        UserMenu::create([
            'menu_id'   =>  6,
            'role_id'   =>  1,
        ]);
    }
}
