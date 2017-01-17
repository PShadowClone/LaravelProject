<?php
/**
 * Created by PhpStorm.
 * User: Khalid
 * Date: 7/20/2016
 * Time: 3:04 AM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class showTradersController extends Controller
{

    public function getAllTraders(){
        $traders = DB::table('trader')
            ->join('traderinvoice', function($join)
            {
                $join->on('traderinvoice.Trader_ID', '=', 'trader.TID')
                    ->where('traderinvoice.Shop_ID', '=', Auth::user()->id);
            })->groupBy('Trader_ID')
            ->get(array(
                'Shop_ID',
                'TID',
                'name',
                'Email',
                'Mobile',
                'Address',
                'trader.created_at'
            ));


        return response()->json(['traders' => $traders]);
    }

    public function editTrader(Request $request){

        DB::table('trader')->where('TID','=',$request['tid'])->update([
           'Email' => $request['traderInfo'][1],
            'Mobile' => $request['traderInfo'][2],
            'Address' => $request['traderInfo'][3]
        ]);

    }

}