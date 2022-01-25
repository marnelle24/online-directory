<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'firstname'     => 'required|max:55',
            'lastname'      => 'required|max:55',
            'phoneNum'      => 'required|max:20',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:8',
            'confPassword'  => 'required|same:password'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        event(new Registered($user));

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }
}
