<?php

namespace App\Http\Controllers\API;

use App\Product;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Pusher;

class BroadcastForSale extends Controller
{

    public function index(Request $request)
    {
        $dataToBePushed =  Array();
        Storage::disk('local')->put('file.txt',Product::getAllProducts(['Shop_ID' => $request->input('userId')]));
        $productInfo = json_decode($request->input('productInfo'));

        $dataToBePushed['productName'] = $productInfo->productName;
        $broadcastChannel = 'salePointAPI';

        $options = array(
            'encrypted' => false
        );
        $pusher = new Pusher(
            '50de759f9fcf328ef11b',
            'd22d60478c76bc890574',
            '249346',
            $options
        );
        $pusherBroadcast = new PusherBroadcaster($pusher);
        $pusherBroadcast->broadcast([$broadcastChannel], 'trader_Invoice_API', $dataToBePushed);
    }
}
