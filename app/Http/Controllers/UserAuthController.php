<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password'=>'required'

        ]);
         /** @var User $user */
        $user = User::where('email',$request->email)->first();
        // $locale = $request ->header('x-language');
        // app()->setlocale($locale);

        if(!$user){
            return response()->json(['message'=>trans('login.User_Does_Not_Exist',['value'=>$request->email])],Response::HTTP_BAD_REQUEST);
        }

        //dd(Hash::check($request->password, $user->password)); if($request->password !== $user->password) 
        if(Hash::check($request->password, $user->password) === false){
            return response()->json(['message'=> __('login.Invalid_Credentials')],Response::HTTP_BAD_REQUEST);

        }
        return response()->json([
            'token'=>$user->createToken('api')->plainTextToken,
            'data'=>$user]);

    }
}
