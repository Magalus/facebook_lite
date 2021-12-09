<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;

class AuthController extends Controller
{

    public function register(Request $request) {

        $rules = [
            "name"  =>  "required|string|between:2,100",
            "email"  =>  "required|string|email|unique:users",
            "password"  =>  "required|string|confirmed|min:6"
        ];

        $customMessages = [
            'name.required' => 'Le champ nom est obligatoire.',
            'name.between' => 'Le nom doit faire au moins 2 caractères.',
            'email.required' => 'Le champ email est obligatoire.',
            'email.unique' => 'Adresse mail déjà utilisée.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            "password" =>  "required|string|min:6",
        ]);

        if($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }

        $credentials = $request->only('email', 'password');

        if(!auth()->attempt($credentials)) {
            return response()->json([
                'errors' => "L'adresse mail et le mot de passe ne correspondent pas.",
                'message' => $credentials
            ]);
        }

        $request->session()->regenerate();

        return response()->json(null, 201);
    }

    public function logout(Request $request) {
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(null, 200);
	}
}