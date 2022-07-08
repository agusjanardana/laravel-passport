<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    //
    public function index(){
        return response([
            'status' => true,
            'message' => 'success'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        try{
            $user = User::where('email', $request->email)->first();

            if(!$user) return response(['status' => false, 'message' => 'User Not Found']);
            if (Hash::check($request->password, $user->password)){
                $token = $user->createToken($user->name)->accessToken;
                return response([
                    'status' => true,
                    'message' => [
                        'user' => $user,
                        'token' => $token
                    ]]);
            } else {
                return response(['status' => false, 'message' => 'wrong password']);
            }
            
        } catch(\Exception $e){
            return response(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
