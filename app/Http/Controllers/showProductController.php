<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;

class showProductController extends Controller
{
    //

    public function ShowProducts()
    {

        if(Auth::check() == true )
        {
            $allProducts =  Product::where('Shop_ID', Auth::user()->id)->get();

            return view('Show Product',['allProducts' => $allProducts]);
        }

        return redirect()->route('Weblogin');
    }

    private function returnToShowView($allProducts)
    {
        return view('Show Product',compact('products',$allProducts));
    }

    public function searchForProduct(Request $request)
    {
        if(empty($request['body']))
        {
              return response()->json(['status' => '402' , 'message' => 'nothing to be searched']);

        }
        $product =  Product::where('Name',$request['body'])->get();


        if($product->isEmpty()){
            return response()->json(['status' => '404' , 'message' => 'Empty']);
        }
        return response()->json(['status' => '200' , 'message' => $product]);
    }
}
