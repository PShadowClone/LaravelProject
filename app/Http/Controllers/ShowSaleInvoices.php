<?php

namespace App\Http\Controllers;

use Hamcrest\ResultMatcher;
use Illuminate\Http\Request;
use App\SaleInvoice;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShowSaleInvoices extends Controller
{
    private $temp = '';

    public function getAllSaleInvoices()
    {
//        $dateArray = array();

        if(Auth::check() == true)
        {
          
            $saleInvoices = SaleInvoice::where('Shop_ID',Auth::user()->id)->get();//paginate(10);
          //  var_dump($saleInvoices);
            //echo $saleInvoices['InvoiceTotal'];
           // var_dump($saleInvoices);
            //Session::put('saleInvoices', $saleInvoices);
           return view('ShowSellingInvoices',['saleInvoices' => $saleInvoices]);
        }
        return redirect()->route('Weblogin');


//        $dateArray = date_parse($saleInvoices[0]->created_at);
//        echo $dateArray['day'].'/'.$dateArray['month'].'/'.$dateArray['year'];
       // Session::flush();


//        if(Session::get('saleInvoices')->currentPage() <= 6)
//            echo 'yes';
       // dd(Session::get('saleInvoices'));


     //   return Session::get('saleInvoices');
         //Session::get('saleInvoices')->getUrlRange(Session::get('saleInvoices')->currentPage(),'5');
        //return view('test');
      //  return  Session::get('saleInvoices')->render();
    }

    public function getResultBySingleDate(Request $request)
    {

       // $request->session()->remove('dateError');
//        echo 'Amrsaidma         ';
     // $request->session()->put('key','Amr');
        //var_dump($request->session()->all());
      //  var_dump($request->input());

        $pages = $request->input('page');
        $singleDate = $request->input('singleDate');
        $firstDate = $request->input('firstDate');
        $lastDate = $request->input('lastDate');

//        echo 'what'.$singleDate;


        if (empty($pages)) {
            if (empty($singleDate) && empty($firstDate) && empty($lastDate)) {

               // echo 'All are Empty';
               // Session::flush();
                $request->session()->clear();
              return redirect('/dashboard/ShowSellingInvoices');
            }
        }

        if (!empty($firstDate) && !empty($lastDate)) {
//echo'nrrrrrrrrrrr'.$firstDate.'r';
            $request->session()->clear();

             $request->session()->put('firstDate', $firstDate);
             $request->session()->put('lastDate', $lastDate);
        }else if (!empty($singleDate)) {
            //echo $singleDate;
//            echo 'Fuck';
//            echo $this->temp = $singleDate;
//            $time = strtotime($singleDate);
//            echo '<br> the date after formate '.$time = date('Y-m-d',$singleDate).'<br>';
            $request->session()->clear();

            $request->session()->put('Date', $singleDate);
        }

//        echo  '<br> SingleDate '.$request->session()->get('Date');
//        echo  '<br> lastDate '.$request->session()->get('lastDate');
//        echo  '<br> $firstDate '.$request->session()->get('$firstDate');
////        $temp = $request;
//        echo $temp->input('singleDate');
//        Session::forget('saleInvoices');
        //$singleDate = $request->input('singleDate');
//        if ($request->ajax())
//             $request['body'];
//


        //$singleDate = '';
//        if (Session::has('singleDate'))
        //  echo $singleDate =  Session::get('singleDate');


        $saleInvoices = new SaleInvoice();
        $invocesArray = array();
        $invoiceID = array();
        $saleInvoices = SaleInvoice::all();


        if ($request->session()->has('Date'))
            $result = SaleInvoice::whereDate('created_at', '=', date('Y-m-d', strtotime($request->session()->get('Date'))))->paginate(10);
        else
            $result = SaleInvoice::whereDate('created_at', '<=', date('Y-m-d', strtotime($request->session()->get('lastDate'))))->whereDate('created_at', '>=', date('Y-m-d', strtotime($request->session()->get('firstDate'))))->paginate(10);


       // var_dump($result);
       // echo 'Size of array '.sizeof($result);
       if(sizeof($result) == 0) {
           Session::forget('saleInvoices');
           //$request->session()->clear();
           $request->session()->put('dateError','لايوجد في المتجر فواتير في هذا التاريخ');
          return redirect('/dashboard/ShowSellingInvoices');
       }
        Session::forget('saleInvoices');
        $request->session()->put('saleInvoices', $result);
               return view('ShowSellingInvoices');

//        Session::flush();
       // return redirect('/dashboard/ShowSellingInvoices');//->route('ShowSellingInvoicesWithResult');
        //   echo $saleInvoices;

//        $dateArray = date_format($saleInvoices[0]->created_at , 'd/m/y');
//        var_dump($dateArray);
//        //  echo $request['body'];
//        $minID = 0;
//        // echo $singleDate;
//        $flag = false;
//        // echo 'Single Date'.$singleDate;
//
////        else
////        {
////              echo $singleDate =  Session::get('singleDate');
////            echo 'is empty';
////        }
//////
//        echo Session::get('Date');
//
//        $result = SaleInvoice::whereDate('created_at', '=', date('Y-m-d', strtotime(Session::get('Date', $singleDate))))->paginate(10);
//        Session::put('saleInvoices', $result);
//        return view('ShowSellingInvoices');
////
//        for ($i = 0; $i < sizeof($saleInvoices); $i++) {
//            //echo $dateArray = date_format($saleInvoices[$i]->created_at, 'm/d/Y');
//            //  echo'<br>'.$saleInvoices[0]->created_at;
//            //  echo '<br>'.$dateArray;
//            // $dateOFInvoice = $dateArray['month'] . '/' . $dateArray['day'] . '/' . $dateArray['year'];
//            //  echo '<br>'.$dateOFInvoice;
//            // echo "<br>".$dateArray;
//            //$request['body']
//
//
////
////            if (strcmp($dateArray,$singleDate) == 0) {
//////                echo'<br/>'.$saleInvoices[$i]->SInvID;
////                //   echo $saleInvoices[$i]->SInvID;
////                // $minID = min($saleInvoices[$i + 1]->SInvID, $saleInvoices[$i]->SInvID);
////
////
////                //  echo $saleInvoices[$i]->SInvID;
////                $invocesArray[] = $saleInvoices[$i];// array_push($invocesArray ,'saleInvoice',);
////
////                // echo 'anything';
////                $flag = true;
////
////            }
//            //echo '<br>'.$dateArray;
//        }

        //echo '<br>'.max(array_keys($invocesArray));
        //  var_dump($invocesArray[44]);
        // echo'<br>'.array_search(max($invocesArray),$invocesArray);
//var_dump($invocesArray);
        // Session::forget('saleInvoices');

//        if (!Session::has('Date')) {
//            return redirect('/dashboard/ShowSellingInvoices');
//        }

//        $result =  DB::select('select * from saleinvoice where DATE(created_at) = ?', [
//            1 => '2016-06-26'
//        ]);


//

//
//        $result = $this->getTheRangeOfResult(sizeof($saleInvoices), $invocesArray);
//
//    if(!empty($result))
//        Session::put('paginationBoundaries',$result);
//
//      //  var_dump($result);
//
//       // echo  Session::get('paginationBoundaries')['max'];
//        $ready = SaleInvoice::where('SInvID', '>=',  Session::get('paginationBoundaries')['min'])->where('SInvID', '<=',  Session::get('paginationBoundaries')['max'])->paginate(10);
//
//
//
//        //Session::put('Date', $singleDate);
//

        // Session::forget('saleInvoices');

//        foreach ($ready as $int) {
//            echo '<br>' . $int->SInvID;
//        }

        //var_dump($ready);

//
        //return 'without fuck';


        // var_dump($ready);

//        $minID =;
//        $maxID = 0;
//        foreach($invocesArray as $SaleInvoice)
//        {
//            if($SaleInvoice->SInvID  < $minID)
//                $minID = $SaleInvoice->SInvID;
//
//            if($SaleInvoice->SInvID > $maxID)
//                $maxID  = $SaleInvoice->SInvID ;
//
//        }
//
//        echo '<br> min ' . $minID;
//        echo '<br> max ' . $maxID;
        //var_dump($invocesArray);
        // var_dump($invocesArray);

//        if ($request->ajax()) {
////            echo 'yes it is ';
////            echo 'yes it is ';
//            //        Session::forget('saleInvoices');
////
////       // $result = Paginator::make($invocesArray,count($invocesArray),10);
//            Session::flush();
//
//            Session::put('saleInvoices', $invocesArray);
//            return response([
//                'saleInvoices' => Session::all(),
//            ]);
//            //return response()->json(['status' => '200', 'message' => 'yes']);
//        }

//
//        Session::forget('saleInvoices');
//
//        $result = Paginator::make($invocesArray,count($invocesArray),10);
//        Session::put('saleInvoices',$result);
//        return view('ShowSellingInvoices');


        //return response()->json(['status' => '200' , 'message' => $invocesArray]);

        //return  response()->json(['status' => '404' , 'message' => 'there is no invoices in this date']);

    }


    private function getTheRangeOfResult($sizeOfSaleArray, $invocesArray)
    {
        $minID = $sizeOfSaleArray;
        $maxID = 0;
        foreach ($invocesArray as $SaleInvoice) {
            if ($SaleInvoice->SInvID < $minID)
                $minID = $SaleInvoice->SInvID;

            if ($SaleInvoice->SInvID > $maxID)
                $maxID = $SaleInvoice->SInvID;

        }

        return [
            'min' => $minID,
            'max' => $maxID
        ];

    }

    public function getSpecificInvoices(Request $request){
        $invoice = DB::table('sales')->leftJoin('products','sales.Product_ID','=','products.Product_ID')
            ->where([
                ['sales.Shop_ID','=',Auth::user()->id],
                ['sales.SaleInvoiceID','=',$request['invoiceID']]
            ])->select('sales.*','products.Name')->get();
        return response()->json(['invoice' => $invoice]);
    }

    public function editSaleInvoice(Request $request){
        foreach ($request['items'] as $item){
            $result = DB::table('sales')->where([
                ['Shop_ID','=',Auth::user()->id],
                ['Sale_ID','=',$item[4]]
            ])->first();

            $this->updatePlusItemData($result);
            $this->updateMinusItemData($item);
            $this->updateItem($item);
        }

        for($count = 0; $count < count($request['delItem']); $count++){
            $result = DB::table('sales')->where([
                ['Shop_ID','=',Auth::user()->id],
                ['Sale_ID','=',$request['delItem'][$count]]
            ])->first();

            $this->updatePlusItemData($result);
            DB::table('sales')->where([
                ['Shop_ID','=',Auth::user()->id],
                ['Sale_ID','=',$request['delItem'][$count]]
            ])->delete();
        }

        $this->updateTotal($request['total'],$request['invoiceID']);

    }

    public function updatePlusItemData($result){
        $info = DB::table('products')->where([
            ['Shop_ID','=',Auth::user()->id],
            ['Product_ID','=',$result->Product_ID]
        ])->select('SingleUnitAmount','numberOfUnitInCartoon')->first();

        DB::table('products')->where([
            ['Shop_ID','=',Auth::user()->id],
            ['Product_ID','=',$result->Product_ID]
        ])->update([
            'SingleUnitAmount' => $info->SingleUnitAmount + $result->NumberOfSingleUnitBought,
            'WholeQuantity' => ($info->SingleUnitAmount + $result->NumberOfSingleUnitBought) / $info->numberOfUnitInCartoon
        ]);
    }

    public function updateMinusItemData($result){
        $info = DB::table('products')->where([
            ['Shop_ID','=',Auth::user()->id],
            ['Name','=',$result[0]]
        ])->select('SingleUnitAmount','numberOfUnitInCartoon')->first();

        DB::table('products')->where([
            ['Shop_ID','=',Auth::user()->id],
            ['Name','=',$result[0]]
        ])->update([
            'SingleUnitAmount' => DB::raw('SingleUnitAmount - '.$result[3]),
            'WholeQuantity' => ($info->SingleUnitAmount - $result[3]) / $info->numberOfUnitInCartoon
        ]);
    }

    public function updateItem($result){
        DB::table('sales')->where([
            ['Shop_ID','=',Auth::user()->id],
            ['Sale_ID','=',$result[4]]
        ])->update([
           'NumberOfSingleUnitBought' => $result[3],
           'productTotal' => $result[2]
        ]);
    }

    public function updateTotal($total,$id){
        DB::table('saleinvoice')->where([
            ['Shop_ID','=',Auth::user()->id],
            ['SInvID','=',$id]
        ])->update(['InvoiceTotal' => $total]);
    }
    
    public function deleteSaleInvoice(Request $request){
        $items = DB::table('sales')->select('Product_ID','NumberOfSingleUnitBought')->where([
            ['SaleInvoiceID','=',$request['invoiceID']],
            ['Shop_ID','=',Auth::user()->id]
        ])->get();

        foreach ($items as $item){
            $info = DB::table('products')->where([
                ['Shop_ID','=',Auth::user()->id],
                ['Product_ID','=',$item->Product_ID]
            ])->select('SingleUnitAmount','numberOfUnitInCartoon')->first();

            DB::table('products')->where([
                ['Product_ID','=',$item->Product_ID],
                ['Shop_ID','=',Auth::user()->id]
            ])->update([
                'SingleUnitAmount' => $info->SingleUnitAmount + $item->NumberOfSingleUnitBought,
                'WholeQuantity' => ($info->SingleUnitAmount + $item->NumberOfSingleUnitBought) / $info->numberOfUnitInCartoon
            ]);
        }

        DB::table('sales')->where([
            ['SaleInvoiceID','=',$request['invoiceID']],
            ['Shop_ID','=',Auth::user()->id]
        ])->delete();

        DB::table('saleinvoice')->where([
            ['SInvID','=',$request['invoiceID']],
            ['Shop_ID','=',Auth::user()->id]
        ])->delete();

    }

}
