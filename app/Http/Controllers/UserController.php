<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('name','ASC')->get();
        return response()->json([
            'message' => count($users). ' users found',
            'data' => $users,
            'status' => true,
        ], 200);
    }

    // find specific user using this function
    public function show($id){
      
        $user = User::find($id);

        if($user != null){
            return response()->json([
                'message' => $user->name.' User found',
                'data' => $user,
                'status' => true,
            ], 200);
        }else{
            return response()->json([
                'message' => 'Record not found',
                'status' => true,
                'data' => [],
            ], 200);

        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'Please fix the errors',
                'errors' => $validator->errors(),
                'status' => false,
            ], 200);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'User added successfully',
            'status' => true,
            'data' => $user,
        ], 200);
    }

}
