<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class AnchorController extends Controller
{

    function RegisterNewAccount()
    {
        if(!Auth::check())
            return view('RegisterNewAccount');
        return redirect('/');
    }
    function SalePoint()
    {
        if(Auth::check() == true)
            return view('Sales Point');
        return redirect()->route('Weblogin');
    }

    function SupplierInvoice()
    {
        return view('SupplierInvoice');
    }

    function ShowSellingInvoices()
    {
        if(Auth::check() == true)
            return view('ShowSellingInvoices');
        return redirect()->route('Weblogin');
    }
    function ShowTradersInvoices()
    {
        return view('Show Traders Bills');
    }
    function AddUser()
    {
        return view('AddUser');
    }
    function ShowUsers()
    {
        return view('ShowUsers');
    }
    function ShowProducts()
    {
        if(Auth::check() == true)
            return view('Show Product');
        return redirect()->route('Weblogin');
    }
    function ShowTraders()
    {
        if(Auth::check() == true)
            return view('ShowTraders');
        return redirect()->route('Weblogin');
    }
    function Login()
    {
        if(!Auth::check())
            return view('WebLogin');
        return redirect('/');
    }
    function Dashboard()
    {
        $PusherController = new PusherController();
        if(Auth::check() == true) {
           // $PusherController->checkProductAmount();
            return view('Dashboard');

        }return redirect()->route('Weblogin');
    }
    function tryy(){
        return view('try');
    }
    function SalePointWithError($error)
    {
        return view('Sales Point',compact('error',$error));
    }
    function tryof(){
        return view('tryof');
    }
}