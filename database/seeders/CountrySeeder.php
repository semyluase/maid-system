<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'code'  =>  'ID',
            'name'  =>  'Indonesia',
            'slug'  =>  'indonesia',
            'user_created'  =>  1,
        ]);

        Country::create([
            'code'  =>  'HK',
            'name'  =>  'Hongkong',
            'slug'  =>  'hongkong',
            'user_created'  =>  1,
        ]);

        Country::create([
            'code'  =>  'SG',
            'name'  =>  'Singapore',
            'slug'  =>  'singapore',
            'user_created'  =>  1,
        ]);

        Country::create([
            'code'  =>  'TW',
            'name'  =>  'Republic of China (Taiwan)',
            'slug'  =>  'republic-of-china-taiwan',
            'user_created'  =>  1,
        ]);

        Country::create([
            'code'  =>  'MY',
            'name'  =>  'Malaysia',
            'slug'  =>  'malaysia',
            'user_created'  =>  1,
        ]);

        Country::create([
            'code'  =>  'BN',
            'name'  =>  'Brunei Darussalam',
            'slug'  =>  'brunei-darussalam',
            'user_created'  =>  1,
        ]);

        Country::create([
            'code'  =>  'ALL',
            'name'  =>  'Formal',
            'slug'  =>  'formal',
            'user_created'  =>  1,
        ]);
    }
}
