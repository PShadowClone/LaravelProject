<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/invoice.html by HTTrack Website Copier/3.x [XR&CO2014], Tue, 28 Jul 2015 12:46:25 GMT -->
<head>

    @include('TemplateMainComponent.IncodingHeader')

            <!-- Page title -->
    <title>Tigarty | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory  -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/jQuery-Autocomplete-master/content/styles.css')}}">


    <script>
        $allProducts = '';
        $productAmmountValidator = null;
        var token = '{{csrf_token()}}';
        var url = '{{route('checkName')}}';
        var allProductName = '{{route('allProductNames')}}';
        var checkAmount = '{{route('checkAmount')}}';
        var invoiceBill = '{{route('getReady')}}';
    </script>
    @include('TemplateMainComponent.CSSHeader')

    <style>
        .ui-autocomplete-input li {
            background-color: red;
        }

        .productSumStyle {
            text-align: center;
            vertical-align: center;
            font-size: 20px
        }

        .ui-menu .ui-menu-item input {
            background: red;
            height: 10px;
            font-size: 8px;
        }

        ul.ui-autocomplete.ui-menu {
            width: 400px
        }

    </style>
</head>
<body>

<!-- Simple splash screen-->
@include('TemplateMainComponent.SimpleSplash')
        <!--[if lt IE 7]>
@include('TemplateMainComponent.InternetExplorerValidation')
        <!--[endif]-->

<!-- Header -->
@include('TemplateMainComponent.PageHeader')
{{--@if()--}}

        <!-- Navigation -->
@include('TemplateMainComponent.NavigationBar')

        <!-- Main Wrapper -->

<!-- Right SideBar -->
@include('TemplateMainComponent.RightSideBar')

<div id="wrapper">


    <div class="normalheader transition animated fadeIn" dir="rtl">
        <div class="hpanel" dir="rtl">
            <div class="panel-body" dir="rtl">
                <a class="small-header-action" href="#">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>

                <h4 class="font-light m-b-xs" dir="rtl">
                    فاتورة بيع
                </h4>

            </div>
        </div>
    </div>

    <div class="content animate-panel">

        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">

                    <div class="panel-body p-xl">


                        <div class="row" style="padding-right:130px;padding-left:130px">

                            <div class="row" dir="rtl" style="font-size:16px;">
                                <div class="col-md-4">
                                    <div> رقم الفاتورة :<span id="billID"></span></div>
                                    <div> نوع الفاتور: فاتورة بيع</div>
                                    <div> تاريخ اصدار الفاتورة :<span id="invoiceDate"></span></div>

                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div> عدد السلع :<span id="numberOfProducts"></span></div>
                                    <div> المبلغ الاجمالي :<span id="invoiceTotal"></span></div>
                                    <div>وقت اصدار الفاتورة :<span id="invoiceTime"></span></div>
                                </div>

                            </div>
                            <form method="post" action="{{route('makeSale')}}" name="SaleForm" id="SaleForm"
                                  class="form" role="form" novalidate="novalidate">
                                <input id=" unknown" type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <hr/>
                                </div>
                                <div class="row">
                                    <div id='tableContent' dir="rtl">

                                        <table id="table" class="table table-bordered table-striped" name="SaleTable" dir="rtl">
                                            <thead style="text-align: center">
                                            <tr style="font-size:18px;">
                                                <th style="text-align: center; width: 50px">التحكم</th>
                                                <th style="text-align: center; width: 300px">اسم المنتج</th>
                                                <th style="text-align: center; width: 100px">الكمية</th>
                                                <th style="text-align: center">السعر</th>
                                            </tr>
                                            </thead>
                                            <tbody id="body">
                                            <tr>
                                                <td></td>
                                                <td><input id="productName" name="productName[]" type="text"
                                                           placeholder="  اسم المنتج "
                                                           style="width:100%; height: auto; right:0  !important;"
                                                           class="form-control" autocomplete="on" required="required">

                                                </td>

                                                {{--<span class="tooltip" title="This is my span's tooltip message!">Some text</span>--}}
                                                <td><input id="productAmount" name="productAmount[]"
                                                           placeholder=" الكمية  " pattern="\d+"
                                                           style="width:100%; height: auto;" class="form-control"
                                                           maxlength="4" required="required"/></td>
                                                <span id="auto"></span>
                                                <td id="productSum" name="productSum[]" class="productSumStyle"></td>

                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr style="font-size:18px;">
                                                <td class="alert alert-success">
                                                    <div class="btn btn-success " style="margin-right: 1px"><i
                                                                class="glyphicon glyphicon-plus"></i></div>
                                                </td>
                                                <td colspan="2" style="text-align: center"> السعر الاجمالي</td>
                                                <td style="text-align: center"><input id="invoiceSum" name="invoiceSum"
                                                                                      contenteditable="false"
                                                                                      class="form-control productSumStyle"
                                                                                      style="text-align: center;"
                                                                                      readonly></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                                <div class="row" style="width: 104%; font-size:16px;">
                                    <p style="float: right"> : ملاحظات </p>
                                    <div class="row" style="width: 100%; margin-left:1px;">
                                        <textarea name="note" style="height: 100px;width:100%;  "></textarea>
                                    </div>
                                </div>

                                <div class="row" style="animation: none !important;">

                                    {{--<div class="col-md-5">aaa</div>--}}
                                    {{--<div class="col-lg-1"></div>--}}

                                    <div class="col-lg-12" style=" text-align: center">

                                        <input id="cancel" name="cancel" type="reset" value="ا لغاء"
                                               class="btn btn-danger "/>
                                        <input id="save" name="Save" type="submit" value="اعتماد"
                                               class="btn btn-primary"
                                               width="30px"/>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <!-- Right sidebar -->

    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>

</div>

<!-- Vendor scripts -->
<?php
//        if()
?>

@include('TemplateMainComponent.ScriptFooter')
@include('TemplateMainComponent.PusherScripts')
@include('TemplateMainComponent.API.SalePointAPI')


{{--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>--}}
{{--<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.11.1/additional-methods.js"></script>--}}
{{--<script type="text/javascript" src="{{URL::asset('tooltipster/dist/js/tooltipster.bundle.min.js')}}"></script>--}}
<script src="{{URL::asset('bootstraps/vendor/jQuery-Autocomplete-master/dist/jquery.autocomplete.js')}}"></script>


<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
{{--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>--}}
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>
{{--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js"></script>--}}
<script src="{{URL::asset('bootstraps/scripts/SalePointScript.js')}}"></script>

</body>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:46:25 GMT -->
</html>