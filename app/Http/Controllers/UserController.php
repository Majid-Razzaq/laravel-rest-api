<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('name','ASC')->get();
        return response()->json([
            'message' => count($users). ' users found',
            'data' => $users,
            'status' => true,
        ]);
    }
}
