<?php

namespace App\Http\Controllers\API;

use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AllProducts extends Controller
{
    //

    public function index(Request $request)
    {
      //  var_dump(Auth::user());
        $shopId = $request->input('userId');
        return json_encode(Product::getAllProducts(['Shop_ID' =>$shopId]));
    }

}
