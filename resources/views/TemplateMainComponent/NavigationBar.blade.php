{{\Carbon\Carbon::setLocale('ar')}}
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="{{route('dashboard')}}">
                <img src="{{ URL::to('bootstraps/images/Tigarty/newLogo.png') }}" class="m-b" alt="logo" style="width: 100px;height: 100px">
            </a>

            <div class="stats-label text-color" dir="rtl" style="margin-top:10px !important; ">
                <div class="medium">
                    <span class="text-center"><i class="glyphicon glyphicon-user"></i> أ.{{Auth::user()->name}}</span><br/>
                </div>
                <div class="medium" style="margin-top: 10px!important; margin-right:17px !important ;text-align: right" >
                    <span class="" style=""><i class="glyphicon glyphicon-home"></i> {{Auth::user()->address}}</span>
                </div>


                {{--<div class="medium">--}}
                    <div class="text-right medium" style="margin-top: 10px!important; margin-left:10px !important; margin-right:17px !important ;">
                        <i class="fa fa-check-circle" style="color:#62cb31;"></i>
                        @if(session()->has('userLoginTime'))
                            متصل {{session()->get('userLoginTime')->diffForHumans()}}
                        @endif
                    </div>

            </div>
        </div>

        <ul class="nav" id="side-menu" style="text-align: center">

            <li>
                <a href="{{route('dashboard')}}"> <span class="nav-label"> الرئيسية </span></a>
            </li>
            <li>
                <a href="#"><span class="fa arrow" style="float: left"></span><span class="nav-label" > ادخال فواتير </span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('SalePoint')}}"> نقطة بيع </a></li>
                    <li><a href="{{route('SupplierInvoice')}}"> فاتورة مشتريات</a></li>

                </ul>
            </li>
            <li>
                <a href="#"><span class="fa arrow" style="float: left"></span><span class="nav-label"> عرض فواتير </span> </a>
                <ul class="nav nav-second-level">

                    <li><a href="{{route('ShowSellingInvoices')}}"> عرض فواتير البيع </a></li>
                    <li><a href="{{ route('ShowTradersInvoices') }}"> عرض فواتير المشتريات </a></li>

                </ul>
            </li>
            <li>
                <a href="#"><span class="fa arrow" style="float: left"></span><span class="nav-label"> المستخدمين    </span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('AddUser')}}"> ادخال مستخدم جديد </a></li>
                    <li><a href="{{route('ShowUsers')}}"> عرض المستخدمين </a></li>
                </ul>
            </li>
            <li>
                <a href="#"><span class="fa arrow" style="float: left"></span><span class="nav-label"></span> الاشعارات  </a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('showAllNotification')}}">عرض الاشعارات </a></li>
                </ul>
            </li>

            <li>
                <a href="{{route('ShowTraders')}}"> <span class="nav-label"> عرض التجار </span></a>
            </li>
            <li>
                <a href="{{route('ShowProducts')}}"> <span class="nav-label"> عرض السلع </span></a>
            </li>

        </ul>
    </div>
</aside>
