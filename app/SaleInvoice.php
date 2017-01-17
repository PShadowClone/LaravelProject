<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SaleInvoice extends Model
{

    protected $table = 'saleinvoice';
    protected $fillable = [
        'SInvID',
        'InvoiceTotal',
        'note',
        'userID',
        'created_at',
        'updated_at'
    ];

    public static function getSaleInvoices($where = [])
    {
        if (empty($where))
            return SaleInvoice::all();
        return SaleInvoice::where($where)->get();
    }

    public static function getTheCountOfSaleInvoicesToday($demandedDate = null)
    {
        $shop =  Auth::user()->id;
        if ($demandedDate == null)
            return SaleInvoice::where(['Shop_ID' =>$shop])->count();
        return SaleInvoice::whereDate('created_at', '=', $demandedDate)->where(['Shop_ID' => $shop])->count();
    }

    public static function getTodayProfits($demandedDate = null ,$shopId = null )
    {
       // echo 'dsadf';
        if($shopId == null)
            $shopId =  Auth::user()->id;

        if ($demandedDate == null) {

            return SaleInvoice::where(['Shop_ID' => $shopId])->sum('InvoiceTotal');
        }

        return SaleInvoice::whereDate('created_at', '=', $demandedDate)->where(['Shop_ID' =>  $shopId])->sum('InvoiceTotal');
    }

//    public static function getShopProfits($demandedDate = null ,$shopId = null )
//    {
//        if($shopId == null)
//            $shopId =  1;
//        if ($demandedDate == null)
//            return SaleInvoice::where(['Shop_ID' =>  $shopId])->sum('InvoiceTotal');
//
//        return SaleInvoice::whereDate('created_at', '=', $demandedDate)->where(['Shop_ID' =>  $shopId])->sum('InvoiceTotal');
//
//    }
    public static function getTheProfitOfEverySingleMonth()
    {
        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );
        $monthsProfit = array();
        foreach ($months as $month) {

            $monthsProfit[$month] = SaleInvoice::whereMonth('created_at', '=', date('m', strtotime($month)))
                ->whereYear('created_at', '=', date(Carbon::now()->year))
                ->where(['Shop_ID' => Auth::user()->id])
                ->sum('InvoiceTotal');
        }
        return $monthsProfit;
    }

    public  static function getTheProfitsOfTheCurrentMonth($month , $shopId = null )
    {

        if($shopId == null)
            $shopId = Auth::user()->id;
       // $shopId = Auth::user()->id;
        $result  =Array();
        for($counter =1 ; $counter < 32 ; $counter++) {
            $result[$counter] = $currentMonthProfits = SaleInvoice::whereDay('created_at', '=', $counter)
                ->whereMonth('created_at', '=', date('m', strtotime($month)))
                ->whereYear('created_at', '=', date(Carbon::now()->year))
                ->where(['Shop_ID' => $shopId])
                ->sum('InvoiceTotal');
            if($result[$counter] == null )
                $result[$counter] = 0 ;
            else
                $result[$counter] =  intval($result[$counter]);

        }
        return $result;
    }

//    public static function getMonthProfitsInEachDay($month)
//    {
//        $result  = Array();
//        $monthProfits = SaleInvoice::getTheProfitsOfTheCurrentMonth($month);
//        foreach($monthProfits as $profit )
//        {
//            $monthDay = date('d', strtotime($profit['created_at']));
//            echo $monthDay.'<br/>';
//            if($monthDay)
//            $result[$profit[$monthDay]] = $profit['InvoiceTotal'];
//        }
//
//        return $result;
//    }
}
