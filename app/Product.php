<?php

namespace App;

use Faker\Provider\Barcode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $fillable = ['Product_ID',
        'Name',
        'WholeQuantity',
        'numberOfUnitInCartoon',
        'wholepricetrader',
        'wholepricesale',
        'SingleUnitPrice',
        'total',
        'Barcode',
        'Shop_ID',
        'userID',
        'Trader_ID',
        'created_at',
        'updated-at'];


    public static function getAllProducts($where = [])
    {
        if(empty($where) || $where == null)
            return Product::all();
        return Product::where($where)->get();
    }

    public static function getTheProductOfTheHighestSales($shopId = null)
    {
        if($shopId == null)
            $shopId = Auth::user()->id;
        return Product::where(['Shop_ID' =>$shopId , 'numberOfSale' => Product::where(['Shop_ID' =>$shopId])->max('numberOfSale')])->first();
    }
    public static function getAllShopSales($shopId = null)
    {
        if($shopId == null)
            $shopId = Auth::user()->id;
        return Product::where(['Shop_ID' => $shopId])->sum('numberOfSale');
    }

    public static function getTheProductOfTheHighestProfit($shopId = null)
    {
        $max = 0;
        $bestProduct = [];
        if($shopId == null)
            $shopId = Auth::user()->id;
        $products = Product::getAllProducts(['Shop_ID' =>$shopId]);
        foreach ($products as $product) {
            if (($product['numberOfSale'] * $product['SingleUnitPrice']) >= $max) {
                $max = $product['numberOfSale'] * $product['SingleUnitPrice'];
                $bestProduct = $product;
            }
        }
        return $bestProduct;
    }
}


