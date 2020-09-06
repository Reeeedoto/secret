<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Secret;
use Illuminate\Http\Response;

class SecretController extends Controller
{
    public function store()
    {
        $secret_key = uniqid();
        $secret = new Secret();
        $secret->secret = request()->secret;
        $secret->secret_code = request()->secret_code;
        $secret->secret_key = $secret_key;
        $secret->save();
        return response()->json($secret['secret_key'],201);
    }

    public function show($secret_key)
    {
        $secret = Secret::where('secret_key','=',$secret_key)->get();

        if (request()->secret_code == $secret['0']['secret_code'])
        {
            return response()->json($secret['0']['secret'],200);
        }
        else
        {
            return response()->json(['error' => true,'message' => 'Неверный secret_code'],404);
        }
    }
}
