<?php
/**
 * Created by PhpStorm.
 * User: Khalid
 * Date: 6/21/2016
 * Time: 5:01 AM
 */

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class userController extends BaseController
{

    public function getDashboard(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('Weblogin');
    }

    public function userSingUp(Request $request){

        $validate = Validator::make($request->all(),[
            'name' => 'required|max:120',
            'password' => 'required|min:5',
            'repassword' => 'required|same:password',
            'email' => 'required|email|unique:users',
            'reemail' => 'required|same:email',
            'address' => 'required|max:100',
            'mobile' => 'required|min:7|unique:users'
        ]);

        if($validate->fails()){
            return redirect('/')
                ->withErrors($validate)
                ->withInput();
        }


        $name = $request['name'];
        $email = $request['email'];
        $password = bcrypt($request['password']);

        $address = $request['address'];
        $phoneNumber = $request['mobile'];

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->address = $address;
        $user->mobile = $phoneNumber;

        $user->save();

        return redirect()->route('Weblogin');

    }

    public function userSignIn(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request['email'];
        $password = $request['password'];

        if(Auth::attempt(['email'=> $email, 'password' => $password])){
            session()->put('userLoginTime',Carbon::now());
            return redirect()->intended('dashboard');
        }

        else{
            return redirect()->route("Weblogin")->withErrors($validator)->withInput();
        }

    }

    public function userLogout(){
        Auth::logout();
        return redirect()->route('Weblogin');
    }

}