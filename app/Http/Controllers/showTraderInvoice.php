<?php
/**
 * Created by PhpStorm.
 * User: Khalid
 * Date: 7/20/2016
 * Time: 3:13 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class showTraderInvoice extends Controller
{

    public function getTraderInvoices(){

        $numOfInvoices = DB::table('invoices')->where('Shop_ID','=',Auth::user()->id)->count();
        //return response()->json(['invoices'=>DB::table('invoices')->select('invoiceid','invoicenumber','total','created_at')->where('Shop_ID',Auth::user()->id)->get()]);
        $invoiceWithTrader = DB::table('invoices')->leftJoin('trader', 'invoices.Trader_ID', '=', 'trader.TID')->
            where('Shop_ID','=',Auth::user()->id)->
            select('invoices.*','trader.name')->get();
        return response()->json(['invoices' => $invoiceWithTrader, 'numOfItems' => $numOfInvoices]);
    }

    public function getSpecificInvoice(Request $request){
        $result = DB::table('traderInvoice')->where([
            ['invoicenumber','=',$request['invoiceNumber']],
            ['Shop_ID','=',Auth::user()->id]])->get();
        return response()->json(['invoice' => $result]);

    }

    public function SpecificInvoice(){
//        $result = DB::table('traderInvoice')->where
    }

    public function EditInvoiceOrDeleteIt(Request $request){
        //$result = DB::table('traderInvoice')->where('invoicenumber',$request['invoiceID']);
        foreach ($request['items'] as $item) {
//            foreach ($result as $value){
//                if($item[7] == $value['TInvID']){
//                    if($item[0]!=$value['NameOfProduct'] || $item[1]!=$value['WholeQuantity'] || $item[2]!=$value['wholepricetrader']
//                        || $item[3]!=$value['wholepricesale'] || $item[4]!=$value['	numberOfUnitInCartoon'] || $item[5]!=$value['SingleUnitPrice']){
//
//                    }
//                }
//            }
            if($item[7] != 0) {
                $result = DB::table('traderInvoice')->where('TInvID', '=', $item[7])->get();
                $this->editItem($result);
                //$this->editMinusTotal($request['invoiceID'],$result[0]->total);
                $this->updateItemInvoice($item);
                $this->editItemProduct($item);
                $this->updateTotal($request['invoiceID'], $request['total']);
                //$this->editPlusTotal($request['invoiceID'],$item[6]);
            }

            if($item[7] == 0){
                $result = DB::table('products')->where([
                    ['Name','=',$item[0]],
                    ['Shop_ID','=',Auth::user()->id]
                ])->get();
                $this->insertIntoTraiderInvoice($request['invoiceID'],$item);

                if(count($result)){
                    $this->editItemProduct($item);
                }
                else{
                    $this->insertNewProduct($item);
                }
                $this->updateTotal($request['invoiceID'], $request['total']);
            }
        }

        for($count = 0; $count < count($request['delItem']); $count++){
            $result = DB::table('traderInvoice')->where('TInvID', '=', $request['delItem'][$count])->get();
            $this->editItem($result);
            DB::table('traderInvoice')->where('TInvID','=',$request['delItem'][$count])->delete();
            $this->updateTotal($request['invoiceID'], $request['total']);
            $qun = DB::table('products')->select('WholeQuantity')->where([
                ['Name','=',$result[0]->NameOfProduct],
                ['Shop_ID','=',Auth::user()->id]
            ])->first();
            if($qun->WholeQuantity == 0)
                DB::table('products')->where([
                    ['Name','=',$result[0]->NameOfProduct],
                    ['Shop_ID','=',Auth::user()->id]
                ])->delete();
        }

    }

    public function editItem($item){
        DB::table('products')->where([
            ['Name','=',$item[0]->NameOfProduct],
            ['Shop_ID','=',Auth::user()->id]
        ])->update([
            'WholeQuantity' => DB::raw('WholeQuantity - '.$item[0]->WholeQuantity),
            //'wholepricetrader' => DB::raw('wholepricetrader - '.($item[0]->wholepricetrader*$item[0]->WholeQuantity)),
            //'wholepricesale' => DB::raw('wholepricesale - '.($item[0]->wholepricesale*$item[0]->WholeQuantity)),
            //'SingleUnitPrice' => DB::raw('SingleUnitPrice + '.$item[5]),
            'SingleUnitAmount' => DB::raw('SingleUnitAmount - '.($item[0]->numberOfUnitInCartoon*$item[0]->WholeQuantity)),
            'total' => DB::raw('total - '.$item[0]->total)
        ]);

//        $amount = DB::table('products')->select('WholeQuantity')->where([
//            ['Name','=',$item[0]->NameOfProduct],
//            ['Shop_ID','=',Auth::user()->id]
//        ])->get();
//
//        if($amount == 0) {
//            DB::table('products')->where([
//                ['Name', '=', $item[0]->NameOfProduct],
//                ['Shop_ID', '=', Auth::user()->id]
//            ])->delete();
//        }
    }

    public function updateItemInvoice($item){
        DB::table('traderInvoice')->where('TInvID','=',$item[7])->update([
            'WholeQuantity' => $item[1],
            'wholepricetrader' => $item[2],
            'wholepricesale' => $item[3],
            'SingleUnitPrice' => $item[5],
            'numberOfUnitInCartoon' => $item[4],
            'total' => $item[6]
        ]);
    }

    public function editItemProduct($item){
        DB::table('products')->where([
            ['Name','=',$item[0]],
            ['Shop_ID','=',Auth::user()->id]
        ])->update([
            'WholeQuantity' => DB::raw('WholeQuantity + '.$item[1]),
            //'wholepricetrader' => DB::raw('wholepricetrader + '.($item[2]*$item[1])),
            //'wholepricesale' => DB::raw('wholepricesale + '.($item[3]*$item[1])),
            //'SingleUnitPrice' => DB::raw('SingleUnitPrice + '.$item[0]),
            'SingleUnitAmount' => DB::raw('SingleUnitAmount + '.($item[4]*$item[1])),
            'total' => DB::raw('total + '.$item[6])
        ]);
    }

    public function editMinusTotal($invoiceID,$total){
        DB::table('invoices')->where([
            ['invoiceid','=',$invoiceID],
            ['Shop_ID','=',Auth::user()->id]
        ])->update(['total' => DB::raw('total - '.$total)]);
    }

    public function editPlusTotal($invoiceID,$total){
        DB::table('invoices')->where([
            ['invoiceid','=',$invoiceID],
            ['Shop_ID','=',Auth::user()->id]
        ])->update(['total' => DB::raw('total + '.$total)]);
    }

    public function updateTotal($invoiceID,$total){
        DB::table('invoices')->where([
            ['invoiceid','=',$invoiceID],
            ['Shop_ID','=',Auth::user()->id]
        ])->update(['total' => $total]);
    }

    public function insertIntoTraiderInvoice($invoiceID,$item){
        DB::table('traderInvoice')->insert([
            ['invoicenumber' => $invoiceID, 'NameOfProduct' => $item[0], 'WholeQuantity' => $item[1],
                'wholepricetrader' => $item[2], 'wholepricesale' => $item[3],
                'SingleUnitPrice' => $item[5], 'total' => $item[6],
                'numberOfUnitInCartoon' => DB::raw('numberOfUnitInCartoon + '.($item[4])),
                'Trader_ID' => $item[9],'Shop_ID' => Auth::user()->id]
        ]);
    }

    public function insertNewProduct($item){
        DB::table('products')->insert([
            ['Name' => $item[0], 'WholeQuantity' => $item[1],
                //'wholepricetrader' => $item[2], 'wholepricesale' => $item[3],
                'numberOfUnitInCartoon' => $item[4],
                'SingleUnitAmount' => $item[4]*$item[1],
                'SingleUnitPrice' => $item[5], 'total' => $item[6],
//                'Trader_ID' => $item[9],
                'Shop_ID' => Auth::user()->id]
        ]);
    }

    public function deleteInvoice(Request $request){
        $items = DB::table('traderInvoice')->select('NameOfProduct','WholeQuantity','numberOfUnitInCartoon','Trader_ID')->where([
           ['invoicenumber','=',$request['invoiceID']],
           ['Shop_ID','=',Auth::user()->id]
        ])->get();

        foreach ($items as $item){
            DB::table('products')->where([
                ['Shop_ID','=',Auth::user()->id],
                ['Name','=',$item->NameOfProduct]
            ])
                ->update([
                    'WholeQuantity' => DB::raw('WholeQuantity - '.$item->WholeQuantity),
                    'SingleUnitAmount' => DB::raw('SingleUnitAmount - '.$item->WholeQuantity * $item->numberOfUnitInCartoon)
                ]);
            $qnt = DB::table('products')->select('WholeQuantity')->where([
                ['Shop_ID','=',Auth::user()->id],
                ['Name','=',$item->NameOfProduct]
            ])->first();
            if($qnt->WholeQuantity == 0)
                DB::table('products')->where([
                    ['Name', '=', $item->NameOfProduct],
                    ['Shop_ID', '=', Auth::user()->id]
                ])->delete();
        }
        DB::table('traderInvoice')->where([
            ['invoicenumber','=',$request['invoiceID']],
            ['Shop_ID','=',Auth::user()->id]
        ])->delete();
        DB::table('invoices')->where([
            ['invoiceid','=',$request['invoiceID']],
            ['Shop_ID','=',Auth::user()->id]
        ])->delete();

        $checkTrader = DB::table('traderInvoice')->where([
            ['Trader_ID', '=', $items[0]->Trader_ID],
            ['Shop_ID', '=', Auth::user()->id]])->count();

        if($checkTrader == 0){
            DB::table('trader')->where('TID','=',$items[0]->Trader_ID)->delete();
        }

    }

}