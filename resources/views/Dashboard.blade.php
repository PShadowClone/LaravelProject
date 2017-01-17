<?php
/**
 * Created by PhpStorm.
 * User: Amr Saidam
 * Date: 6/19/2016
 * Time: 3:27 PM
 */ ?>
        <!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:41:48 GMT -->
<head>
    {{\Carbon\Carbon::setLocale('ar')}}
    @include('TemplateMainComponent.IncodingHeader')
            <!-- Page title -->
    <title>Tigarty | WebApp admin theme</title>
    <style>

        .productOfTheHighestSales-showOnRequest {
            display: none;
        }

        #productOfTheHighestSales {
            display: none;
        }

        #productOfTheHighestProfit {
            display: none;
        }
    </style>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    @include('TemplateMainComponent.CSSHeader')
    <script>
        var allShopProduct = "{{route('prepareDashboard')}}";
        var token = "{{csrf_token()}}";
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
        <!-- Main Wrapper -->
<div id="wrapper">

    <div class="content animate-panel">
        @if(\Illuminate\Support\Facades\Auth::check())

            <div class="row">
                <div class="col-lg-12 text-center m-t-md">
                    <h2>
                        في تيجارتي   {{\Illuminate\Support\Facades\Auth::user()->name}} .أهلا وسهلاً أ

                    </h2>

                    <h4>
                        نتمنى لك استخدام <strong>سهل </strong> و <strong> مريح </strong>
                    </h4>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12" dir="rtl">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a class="closebox"><i class="fa fa-times"></i></a>
                        </div>

                        الأرباح المكتسبة لهذه السنة
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="text-center big" style="font-size: 15px">
                                <i class="fa fa-laptop" dir="rtl"></i>
                                الأرباح المكتسبة لهذه السنة
                            </div>
                            <div class="col-md-12 text-center">
                                <div>
                                    <canvas id="yearlyStatistics" height="80"></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        مجمل الأرباح المحققة في هذه السنة

                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-12" dir="rtl">
                    <div class="hpanel">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                <a class="closebox"><i class="fa fa-times"></i></a>
                            </div>
                            الأرباح المكتسبة لهذا الشهر
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="text-center big" style="font-size: 15px">
                                    <i class="fa fa-laptop" dir="rtl"></i>
                                    الأرباح المكتسبة لهذا الشهر
                                </div>
                                <div class="col-md-12 text-center">
                                    <div>
                                        <canvas id="monthStatistics" height="80"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            الأرباح المكتسبة لهذا الشهر

                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="hpanel">
                    <div class="panel-body text-center h-200">
                        <i class="pe-7s-graph1 fa-4x"></i>

                        <h1 class="m-xs">0</h1>

                        <h3 class="font-extra-bold no-margins text-success">
                        </h3>
                        <div style="margin-top: 10px !important;"> استخدام النظامعدد المبيعات لمنتجات المتجر</div>
                    </div>

                </div>
            </div>


            <div class="col-lg-3 showProgress" id="invoices">
                <div class="hpanel">
                    <div class="panel-body text-center h-200 showProgress">
                        <i class="pe-7s-news-paper fa-4x "></i>


                        <h1 class="m-xs">0</h1>

                        <h3 class="font-extra-bold no-margins text-success showProgress">
                        </h3>
                        <div class="progress m-t-xs full progress-striped productOfTheHighestSales-showOnRequest">

                            <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0%"
                                 role="progressbar" class=" progress-bar progress-bar-success ">
                                <span class="sr-only-focusable">0%</span>
                            </div>
                        </div>

                        <div style="margin-top: 10px !important;">نسبة فواتير اليوم الى الفواتير الكلية في المتجر</div>
                    </div>

                </div>
            </div>


            <div class="col-lg-3" id="todayProfits">
                <div class="hpanel">
                    <div class="panel-body text-center h-200">
                        <i class="pe-7s-cash fa-4x"></i>


                        <h1 class="m-xs">0</h1>

                        <h3 class="font-extra-bold no-margins text-success">
                        </h3>

                        <div style="margin-top: 10px !important;">مجموع أرباح اليوم للمتجر</div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3" id="allProfits">
                <div class="hpanel">
                    <div class="panel-body text-center h-200">
                        <i class="pe-7s-cash fa-4x"></i>


                        <h1 class="m-xs">0</h1>

                        <h3 class="font-extra-bold no-margins text-success">

                        </h3>
                        <div style="margin-top: 10px !important;">الأرباح الكلية للمتجر من بداية استخدام النظام</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="hpanel">
                <div class="panel-heading">

                </div>
            </div>


            <div class="col-lg-6" dir="rtl">

                <div class="hpanel">

                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        المنتج الأعلى مبيعاً
                    </div>
                    <div class="panel-body" id="productOfTheHighestSales" style="padding-right: 30px !important;">

                        <div class="col-lg-4" id="WholeQuantity">
                            <div style="font-size:20px; color:#62cb31; font-weight: 700;">الكمية المتبقية</div>
                            <div style="margin-right: 30px; font-size:20px; "></div>
                        </div>
                        <div class="col-lg-4" id="SingleUnitPrice">
                            <div style="font-size:20px; color:#62cb31; font-weight: 700;">سعر الوحدة</div>
                            <div style="margin-right: 30px; font-size:20px;"></div>
                        </div>
                        <div class="col-lg-4" id="productName">
                            <div style="font-size:20px; color:#62cb31; font-weight: 700; ">اسم المنتج</div>
                            <div style="margin-right: 10px; font-size:20px;"></div>
                        </div>

                    </div>
                    <div class="panel-body productOfTheHighestSales-showProductDetails">

                        <div>
                            <canvas id="doughnutChart" height="140"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" dir="rtl">

                <div class="hpanel">

                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        المنتج الأعلى ربحاً
                    </div>
                    <div class="panel-body" id="productOfTheHighestProfit" style="padding-right: 30px !important;">

                        <div class="col-lg-4" id="productOfTheHighest">
                            <div style="font-size:20px; color:#62cb31; font-weight: 700;">الكمية المتبقية</div>
                            <div style="margin-right: 30px; font-size:20px; "></div>
                        </div>
                        <div class="col-lg-4" id="SingleUnitPrice">
                            <div style="font-size:20px; color:#62cb31; font-weight: 700;">سعر الوحدة</div>
                            <div style="margin-right: 30px; font-size:20px;"></div>
                        </div>
                        <div class="col-lg-4" id="productName">
                            <div style="font-size:20px; color:#62cb31; font-weight: 700; ">اسم المنتج</div>
                            <div style="margin-right: 10px; font-size:20px;"></div>
                        </div>

                    </div>
                    <div class="panel-body productOfTheHighestProfit-showProductDetails">

                        <div>
                            <canvas id="productOfTheHighestProfit-doughnutChart" height="140"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Right sidebar -->
    @include('TemplateMainComponent.RightSideBar')


            <!-- Footer-->

    {{--{{\Carbon\Carbon::now()->year}}--}}
