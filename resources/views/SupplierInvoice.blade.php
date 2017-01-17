<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/tour.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:41:56 GMT -->
<head>

@include('TemplateMainComponent.IncodingHeader')

    <link rel="stylesheet" href="{{ URL::to('lobibox/font-awesome/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/jQuery-Autocomplete-master/content/styles.css')}}">
    <link rel="stylesheet" href="{{ URL::to('lobibox/demo/demo.css') }}"/>

    <link rel="stylesheet" href="{{ URL::to('lobibox/dist/css/Lobibox.min.css') }}"/>

<!-- Page title -->
    <title>Tigarty | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <style>
        .well {
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            display:none;
            margin:4em;
        }
        .initialism {
            font-weight: bold;
            letter-spacing: 1px;
            font-size: 12px;
        }
    </style>
    @include('TemplateMainComponent.CSSHeader')
    <script>
        var getInvoiceID = '{{ route('invoiceid') }}';
        var getshopItems = '{{ route('shopitems') }}';
        var insertNewItem = '{{ route('newItem') }}';
        var insertNewTrader = '{{ route('newTrader') }}';
        var getLastTraderID = '{{ route('lastTraderID') }}';
        var sinvoice = '{{ route('SupplierInvoice') }}';
        var token = '{{csrf_token()}}';
    </script>
</head>
<body>

<!-- Simple splash screen-->
@include('TemplateMainComponent.SimpleSplash')
<!--[if lt IE 7]>
@include('TemplateMainComponent.InternetExplorerValidation')
        <!--[endif]-->

<!-- Header -->
@include('TemplateMainComponent.PageHeader')
<!-- Navigation -->
@include('TemplateMainComponent.NavigationBar')

<!-- Right SideBar -->
@include('TemplateMainComponent.RightSideBar')
<!-- Main Wrapper -->
<div id="wrapper">


    <div class="normalheader transition animated fadeIn">
        <div class="hpanel tour-1">
            <div class="panel-body">
                <a class="small-header-action" href="#">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>

                <h4 class="font-light m-b-xs" dir="rtl">
                    اضافة فاتورة مشتريات من التاجر
                </h4>
                <small></small>
            </div>
        </div>
    </div>
    <div class="content animate-panel" id="idForRefresh">

        <div class="row">
            <div class="col-md-12">
                <div class="hpanel tour-2">

                    <div class="panel-body">
                        <form id="invoiceForm" class="invoiceForm" method="post">
                        <div class="row" dir="rtl">
                            <div class="col-lg-5">
                                <a class="initialism slide_open btn btn-success">اضافة تاجر جديد</a>
                            </div>
                            <div class="col-lg-4">
                                    <select class="form-control" id="selectedTraderName" name="selectedTraderName">
                                        <option value="0" disabled selected>اختار اسم التاجر</option>
                                    </select>

                            </div>
                            <div class="col-lg-3" style="width: 100%">

                            </div>
                            <div class="col-md-3" style="font-size: medium">
                                <div>
                                    <div>رقم الفاتوره: <span id="invoiceId"></span></div>
                                    <div>تاريخ الفاتوره: <span id="invoiceDate"></span></div>
                                </div>
                            </div>
                            <div class="col-md-9" style="font-size: medium;width:750px">
                                <div>
                                    <div>اسم التاجر:
                                        <span id="traderName"></span>
                                    </div>
                                    <div>العنوان:
                                        <span id="traderAddress"></span>
                                    </div>
                                    <div>الجوال:
                                        <span id="traderPhone"></span>
                                    </div>
                                    <div>البريد الالكتروني:
                                        <span id="tMail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left: 30px;margin-right: 35px;margin-top: 20px">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" DIR="rtl" id="table">
                                    <colgroup>
                                        <col width="40px">
                                        <!--<col width="50px">-->
                                        <col width="190px">
                                        <col width="120px">
                                        <col width="170px">
                                        <col width="150px">
                                        <col width="150px">
                                    </colgroup>

                                    <thead>
                                    <button type="button" class="btn btn-default addButton" style="float: right"><i class="fa fa-plus"></i></button>
                                    <tr>
                                        <th style=""></th>
                                        <!--<th style="text-align: center"> الرقم</th>-->
                                        <th style="text-align: center">الصنف</th>
                                        <th style="text-align: center">الكمية</th>
                                        <th style="text-align: center">سعر الكرتونه من التاجر</th>
                                        <th style="text-align: center">سعر الكرتونه للبيع</th>
                                        <th style="text-align: center;">عدد الوحدات</th>
                                        <th style="text-align: center">سعر الصنف</th>
                                        <th style="text-align: center">المجموع</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr class="inputsItem" id="1">
                                        <td></td>
                                        <!--<td class="index" style="text-align: center">1</td>-->
                                        <td class="ui-widget"><input type="text" name="item-1" class="form-control" id="item" onkeyup='$(this).validateItem();$(this).checkItem()'/></td>
                                        <td><input type="text" name="amount-1" class="form-control" id="amount" onkeyup='$(this).validateItem();$(this).clacualteTotal("wholePriceFromTrader")'/></td>
                                        <td><input type="text" name="wholePriceFromTrader-1" class="form-control" id="wholePriceFromTrader" onkeyup='$(this).validateItem();$(this).clacualteTotal("amount")'/></td>
                                        <td><input type="text" name="wholePriceForSale-1" class="form-control" id="wholePriceForSale" onkeyup='$(this).validateItem()'/></td>
                                        <td><input type="text" name="singleUnit-1" class="form-control" id="singleUnit" onkeyup='$(this).validateItem()'/></td>
                                        <td><input type="text" name="singlePrice-1" class="form-control" id="singlePrice" onkeyup='$(this).validateItem()'/></td>
                                        <td style="text-align: center"><strong name="autoTotal-1" id="autoTotal">0</strong></td>
                                    </tr>
