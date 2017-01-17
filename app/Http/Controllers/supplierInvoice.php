<?php
/**
 * Created by PhpStorm.
 * User: Khalid
 * Date: 6/29/2016
 * Time: 4:39 AM
 */

namespace App\Http\Controllers;


use App\TraderInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use  Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;

class supplierInvoice extends Controller
{

    public function getLastInvoiceID(){

       // $listOfTraders = array();

//        $maxID = DB::table('invoices')->max('invoicenumber');
//        $maxID = DB::table('invoices')->select(DB::raw('max(invoicenumber)'))->where('Shop_ID', Auth::user()->id)
//            ->groupBy('Shop_ID')
//            ->get();

        //$maxID = DB::table('invoices')->where('Shop_ID', Auth::user()->id)->max('invoicenumber');
        $maxID = DB::table('invoices')->where('Shop_ID','=',Auth::user()->id)->count();
        $traders = DB::table('trader')
            ->join('traderinvoice', function($join)
            {
                $join->on('traderinvoice.Trader_ID', '=', 'trader.TID')
                    ->where('traderinvoice.Shop_ID', '=', Auth::user()->id);
            })->groupBy('Trader_ID')
            ->get(array(
                'Shop_ID',
                'Trader_ID',
                'name',
                'Email',
                'Mobile',
                'Address'
            ));
/*
            foreach ($traders as $trader){
                $listOfTraders[] = array($trader);
            }
*/
        return response()->json(['id' => $maxID , 'traders' => $traders]);

    }

    public function getShopItems(){

        return response()->json(['item'=>DB::table('products')->select('Name','numberOfUnitInCartoon')->where('Shop_ID',Auth::user()->id)->get()]);

    }

    public function insertNewItem(Request $request){

        Storage::disk('local')->put('file.txt',request());

      //  var_dump($request);

        $IDofInvoice = $this->insertWithGetID($request['items'][0][7],$request['total']);
        foreach ($request['items'] as $item){
//            DB::table('traderinvoice')->insert([
//                'NameOfProduct' => $item[0],
//                'WholeQuantity' => $item[1],
//                'wholepricetrader' => $item[2],
//                'wholepricesale' => $item[3],
//                'SingleUnitPrice' => $item[4],
//                'total' => $item[5],
//                'Trader_ID' => $item[6],
//                'Shop_ID' => Auth::user()->id
//            ]);
            //**********************************//
//            $query = "INSERT INTO traderinvoice (NameOfProduct, WholeQuantity, wholepricetrader, wholepricesale, SingleUnitPrice, total, Trader_ID, Shop_ID)
//                  SELECT * FROM (SELECT '$item[0]' AS field0 ,$item[1] AS field1 ,$item[2] AS field2 ,$item[3] AS field3 ,$item[4] AS field4 ,$item[5] AS field5 ,$item[6] AS field6 ,$id AS field7) AS tmp
//                  WHERE NOT EXISTS (
//                  SELECT NameOfProduct,Shop_ID FROM traderinvoice WHERE NameOfProduct = '$item[0]' AND Shop_ID = $id)";
//            echo DB::Query($query);
            //"update traderinvoice set WholeQuantity = $item[1], wholepricetrader = $item[2], wholepricesale = $item[3],SingleUnitPrice = $item[4], total = $item[5]";
//            DB::table('traderinvoice')
//                ->whereNotExists(function ($query) use ($item,$id) {
//                    $query->insert(DB::table('traderinvoice')->insert([
//                        ['NameOfProduct' => $item[0], 'WholeQuantity' => $item[1],
//                            'wholepricetrader' => $item[2], 'wholepricesale' => $item[3],
//                            'SingleUnitPrice' => $item[4], 'total' => $item[5],
//                            'Trader_ID' => $item[6],'Shop_ID' => $id]
//                    ]))
//                        ->where('NameOfProduct = '+$item[0]+'AND Shop_ID = '+$id);
//                });
            $result = DB::table('products')->where([
                ['Name','=',$item[0]],
                ['Shop_ID','=',Auth::user()->id]
            ])->get();

            DB::table('traderinvoice')->insert([
                ['invoicenumber' => $IDofInvoice, 'NameOfProduct' => $item[0], 'WholeQuantity' => $item[1],
                    'wholepricetrader' => $item[2], 'wholepricesale' => $item[3],
                    'SingleUnitPrice' => $item[5], 'total' => $item[6],
                    'numberOfUnitInCartoon' => DB::raw('numberOfUnitInCartoon + '.($item[4])),
                    'Trader_ID' => $item[7],
                    'Shop_ID' => Auth::user()->id]
            ]);

            if(count($result)){
                DB::table('products')->where([
                    ['Name','=',$item[0]],
                    ['Shop_ID','=',Auth::user()->id]
                ])->update([
                    'WholeQuantity' => DB::raw('WholeQuantity + '.$item[1]),
//                    'wholepricetrader' => DB::raw('wholepricetrader + '.($item[2]*$item[1])),
//                    'wholepricesale' => DB::raw('wholepricesale + '.($item[3]*$item[1])),
                    //'SingleUnitPrice' => DB::raw('SingleUnitPrice + '.$item[5]),
                    'SingleUnitAmount' => DB::raw('SingleUnitAmount + '.($item[4]*$item[1])),
                    'total' => DB::raw('total + '.$item[6])
                ]);
            }

            else{
                DB::table('products')->insert([
                    ['Name' => $item[0], 'WholeQuantity' => $item[1],
//                        'wholepricetrader' => $item[2], 'wholepricesale' => $item[3],
                        'numberOfUnitInCartoon' => $item[4],
                        'SingleUnitAmount' => $item[4]*$item[1],
                        'SingleUnitPrice' => $item[5], 'total' => $item[6],
                       // 'Trader_ID' => $item[7],
                        'Shop_ID' => Auth::user()->id]
                ]);
            }
        }

//        DB::table('invoices')->insert([
//            ['invoicenumber' => $request['items'][0][8], 'Shop_ID' => Auth::user()->id, 'Trader_ID' => $request['items'][0][7], 'total' => $request['total']]
//        ]);

    }

    public function insertWithGetID($traderID, $total){
        $id = DB::table('invoices')->insertGetId(array('Shop_ID' => Auth::user()->id, 'Trader_ID' => $traderID, 'total' => $total));
        return $id;
    }

    public function getLastTraderID(){
//        $trader = null;
//        $id = DB::table('trader')->insertGetId(array('name'=> $request['trader'][0], 'Email'=> $request['trader'][1],
//            'Mobile'=> $request['trader'][2], 'Address'=> $request['trader'][3]));
//        if($id != null){
//            $trader = DB::table('trader')->select('TID','name','Email','Mobile','Address')->where([
//                ['name','=', $request['trader'][0]],
//                ['TID','=',$id]
//            ])->get();
//        }
        $id = 0;
        $result = DB::table('trader')->select('TID')->get();

        if(count($result))
            $id = DB::table('trader')->orderBy('TID', 'desc')->first()->TID;

        return response()->json(['id' => $id]);
    }

    public function insertNewTrader(Request $request){
        $id = DB::table('trader')->insertGetId(array('name'=> $request['trader'][0], 'Email'=> $request['trader'][1],
            'Mobile'=> $request['trader'][2], 'Address'=> $request['trader'][3]));
        return response()->json(['id' => $id]);
    }

}