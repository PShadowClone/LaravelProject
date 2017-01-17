<?php

namespace App\Http\Controllers\API;

use App\Notification;
use App\Product;
use App\SaleInvoice;
use App\TraderInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AnalyticController extends Controller
{
    public function index(Request $request)
    {

        //- TraderInvoice::getTotalInvoices()
        $shopId = $request->input('userId');
      //  echo $shopId;
      //  Storage::disk('local')->put('file.txt',var_dump($request));

        $data = Array();
        $data['productOfHighestProfit'] = Product::getTheProductOfTheHighestProfit($shopId);
        $data['productOfTheHighestSale'] = Product::getTheProductOfTheHighestSales($shopId);
        $data['allShopSales'] = Product::getAllShopSales($shopId);
        $data['allShopProfits'] =  SaleInvoice::getTodayProfits(null,$shopId);
        $data['netProfitsOfCurrentMonth'] =  array_values(Notification::getTheNetProfitsForTheCurrentMonth(Carbon::parse(Carbon::now())->format('Y-m-d') , $shopId));

    return json_encode($data);
    }
}
