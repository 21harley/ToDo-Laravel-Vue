<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        try{
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string',
            ]);
           
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
            ]);
    
            $token = $user->createToken('myapptoken')->accessToken;
    
            $response = [
                'user' => $user,
                'token' => $token,
                'message' => 'success',
            ];
           
            return response($response, 200);

        }catch(\Exception $e){

            return response([
                'user' => null,
                'token' => null,
                'message' => 'Error',
            ], 401);

        }
    }

    public function login(Request $request)
    {
        $BadRequest = [
            'user' => null,
            'token' => null,
            'message' => 'Bad credentials',
        ];
    
        try {
            // Validar campos
            $fields = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
    
            // Buscar el usuario por email
            $user = User::where('email', $fields['email'])->first();
    
            // Verificar credenciales
            if (!$user || !Hash::check($fields['password'], $user->password)) {
                return response($BadRequest, 401);
            }
    
            // Crear el token y devolver solo el token string
            $token = $user->createToken('myapptoken')->accessToken;
    
            // Respuesta de éxito
            $response = [
                'user' => $user,
                'token' => $token,
                'message' => 'success',
            ];
    
            return response($response, 200);
    
        } catch (\Exception $e) {
            return response($BadRequest, 401);
        }
    }
}