</div>

<!-- Vendor scripts -->
@include('TemplateMainComponent.DashboardScript')
@include('TemplateMainComponent.PusherScripts')


<script>


    $(function () {


        var allSales = 0;
        var profits = 0;
        var data1 = [];//[[0, 100], [1, 48], [2, 40], [3, 36], [4, 40], [5, 60], [6, 50], [7, 51]];
        var data2 = [[0, 56], [1, 49], [2, 41], [3, 38], [4, 46], [5, 67], [6, 57], [7, 59]];
        $showProductInDigram = [];
        $.ajax({
            method: "GET",
            url: allShopProduct,
            data: {body: "", post_id: "", _token: allShopProduct}
        }).success(function (products) {
            console.log(products['products']);
            $showProductInDigram = products['products'];
            $.each(products['products'], function (index, value) {
                data1.push([index, value['numberOfSale']]);
                allSales = allSales + value['numberOfSale'];

            });
            console.log('All Sales ' + allSales);

            $.each(products['saleInvoiceAvg']['saleInvoiceToday'], function (index, value) {


                profits = profits + value['total'];

            });
            console.log('amr');
            console.log(products['saleInvoiceAvg']);

            var theProfitOfMonths = [];
            var profitOfCurrentMonth = [];
            var monthDays = [];
            $.each(products['theProfitOfMonths'], function (index, value) {
                if (value == null)
                    theProfitOfMonths.push(0);
                else
                    theProfitOfMonths.push(value);

            });

            $.each(products['productOfCurrentMonth'], function (index, value) {
              //  monthDays.push(index);
                if (value == null)
                    profitOfCurrentMonth.push(0);
                else
                    profitOfCurrentMonth.push(value);

            });

            for(var counter = 1 ; counter <= 31 ; counter++)
            {
                monthDays.push(counter);
            }

            $('.h-200').children('h1').html(allSales);
            $('.h-200').children('h3').html('مجمل المبيعات');

            $('#invoices').children('.hpanel').children('.h-200').children('h1').html(products['saleInvoiceAvg']['saleInvoiceToday']);
            $('#invoices').children('.hpanel').children('.h-200').children('h3').html('عدد فواتير المبيعات لليوم');
            $('#invoices').children('.hpanel').children('.h-200').children('.progress-striped').children('div').children('span').html(products['saleInvoiceAvg']['avg']);
            $('#invoices').children('.hpanel').children('.h-200').children('.progress-striped').children('div').attr('aria-valuenow', products['saleInvoiceAvg']['avg']+"%").css('width', products['saleInvoiceAvg']['avg']+"%");
            $('#todayProfits').children('.hpanel').children('.h-200').children('h1').html(products['saleInvoiceAvg']['todayProfits'] == null ?0:products['saleInvoiceAvg']['todayProfits'] + '$');
            $('#todayProfits').children('.hpanel').children('.h-200').children('h3').html('مجمل أرباح اليوم ');


            $('#allProfits').children('.hpanel').children('.h-200').children('h1').html(products['saleInvoiceAvg']['allProfits'] + '$');
            $('#allProfits').children('.hpanel').children('.h-200').children('h3').html('الأرباح الكلية للمتجر');

            $('#saleInvoicesAvg').children('.hpanel').children('.panel-body').children('.m-t-xl').children('.progress').children('div').attr('aria-valuenow', products['saleInvoiceAvg']['avg']).css('width', products['saleInvoiceAvg']['avg']);
            $('#saleInvoicesAvg').children('.hpanel').children('.panel-body').children('.m-t-xl').children('.row').children('#allSaleInvoice').children('h4').html(products['saleInvoiceAvg']['allShopSaleInvoices']);
            $('#saleInvoicesAvg').children('.hpanel').children('.panel-body').children('.m-t-xl').children('.row').children('#todaySaleInvoice').children('h4').html(products['saleInvoiceAvg']['saleInvoiceToday']);
            $('#saleInvoicesAvg').children('.hpanel').children('.panel-body').children('.m-t-xl').children('.row').children('#saleInvoicesRatio').children('h4').html(products['saleInvoiceAvg']['avg'] + '%');
            $('#saleInvoicesAvg').children('.hpanel').children('.panel-body').children('.m-t-xl').children('.progress').children('div').children('span').html(products['saleInvoiceAvg']['avg']);


//
            $(this).showTheProductOfTheHighestSales(products['productOfTheHighestSales'], allSales);
            $(this).showTheProductOfTheHighestProfit(products['productOfTheHighestProfit'], allSales);
            $(this).initiateTheMainChart(theProfitOfMonths);
            $(this).initiateTheMainChartOfMonth(profitOfCurrentMonth , monthDays);


        });

    });


    //show invoice progress bar and hide it by hovering
    $('.showProgress').hover(function () {
        $('.productOfTheHighestSales-showOnRequest').show("slow");
    }, function () {


        $('.productOfTheHighestSales-showOnRequest').hide('slow');
    });

    $('.productOfTheHighestSales-showProductDetails').hover(function () {
        $('#productOfTheHighestSales').show("slow");
    }, function () {

        $('#productOfTheHighestSales').hide('slow');

    });


    $('.productOfTheHighestProfit-showProductDetails').hover(function () {
        $('#productOfTheHighestProfit').show("slow");
    }, function () {

        $('#productOfTheHighestProfit').hide('slow');

    });
