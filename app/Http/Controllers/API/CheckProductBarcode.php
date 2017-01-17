<?php

namespace App\Http\Controllers\API;

use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;

class CheckProductBarcode extends Controller
{
    //

    public function index(Request $request)
    {
        Storage::disk('local')->put('file.txt',$request);
        try {
            $productBarcode = json_decode($request->input('productNumber'));
            $productName = Product::where('Barcode', $productBarcode->productNumber)->first();
            if ($productName)
                return response()->json(['status' => 200, 'name' => $productName->Name]);

        } catch (Exception $exception) {
            return response()->json(['status' => 101, 'message' => $exception]);
        }
        return response()->json(['status' => 300, 'message' => 'product is not found']);
    }
}
