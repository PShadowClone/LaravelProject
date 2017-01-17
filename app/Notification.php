<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    //

    protected $table = 'notification';
    protected $fillable = [
        'notId',
        'content',
        'details',
        'status',
        'userId',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'notId';

    public static function allNotification($where = [])
    {

        if (empty($where))
            return Notification::where(['userId' => Auth::user()->id])->get();
        return Notification::where($where)->first();
    }

    public static function getTheNetProfitsForTheCurrentMonth($month , $shopId = null )
    {

        if($shopId == null)
            $shopId =  Auth::user()->id;
        $result = Array();
        $saleProfits = SaleInvoice::getTheProfitsOfTheCurrentMonth($month , $shopId);
        $invoiceDiscounts = TraderInvoice::getTheDiscountsOfTheCurrentMonth($month , $shopId);

        for($counter  = 1 ; $counter < 32 ; $counter++)
        {
          $result[$counter] = ($saleProfits[$counter]-$invoiceDiscounts[$counter]);

        }

        return $result;
    }
}