<!--
                                    <tr id="1">
                                        <td></td>
                                        <td><input type="text" name="item-1" class="form-control" id="item"/></td>
                                        <td><input type="text" name="amount-1" class="form-control digit" id="amount"/></td>
                                        <td><input type="text" name="wholePriceFromTrader-1" class="form-control digit" id="wholePriceFromTrader"/></td>
                                        <td><input type="text" name="wholePriceForSale-1" class="form-control digit" id="wholePriceForSale"/></td>
                                        <td><input type="text" name="singlePrice-1" class="form-control digit" id="singlePrice"/></td>
                                        <td class="total"></td>
                                    </tr>
                                    -->
<!--
                                    <tr class="inputsItem hide" id="itemRoww">
                                        <th style="padding: 3px"><button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button></th>
                                        <td><input type="text" name="item" class="form-control item" id="item"/></td>
                                        <td><input type="text" name="amount" class="form-control" id="amount"/></td>
                                        <td><input type="text" name="wholePriceFromTrader" class="form-control" id="wholePriceFromTrader"/></td>
                                        <td><input type="text" name="wholePriceForSale" class="form-control" id="wholePriceForSale"/></td>
                                        <td><input type="text" name="singlePrice" class="form-control" id="singlePrice"/></td>
                                        <td class="total"></td>
                                    </tr>
-->

            <!--
                                    <tr>
                                        <th>
                                            <strong>الضريبة</strong>
                                        </th>
                                        <th colspan="5"><input type="text" name="tax" class="control-input" style="width: 100%"/>
                                        </th>
                                        <td></td>
                                    </tr>
-->
<!--
                                    <tr style="background-color: #ccc;">
                                        <th colspan="6">
                                            <strong style="float: left;">الضريبة</strong>
                                        </th>
                                        <th></th>
                                    </tr>

                                    <tr style="background-color: #ccc;">
                                        <th colspan="6">
                                            <strong style="float: left;">المجموع بعد الضريبة</strong>
                                        </th>
                                        <th></th>
                                    </tr>
