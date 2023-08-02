<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenuTree(Request $request)
    {
        $dataMenu = Menu::menuData($request->role);

        $response = [];

        if ($dataMenu) {
            foreach ($dataMenu as $row => $val) {
                $response[$row] = [
                    'id' => $val->id,
                    'icon'  =>  $val->icon,
					'text' => $val->label,
                ];

                if ($val->selected == 'true') {
					$response[$row]['state'] = [
						'selected' => true,
                        'opened'    =>  true
					];
				}
            }
        }

        return response()->json($response);
    }
}
