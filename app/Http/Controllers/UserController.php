<?php

namespace App\Http\Controllers;

use App\Models\Image;
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

    public function update(Request $request, $id){
         
        $user = User::find($id);
        if($user == null){
            return response()->json([
                'message' => 'User not found',
                'status' => false,
            ], 200);
        }
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
         ];

         $validator = Validator::make($request->all(),$rules);
         if($validator->fails()){
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors(),
            ], 200);
         }

         $user->name = $request->name;
         $user->email = $request->email;
         $user->password = $request->password;
         $user->save();

         return response()->json([
            'message' => 'User updated successfully',
            'status' => true,
            'data' => $user,
         ], 200);

    }


    public function destroy($id){
        $user = User::find($id);
        if($user == null){
            return response()->json([
                'message' => 'User not found',
                'status' => false,
            ], 200);
        }
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'status' => true,
        ], 200);
    }

    public function upload(Request $request){
        $validator = Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg,jpeg,gif',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $img = $request->image;
        $getExt = $img->getClientOriginalExtension();
        $imgName = time().'.'.$getExt;
        $img->move(public_path().'/uploads', $imgName);

        $image = new Image;
        $image->image = $imgName;
        $image->save();

        return response()->json([
            'status' => true,
            'path' => asset('/uploads/'.$imgName),
            'message' => 'image uploaded successfully',
            'data' => $image,
        ]);


    }

}

