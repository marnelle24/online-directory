<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $userdata = $request->all();

        $validator = Validator::make($userdata, [
            'firstname'     => 'required',
            'lastname'      => 'required',
            'phoneNum'      => 'required',
            'email'         => 'required|email',
            'password'      => 'required|min:4',
            'confPassword'  => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if(!is_null( User::where('email', $userdata['email'])->first())) {
            return response()->json(['emailExist' => 'Email Address is already exists.']);
        } 
        else {
            $user = new User;
            $user->firstname = $userdata['firstname'];
            $user->lastname = $userdata['lastname'];
            $user->phoneNum = $userdata['phoneNum'];
            $user->email = $userdata['email'];
            $user->password = Hash::make($userdata['password']);
            $user->save();
            return response()->json(["success" => true], 200);

        }

    }
}
