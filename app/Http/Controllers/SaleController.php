<?php

namespace App\Http\Controllers;

use App\Product;
use App\SaleInvoice;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Session;

class SaleController extends Controller
{

    function makeSale(Request $request)
    {

        $pusher = new PusherController() ;
        $product = array();
        $product = [
            'productName' => $request->input('productName'),
            'productAmount' => $request->input('productAmount'),
            'productTotal' => $request->input('productSum')
        ];

        $counter = 0;
        foreach ($product['productName'] as $productName) {

            if (empty($productName) || trim($productName, " ") == '')
                $counter++;
        }

        if ($counter == sizeof($product['productName'])) {
            return redirect('/dashboard/SalePoint');
        }


        $invoiceID = $this->saveInvoice($request->input('invoiceSum'), $request['note']);
        $this->saveSaleInvoiceProduct($product, $invoiceID);
        $pusher->initializePusher();
        return redirect('/dashboard/SalePoint');


    }

    private function saveSaleInvoiceProduct($productArray, $invoiceID)
    {


        $arraySize = count($productArray['productName']);

        for ($counter = 0; $counter < $arraySize; $counter++) {
            if ($productArray['productName'][$counter] != "") {

                echo DB::update('update products set SingleUnitAmount = ((WholeQuantity * numberOfUnitInCartoon) - ' . $productArray['productAmount'][$counter] . ') , WholeQuantity = (SingleUnitAmount / numberOfUnitInCartoon )
                 , numberOfSale  = numberOfSale + '.$productArray['productAmount'][$counter].' where Name = "' . $productArray['productName'][$counter] . '" AND Shop_Id = '.Auth::user()->id.'; ');


               $this->saveProductInSales($productArray , $counter, $invoiceID);
            }
        }

        return true;
    }


    function checkName(Request $request)
    {

        if ($request['body'] == '') {
            return response()->json(['status' => '404', 'message' => 'Empty']);
        }

        $CameProduct = explode('/', $request['body']);

        $result = Product::where(['Name' => '' . $CameProduct[0], 'Shop_ID' => Auth::User()->id])->get();

        if ($CameProduct[0] == '') {
            return response()->json(['status' => '403', 'message' => 'Empty']);
        }

        if ($result->isEmpty()) {
            return response()->json(['status' => '403', 'message' => 'does not exist in shop or your request is empty']);
        }

        if ($CameProduct[1] == 'null') {
            return response()->json(['status' => '200', 'message' => $result]);
        }

        $productSum = $CameProduct[1] * $result[0]['SingleUnitPrice'];
        return response()->json(['status' => '202', 'message' => $productSum]);


    }

    function getAllProductNames()
    {
        $result = DB::table('products')->where('Shop_ID', Auth::User()->id)->lists('Name');

        return response()->json(['status' => '200', 'message' => $result]);
    }

    function checkAmount(Request $request)
    {

        $CameProduct = explode('/', $request['body']);

        $product = Product::where('Name', $CameProduct[0])->where('Shop_ID', Auth::User()->id)->get();
        if (!is_numeric($CameProduct[1])) {
            return response()->json(['status' => '404', 'message' => 'incorrect formula']);
        }

        if ($product->isEmpty())
            return response()->json(['status' => '404', 'message' => 'Empty']);

        if ($CameProduct[1] > $product[0]['SingleUnitAmount'])
            return response()->json(['status' => '404', 'message' => 'out of product Amount']);

        $result = $product[0]['SingleUnitPrice'] * $CameProduct[1];
        return response()->json(['status' => '200', 'message' => $result]);

    }

    private function saveInvoice($request, $note)
    {

        $saleInvoice = new SaleInvoice();
        //$saleInvoice->Shop_ID = 1;
        $saleInvoice->InvoiceTotal = $request;
        $saleInvoice->note = $note;
        $saleInvoice->Shop_ID = Auth::User()->id;

        $saleInvoice->save();
        return DB::table('saleinvoice')->max('SInvID');


    }

    private function saveProductInSales($productArray, $counter, $invoiceID)
    {

        $unitPrice = DB::table('products')->where([
            ['Shop_ID','=',Auth::user()->id],
            ['Name','=',$productArray['productName'][$counter]]
        ])->select('SingleUnitPrice')->first();

        DB::insert('INSERT  into sales (NumberOfSingleUnitBought,singleUnitPrice,Product_ID,SaleInvoiceID,productTotal,Shop_ID)
                   VALUES('.$productArray['productAmount'][$counter].','.$unitPrice->SingleUnitPrice.',
                   (SELECT Product_ID from products where
                    Name = "'.$productArray['productName'][$counter].'" And Shop_Id = '.Auth::user()->id.') , '.$invoiceID.','.$productArray['productAmount'][$counter]*$unitPrice->SingleUnitPrice.','.Auth::user()->id.')');

    }

    public function getReady()
    {
        $result = DB::table('saleinvoice')->where('Shop_ID','=',Auth::user()->id)->count();

        return response()->json(['status' => '200', 'message' => $result+1]);
    }
}
