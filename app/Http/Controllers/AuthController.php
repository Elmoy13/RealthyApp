<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->json()->all();

        $itExistsUserName=User::where('email',$data['email'])->first();

        if ($itExistsUserName==null) {
            $user = User::create(
                [
                    'name'=>$data['name'],
                    'email'=>$data['email'],
                    'password'=>Hash::make($data['password'])

                ]
            );

            $token = $user->createToken('web')->plainTextToken;


                return response()->json([
                    'data'=>$user,
                    'token'=> $token

                ],200);
        } else {
               return response()->json([
                'data'=>'User already exists!',
                'status'=> false
            ],200);
       }

   }
   public function login(Request $request){

    if(!Auth::attempt($request->only('email','password'))){
    return response()->json([
        'message'=> 'Correo o contraseña incorrectos',
        'status'=> false
    ],400);
}
     $user = User::where('email',$request['email'])->firstOrFail();
     $token = $user->createToken('web')->plainTextToken;
     return response()->json([

        'data'=> $user,
        'token'=>$token
     ]);

   }
   public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();

    return response()->json([

        'status'=> true,
    ]);

   }
   public function updateRandomPassword($email)
    {
        $user = User::where('email', $email)->firstorfail();


        if (!$user)
        {
            return response()->json(['message' => 'El usuario no esta registrado en la base de datos'], 200);
        }
        else
        {

        $nuevaContraseña = Str::random(6);


        $user->password = Hash::make($nuevaContraseña);

        $user->save();


        return response()->json([
            'new_password' => $nuevaContraseña,
            'message' => 'La contraseña a sido actualizada correctamente',
        ], 200);
        }


    }
}
