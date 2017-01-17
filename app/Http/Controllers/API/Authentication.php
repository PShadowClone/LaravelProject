<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;

class Authentication extends Controller
{


    public function index(Request $request)
    {

        try {
            $userInfo = json_decode($request->input('userInfo'), true);
            $result = Auth::attempt(['mobile' => $userInfo['phoneNumber'], 'password' => $userInfo['password']]);
            //var_dump(Auth::user());
            if ($result) {
                Storage::disk('local')->put('file.txt', Auth::user()->name);
               // Auth::login(Auth::user());
                return response()->json(['status' => 200, 'user_token' => csrf_token(), 'user' => Auth::user()]);
            }

        } catch (Exception $exception) {
            return response()->json(['status' => 101, 'message' => $exception]);
        }
        return response()->json(['status' => 300, 'message' => 'Your phone number or password was incorrect.']);
    }
}
