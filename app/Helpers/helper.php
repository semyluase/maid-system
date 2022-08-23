<?php

use App\Models\Country;
use App\Models\Enumeration;
use Illuminate\Support\Facades\Http;

function columnOrder(array $column, $columnOrder)
{
    return $column[$columnOrder];
}

function columnToID($model, $column, $value)
{
    $query = '';
    switch ($model) {
        case 'enumeration':
            $query = Enumeration::where($column, $value)
                ->where('is_active', true)
                ->first();
            break;

        case 'country':
            $query = Country::where($column, $value)
                ->where('is_active', true)
                ->first();
            break;
    }

    return $query;
}

function getAPI($uri, $query = '')
{
    $response = Http::get($uri);

    if ($query != '') {
        $response = Http::get($uri, $query);
    }

    if ($response->status() == 200) {
        return $response->object();
    } else {
        return [];
    }
}
