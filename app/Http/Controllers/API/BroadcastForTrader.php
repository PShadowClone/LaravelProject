<?php

namespace App\Http\Controllers\API;

use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Pusher;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BroadcastForTrader extends Controller
{
    //

    public function index(Request $request)
    {
        $dataToPush =  Array();
        Storage::disk('local')->put('file.txt',$request);
       $productInfo = json_decode($request->input('productInfo'));
        $dataToPush['productName'] = $productInfo->productName;
        $dataToPush['productNumber'] = $productInfo->productNumber;
        $broadcastChannel = 'traderInvoiceAPI';
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
        $pusherBroadcast->broadcast([$broadcastChannel], 'trader_Invoice_API', $dataToPush);


    }

    private function broadcastTotTraderInvoice()
    {



        $broadcastChannel = Auth::user()->id.'traderInvoiceAPI';

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

       $pusherBroadcast->broadcast([$broadcastChannel], 'trader_Invoice_API', ['data']);

    }
}