</script>
<script>

    (function ($) {
        $.fn.showTheProductOfTheHighestSales = function ($theFirstProduct, $allSales) {

            $productOfTheHighestSales = $('#productOfTheHighestSales');
            $productOfTheHighestSales.children('#productName').children().last().html($theFirstProduct['Name']);
            $productOfTheHighestSales.children('#numberOfSale').children().last().html($theFirstProduct['numberOfSale']);
            $productOfTheHighestSales.children('#WholeQuantity').children().last().html($theFirstProduct['WholeQuantity']);
            $productOfTheHighestSales.children('#SingleUnitPrice').children().last().html($theFirstProduct['SingleUnitPrice']);

            var doughnutData = [
                {
                    value: $theFirstProduct['numberOfSale'],
                    color: "#62cb31",
                    highlight: "#57b32c",
                    label: $theFirstProduct['Name']
                },
                {
                    value: $allSales - $theFirstProduct['numberOfSale'],
                    color: "#91dc6e",
                    highlight: "#57b32c",
                    label: "Rest"
                }
            ];

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
                responsive: true,
            };


            var ctx = document.getElementById("doughnutChart").getContext("2d");
            var myNewChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
        }
    })(jQuery);


    (function ($) {
        $.fn.showTheProductOfTheHighestProfit = function ($theFirstProduct, $allSales, $chart) {

            $productOfTheHighestProfit = $('#productOfTheHighestProfit');
            $productOfTheHighestProfit.children('#productName').children().last().html($theFirstProduct['Name']);
            $productOfTheHighestProfit.children('#numberOfSale').children().last().html($theFirstProduct['numberOfSale']);
            $productOfTheHighestProfit.children('#productOfTheHighest').children().last().html($theFirstProduct['WholeQuantity']);
            $productOfTheHighestProfit.children('#SingleUnitPrice').children().last().html($theFirstProduct['SingleUnitPrice']);

            var doughnutData = [
                {
                    value: $theFirstProduct['numberOfSale'],
                    color: "#62cb31",
                    highlight: "#57b32c",
                    label: $theFirstProduct['Name']
                },
                {
                    value: $allSales - $theFirstProduct['numberOfSale'],
                    color: "#91dc6e",
                    highlight: "#57b32c",
                    label: "Rest"
                }
            ];

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
                responsive: true,
            };


            var ctx = document.getElementById("productOfTheHighestProfit-doughnutChart").getContext("2d");
            var myNewChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
        }
    })(jQuery);

