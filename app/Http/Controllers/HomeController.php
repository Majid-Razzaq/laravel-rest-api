<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $array = [
            [
                'name' => 'Abdul Majid',
                'email' => 'majid@gmail.com'
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com'
            ]
        ];

        return response()->json([
            'message' => '2 User found',
            'data' => $array,
            'status' => true,
        ], 200);
    }
}