-->
                                    </tbody>
                                    <tfoot>
                                    <tr class="wholeTotal" style="background-color: #DFF2BF;">
                                        <td colspan="7">
                                            <strong style="float: left;">المجموع الاجمالي</strong>
                                        </td>
                                        <td style="text-align: center"><strong id="generalTotal">0</strong></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                            </div>
                            <div class="col-lg-4">
                                <div style="text-align: center;" dir="rtl">
                                    <input type="submit" id="submit" class="btn btn-info" style="width:30%" value="اعتماد">
                                    <input type="reset" id="reset" class="btn btn-default-focus" style="width:30%;" value="إفراغ الحقول">
                                </div>
                            </div>
                            <div class="col-lg-4"></div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i
                        class="pe pe-7s-close"></i>
            </button>
            <div>
                <span class="font-bold no-margins"> Analytics </span>
                <br>
                <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            </div>
            <div class="row m-t-sm m-b-sm">
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">300,102</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">280,200</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
            </div>
            <div class="progress m-t-xs full progress-small">
                <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
                     class=" progress-bar progress-bar-success">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
            </div>
        </div>
        <div class="p-m bg-light border-bottom border-top">
            <span class="font-bold no-margins"> Social talks </span>
            <br>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            <div class="m-t-md">
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">John Novak</span>
                            <small class="text-muted">21.03.2015</small>
                            <div class="social-content small">
                                Injected humour, or randomised words which don't look even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Mark Smith</span>
                            <small class="text-muted">14.04.2015</small>
                            <div class="social-content">
                                Many desktop publishing packages and web page editors.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Marica Morgan</span>
                            <small class="text-muted">21.03.2015</small>

                            <div class="social-content">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-m">
            <span class="font-bold no-margins"> Sales in last week </span>
            <div class="m-t-xs">
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
            </div>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.
                Many desktop publishing packages and web page editors.
            </small>
        </div>

    </div>
    <div id="slide" class="well">
                <form id="traderForm" method="post" dir="rtl">
                <label style="float: right;">اسم التاجر</label>
                <input class="form-control" type="text" name="name" id="name"/>
                <br />

                <label style="float: right;">البريد الالكتروني</label>
                <input class="form-control" type="email" name="traderMail" id="traderMail" />
                <br />

                <label style="float: right;">رقم الجوال</label>
                <input class="form-control" type="text" name="mobileNumber" id="mobileNumber" />
                <br />

                <label style="float: right;">العنوان</label>
                <input class="form-control" type="text" name="address" id="address" />
                <br />

                <div class="action_btns" style="text-align: center">
                    <input type="submit" id="traderSubmit" class="btn btn-success" style="margin-left: 10px" value="اضافة">
                    <button class="slide_close btn btn-default" id="closePopup">اغلاق</button>
                </div>
            </form>
    </div>
    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>

</div>

<!-- Vendor scripts -->
@include('TemplateMainComponent.DashboardScript')

<script src="{{ URL::to('bootstraps/scripts/traderInvoice.js') }}" defer="defer"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
<script src="{{URL::asset('bootstraps/vendor/jQuery-Autocomplete-master/dist/jquery.autocomplete.js')}}"></script>
{{--<script type=src="{{ URL::to('scripts/jquery.autocomplete.js') }}"></script>--}}
{{--<script src="https://cdn.rawgit.com/vast-engineering/jquery-popup-overlay/1.7.13/jquery.popupoverlay.js"></script>--}}
<script src="{{ URL::to('bootstraps/popupTrader/jquery.popupoverlay.js') }}"></script>
<script src="{{ URL::to('lobibox/js/Lobibox.js') }}"></script>
<script src="{{ URL::to('lobibox/demo/demo.js') }}"></script>
<script src="{{ URL::to('scripts/jquery.cookie.js') }}"></script>

@include('TemplateMainComponent.PusherScripts')
@include('TemplateMainComponent.API.TraderInvoiceAPI')

<script type="text/javascript">
    $(document).ready(function() {

        $('#slide').popup({
            focusdelay: 400,
            outline: true,
            vertical: 'top'
        });

    });
</script>
<style>
    #slide_background {
        -webkit-transition: all 0.3s 0.3s;
        -moz-transition: all 0.3s 0.3s;
        transition: all 0.3s 0.3s;
    }
    #slide,
    #slide_wrapper {
        -webkit-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }
    #slide {
        -webkit-transform: translateX(0) translateY(-40%);
        -moz-transform: translateX(0) translateY(-40%);
        -ms-transform: translateX(0) translateY(-40%);
        transform: translateX(0) translateY(-40%);
    }
    .popup_visible #slide {
        -webkit-transform: translateX(0) translateY(0);
        -moz-transform: translateX(0) translateY(0);
        -ms-transform: translateX(0) translateY(0);
        transform: translateX(0) translateY(0);
    }
</style>
</body>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/tour.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:41:58 GMT -->
</html>