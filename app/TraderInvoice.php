<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TraderInvoice extends Model
{
    protected $table = "traderinvoice";
    protected $fillable = [
        'TInvID',
        'ProductId',
        'WholeQuantity',
        'Price',
        'SingleUnitAmount',
        'SingleUnitPrice',
        'Barcode',
        'Trader_ID',
        'Shop_ID',
        'created_at',
        'updated_at'

    ];

    public static function getTraderInvoices($where = [])
    {
        if (empty($where))
            return TraderInvoice::all();
        return TraderInvoice::where($where)->get();

    }

    public static function getTheProductWithLowestPrice($where = [])
    {

         $result = TraderInvoice::where('wholepricetrader', $lowestPrice[$where['NameOfProduct']]= TraderInvoice::where($where)
            ->min('wholepricetrader'))
            ->get();

        return ['lowestPrice' => $lowestPrice , 'TraderInvoice' => $result];

    }

    public static function getTotalInvoices($where = [])
    {
        $shopId = Auth::user()->id;
        if(empty($where))
            return  TraderInvoice::where(['Shop_ID' => $shopId])->sum('total');
        return TraderInvoice::where($where)->sum('total');
    }

    public static function getTheDiscountsOfTheCurrentMonth($month ,$shopId = null )
    {
        if($shopId == null)
            $shopId =  Auth::user()->id;
//        if(empty($where))
//            return  TraderInvoice::where(['Shop_ID' => Auth::user()->id])->sum('total');
//        return TraderInvoice::where($where)->sum('total');

//        echo date('m', strtotime($month)) . '<br>';
//        echo date(Carbon::now()->year) . '<br>';

        $result  =Array();
        for($counter =1 ; $counter < 32 ; $counter++) {
            $result[$counter] = $currentMonthProfits = TraderInvoice::whereDay('created_at', '=', $counter)
                ->whereMonth('created_at', '=', date('m', strtotime($month)))
                ->whereYear('created_at', '=', date(Carbon::now()->year))
                ->where(['Shop_ID' => $shopId])
                ->sum('total');
            if($result[$counter] == null )
                $result[$counter] = 0 ;
            else
                $result[$counter] =  intval($result[$counter]);

        }
        return $result;
    }
}
