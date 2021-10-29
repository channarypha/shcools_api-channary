<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',

        ]);
        //create Users
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();
        // Create Token (= is a key to log to use or access our api) similar password
        //like a key to open the door (door = api)
        $token = $user->createToken('mytoken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        //check eamil
        // catch eamil from  to
        $user = User::where('email', $request->email)->first();
        // check password
        if (!$user || !Hash::check($request->password, $user->password)){
            return response()->json(["message" => "Bad login"], 401);
        }
        
        // Create Token 

        //(= is a key to log to use or access our api) similar password
        //like a key to open the door (door = api)
        $token = $user->createToken('mytoken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
        // 1 user has 1 token
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(["message" => "User logged out !"]);
    }
   
}