</script>
<script>
    (function ($) {
        $.fn.initiateTheMainChart = function ($theProfitOfMonths) {
            console.log($theProfitOfMonths);

            var sharpLineData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'],
                datasets: [
                    {
                        label: "Example dataset",
                        fillColor: "rgba(98,203,49,0.5)",
                        strokeColor: "rgba(98,203,49,0.7)",
                        pointColor: "rgba(98,203,49,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(98,203,49,1)",
                        data: $theProfitOfMonths
                    }
                ]
            };

            var sharpLineOptions = {
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                bezierCurve: false,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 1,
                datasetFill: true,
                responsive: true
            };

            var ctx = document.getElementById("yearlyStatistics").getContext("2d");
            var myNewChart = new Chart(ctx).Line(sharpLineData, sharpLineOptions);

        }
    })(jQuery);
</script>


<script>
    (function ($) {
        $.fn.initiateTheMainChartOfMonth = function ($theProfitOfMonths , $monthDays) {
            console.log($theProfitOfMonths);
            var sharpLineData = {
                labels: $monthDays,
                datasets: [
                    {
                        label: "Example dataset",
                        fillColor: "rgba(98,203,49,0.5)",
                        strokeColor: "rgba(98,203,49,0.7)",
                        pointColor: "rgba(98,203,49,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(98,203,49,1)",
                        data: $theProfitOfMonths
                    }
                ]
            };

            var sharpLineOptions = {
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                bezierCurve: false,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 1,
                datasetFill: false,
                responsive: true
            };

            var ctx = document.getElementById("monthStatistics").getContext("2d");
            var myNewChart = new Chart(ctx).Line(sharpLineData, sharpLineOptions);

        }
    })(jQuery);
</script>

{{--<script>--}}
    {{--(function (i, s, o, g, r, a, m) {--}}
        {{--i['GoogleAnalyticsObject'] = r;--}}
        {{--i[r] = i[r] || function () {--}}
                    {{--(i[r].q = i[r].q || []).push(arguments)--}}
                {{--}, i[r].l = 1 * new Date();--}}
        {{--a = s.createElement(o),--}}
                {{--m = s.getElementsByTagName(o)[0];--}}
        {{--a.async = 1;--}}
        {{--a.src = g;--}}
        {{--m.parentNode.insertBefore(a, m)--}}
    {{--})(window, document, 'script', '../../www.google-analytics.com/analytics.js', 'ga');--}}

    {{--ga('create', 'UA-4625583-2', 'webapplayers.com');--}}
    {{--ga('send', 'pageview');--}}

{{--</script>--}}

</body>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:41:48 GMT -->
</html>
