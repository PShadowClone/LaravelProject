<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class APIController extends Controller
{
    //


    public function index(Request $request )
    {
     //   Session::push("key", "amrFromNewAPI");


        $userInfo = json_decode($request->input('userInfo'), true);

       $result = Auth::attempt(['mobile'=>$userInfo['phoneNumber'] , 'password'=>$userInfo['password']])->get();
        if($result)
        {
          return response()->json(['user_token'=>csrf_token()]);
        }
        return null;
      //  Storage::disk('local')->put('file.txt',$result);

    }

    public function test()
    {
        Session::push("key", "amrFromAPI");
        echo "Amr";

        //var_dump($request);
       // return json_encode("Amr");
        // return json_encode('yes');
    }

    public function testForAPI()
    {

       //

        // asset('storage','test.txt');
        var_dump(Session::get("key"));
    }
}
