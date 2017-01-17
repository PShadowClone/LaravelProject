<?php

namespace App\Http\Controllers;

use App\Jobs\JobTest;
use App\Notification;
use App\Product;
use App\SaleInvoice;
use App\TraderInvoice;
use Carbon\Carbon;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Console\ScheduleServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;
use Pusher;
use Illuminate\Contracts\Broadcasting\Broadcaster;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Amp;

class PusherController extends Controller
{


    public function getBestTrader()
    {
    }

    public  function checkProductAmount()
    {
        $productsName = [];
        $shop_Id = Auth::user()->id;
        $products = Product::getAllProducts(['Shop_ID' => $shop_Id]);
        foreach ($products as $product) {
            if (($product['numberOfSale'] / $product['SingleUnitAmount']) >= 0.75) {
                $productsName[] = $product;
            }
        }

       // Storage::disk('local')->put('file.txt',"Single ". $productsName);

        return $this->getTheBestTrader($productsName);

    }

    private  function getTheBestTrader($productsName)
    {
        if(!Auth::check())
            return redirect()->route('Weblogin');
        $result = [];
        foreach ($productsName as $productName) {
            $products = $this->getTheProductWithLowestPrice($productName['Name']);
            $result['lowestPrice'][$productName['Name']] = $products['lowestPrice'];
            foreach ($products['TraderInvoice'] as $product) {
                $result['requiredProducts'][$product['NameOfProduct']][] = $this->fetchTargetedTraders($product);
            }
        }
        $productPro = [];
        foreach ($productsName as $product) {
            $productPro[$product['Name']] = $product;
        }

        $sentProduct = $this->checkNotification($productPro);

        if(!empty($sentProduct)) {
            $setTraders =  $this->determineTraders($sentProduct , $result);

            $notification = ['products' => $sentProduct, 'size' => sizeof($sentProduct), 'traders' => $setTraders];
            return $notification;

            }
        return null;
    }

    public function initializePusher()
    {

        $this->pushingNotification($this->checkProductAmount());
    }

    private function getTheProductWithLowestPrice($productName)
    {
        return TraderInvoice::getTheProductWithLowestPrice(['NameOfProduct' => $productName]);

    }

    private function fetchTargetedTraders($product)
    {
        return DB::table('trader')->where(['TID' => $product['Trader_ID']])->first();
    }

    public function prepareDashboard()
    {
        return response()->json(['products' => Product::getAllProducts(['Shop_ID' => Auth::user()->id]),
            'saleInvoiceAvg' => $this->getTheAvgOfSaleInvoicesToday(),
            'productOfTheHighestSales' => $this->getTheProductOfTheHighestSales(),
            'productOfTheHighestProfit' => $this->getTheProductOfTheHighestProfits(),
            'theProfitOfMonths' => $this->getTheProfitOfEverySingleMonth(),
        'productOfCurrentMonth' => array_values(Notification::getTheNetProfitsForTheCurrentMonth(Carbon::parse(Carbon::now())->format('Y-m-d') , Auth::user()->id))]);
    }



    public function getTheAvgOfSaleInvoicesToday()
    {

        $date= Carbon::parse(Carbon::now())->format("Y-m-d");
      //  var_dump($date);
        return [
            'allShopSaleInvoices' => SaleInvoice::getTheCountOfSaleInvoicesToday(),
            'saleInvoiceToday' => SaleInvoice::getTheCountOfSaleInvoicesToday($date),
            'avg' => round(SaleInvoice::getTheCountOfSaleInvoicesToday($date) / (SaleInvoice::getTheCountOfSaleInvoicesToday()==0?1: SaleInvoice::getTheCountOfSaleInvoicesToday()) * 100, 1),
            'todayProfits' => SaleInvoice::getTodayProfits($date),
            'allProfits' => SaleInvoice::getTodayProfits() - TraderInvoice::getTotalInvoices()
        ];

    }

    public function getTheProductOfTheHighestSales()
    {
        return Product::getTheProductOfTheHighestSales();
    }

    public function getTheProductOfTheHighestProfits()
    {
        return Product::getTheProductOfTheHighestProfit();
    }
    public function getTheProfitOfEverySingleMonth()
    {

        return SaleInvoice::getTheProfitOfEverySingleMonth();
    }



    public function pushingNotification($data)
    {

        if (!(Auth::check()))
            return redirect()->route('Weblogin');




        $broadcastChannel = Auth::user()->name . '' . Auth::user()->id;

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

        $pusherBroadcast->broadcast([$broadcastChannel], 'my_event', ['data' => $data, 'size' => sizeof($data), 'Astatus' => 'تحذير', 'Estatus' => 'danger', 'title' => 0]);

        return true;

    }

    private function checkNotification($products)
    {
        $notification = New Notification();
        $sentProducts = array();
        foreach($products as $key => $value)
        {
            $content = 'name='.$key.'/productId='.$value['Product_ID'].'/updated_at='.$value['updated_at'];
            $result = Notification::allNotification(['content' => $content, 'userId' => Auth::user()->id]);


            $flag = false;
           // echo 'result '.$result;
            if(!isset($result))
            {
                $notification->content = $content;
                $notification->	status = 'unseen';
                $notification->details = json_encode($value);
                $notification->userId = Auth::user()->id;
                $notification->save();
                $flag = true;

            }

            $valueAsArray =  $value->toArray();
          //  var_dump($result);
          ///  echo sizeof($result);
            array_push($valueAsArray,$result['status']);
                $sentProducts[$key] = $valueAsArray ;

        }
        return $sentProducts;

    }

    private function determineTraders($products , $traders)
    {

        $sentTraders = [];
        foreach($products as $key => $value)
        {
            foreach($traders["lowestPrice"] as $traderKey => $traderValue)
            {

                if(strcmp($key , $traderKey) == 0)
                {
                    $sentTraders["lowestPrice"][$traderKey] = $traderValue;

                }
            }
            foreach($traders["requiredProducts"] as $traderKey => $traderValue)
            {


                if(strcmp($key , $traderKey) == 0)
                {
                    $sentTraders["requiredProducts"][$traderKey] = $traderValue;

                }
            }

        }
        return $sentTraders;
    }
    public function updateNotificationStatus(Request $request)
    {
        if($request->ajax())
        {
            $notification = Notification::where(['content'  => $request['body'] , 'userId' => Auth::user()->id])->first();
            $notification->status = 'seen';
            $notification->save();
        }
    }

    public function getAllNotifications(Request $request)
    {
            $notifications  = Notification::allNotification(['userId' => Auth::user()->id]);
            return response()->json(['notifications' => $notifications]);
    }

    public function getData(Request $request)
    {
        return response()->json(['notification' => $this->checkProductAmount() , 'status' => 200]);
    }


    public function showAllNotificationPage()
    {
        return view('showAllNotifications',['notifications' => Notification::allNotification()]);
    }


}
