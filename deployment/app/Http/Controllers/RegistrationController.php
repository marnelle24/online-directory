<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        return response()->json(['data' => $request->all()]);
    }
}
