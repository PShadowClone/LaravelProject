<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:46:40 GMT -->
<head>
    <link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/jQuery-Autocomplete-master/content/styles.css')}}">
    <style>
    /*body { margin-top:20px; }*/
    /*.modal-body:not(.two-col) { padding:0px }*/
    .glyphicon { margin-left:5px; }

    .popover-title{
        text-align: right;
    }

    /*.modal-body .radio label,.modal-body .checkbox label { display:block; }*/
    /*.modal-footer {margin-top: 0px;}*/
    /*@media screen and (max-width: 325px){*/
        /*.btn-close {*/
            /*margin-top: 5px;*/
            /*width: 100%;*/
        /*}*/
    /*}*/

    /*.progress {*/
        /*margin-right: 10px;*/
    /*}*/

</style>
    <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" />
    <link rel="stylesheet" href="{{ URL::to('lobibox/demo/demo.css') }}"/>

    <link rel="stylesheet" href="{{ URL::to('lobibox/dist/css/Lobibox.min.css') }}"/>
    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">--}}

{{--<link rel="stylesheet" href="{{ URL::to('scripts/bootstrap.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ URL::to('scripts/bootstrap.min.css') }}">--}}

@include('TemplateMainComponent.IncodingHeader')

<!-- Page title -->
    <title>Tigarty | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    @include('TemplateMainComponent.CSSHeader')
    <script>
        var getAllInvoices = "{{ route('Invoices') }}";
        var getInvoice = '{{ route('Invoice') }}';
        var getSpecificInvoice = '{{ route('SpecificInvoice') }}';
        var getshopItems = '{{ route('shopitems') }}';
        var editInvoice = '{{ route('EditInvoice') }}';
        var deleteInvoice = '{{ route('DeleteInvoice') }}'
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

<!-- Main Wrapper -->
<div id="wrapper">

    <div class="normalheader transition animated fadeIn" dir="rtl">
        <div class="hpanel">
            <div class="panel-body">
                <h2 class="font-light m-b-xs">
                    عرض الفواتير
                </h2>
                <a class="small-header-action" href="#">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>


            </div>
        </div>
    </div>

    <div class="content animate-panel">
        {{--<a class="initialism fadeandscale_open btn btn-success" href="#fadeandscale">Fade &amp; scale</a>--}}
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading" dir="rtl">
                        <div class="panel-tools" style="float: left;">
                            <a class="closebox"><i class="fa fa-times"></i></a>
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                      عرض فواتير المشتريات من التجار
                    </div>
                    <div class="panel-body">
                        <table id="invoices" class="table table-striped table-bordered table-hover" dir="rtl">
                            <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>المجموع</th>
                                <th>اسم التاجر</th>
                                <th>تاريخ الاصدار</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

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
                            <img src="images/a1.jpg" alt="profile-picture">
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
                            <img src="images/a3.jpg" alt="profile-picture">
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
                            <img src="images/a4.jpg" alt="profile-picture">
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

    <!-- Footer-->


</div>

<div id="fadeandscale" class="well" style="background-color: white">
    {{--<h4>Fade &amp; scale example</h4>--}}
    <div class="modal-content">
        <div class="modal-header" style="background-color: white;" dir="rtl">
            <h4 style="float: right" class="modal-title" id="myModalLabel"><i class="text-muted fa fa-shopping-cart"></i> <strong id="invoiceNumber"></strong> - تفاصيل الفاتورة </h4>
            <br><br>
        </div>
        <div class="modal-body">
            <div class="col-md-4">
                <img src="{{ URL::to('bootstraps/images/Tigarty/newLogo.png') }}" alt="teste" class="img-thumbnail">
            </div>
            <div class="col-lg-8">
            <table id="invoiceDetails" class="table table-striped table-bordered table-hover" dir="rtl" style="text-align: center">
                <thead>
                <tr>
                    <th style="text-align: center">الصنف</th>
                    <th style="text-align: center">الكمية</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
            <div class="clearfix"></div>
            {{--<p class="open_info hide">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>--}}
        </div>

        <div class="modal-footer" style="background-color: white;">

            <div class="" style="text-align: center">المبلغ الاجمالي<br/>
                <span class="h3 text-muted"><strong id="generalTotal1"></strong></span></span>
            </div>

            {{--<div class="text-right pull-right col-md-3">--}}
                {{--Atacado: <br/>--}}
                {{--<span class="h3 text-muted"><strong>R$35,00</strong></span>--}}
            {{--</div>--}}

        </div>
    </div>
    {{--<button class="fadeandscale_close slide_open btn btn-default">Next example</button>--}}
    {{--<button class="fadeandscale_close btn btn-default">Close</button>--}}
</div>

        <div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true" data-backdrop="static"  data-keyboard="false" dir="rtl">
            <div class="modal-dialog modal-lg">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: left;color: white;margin-top: -3px">×</button>
                        <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign"></span>تعديل فاتورة رقم <strong id="invoiceNum"></strong></h4>
                    </div>
                    <p id="traderID" style="display: none"></p>
                    <form id="invoiceForm" class="invoiceForm" method="post">
                    <div class="row" style="margin-left: 30px;margin-right: 35px;margin-top: 20px">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped scroll" DIR="rtl" id="table">
                                {{--<colgroup>--}}
                                    {{--<col width="40px">--}}
                                    {{--<!--<col width="50px">-->--}}
                                    {{--<col width="170px">--}}
                                    {{--<col width="100px">--}}
                                    {{--<col width="150px">--}}
                                    {{--<col width="120px">--}}
                                    {{--<col width="100px">--}}
                                {{--</colgroup>--}}

                                <thead>
                                <button type="button" class="btn btn-default addButton" style="float: right"><i class="fa fa-plus"></i></button>
                                <tr>
                                    <th style="text-align: center"></th>
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
                                </tbody>
                                <tfoot>
                                <tr class="wholeTotal" style="background-color: #DFF2BF;">
                                    <td colspan="7">
                                        <strong style="float: left;">المجموع الاجمالي</strong>
                                    </td>
                                    <td style="text-align: center"><strong id="generalTotal2">0</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer" style="margin-bottom:-14px;">
                        <input type="submit" id="submit" data-iditem="" class="btn btn-info" value="تعديل الاضافات"/>
                        <!--<span class="glyphicon glyphicon-ok"></span>-->
                        {{--<input type="reset" class="btn btn-danger" value="افراغ الحقول" />--}}
                        <!--<span class="glyphicon glyphicon-remove"></span>-->
                        <button style="float: left;" type="button" class="btn btn-default btn-close" id="closePopup" data-dismiss="modal">اغلاق</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>



<!-- Vendor scripts -->

@include('TemplateMainComponent.ScriptFooter')
<script src="{{ URL::to('bootstraps/scripts/showTraderInvoice.js') }}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
<script src="{{URL::asset('bootstraps/vendor/jQuery-Autocomplete-master/dist/jquery.autocomplete.js')}}"></script>
<script src="{{ URL::to('bootstraps/popupTrader/jquery.popupoverlay.js') }}"></script>
<script src="{{ URL::to('lobibox/js/Lobibox.js') }}"></script>
<script src="{{ URL::to('lobibox/demo/demo.js') }}"></script>
<script src="{{ URL::to('scripts/jquery.cookie.js') }}"></script>
{{--<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>--}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<script src="{{ URL::to('scripts/bootstrap-confirmation.js') }}"></script>
@include('TemplateMainComponent.PusherScripts')

{{--<script src="https://raw.githubusercontent.com/ethaizone/Bootstrap-Confirmation/master/bootstrap-confirmation.js"></script>--}}
<script>
    $(document).ready(function () {
        $('#fadeandscale').popup({
            pagecontainer: '.container',
            transition: 'all 0.3s'
        });
    });
</script>

<style>
    #fadeandscale {
        -webkit-transform: scale(0.8);
        -moz-transform: scale(0.8);
        -ms-transform: scale(0.8);
        transform: scale(0.8);
    }
    .popup_visible #fadeandscale {
        -webkit-transform: scale(1);
        -moz-transform: scale(1);
        -ms-transform: scale(1);
        transform: scale(1);
    }
</style>
<script>

    $(function () {

        // Initialize Example 1
//        $('#example1').dataTable( {
//            "ajax": 'api/datatables.json'
//        });

        // Initialize Example 2

        $('#invoiceDetails').dataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            'filter': false
        });
        //$('.dataTables_empty').html("");

    });

</script>

{{--<script>--}}

{{--$(function () {--}}

{{--$("#form").validate({--}}
{{--rules: {--}}
{{--password: {--}}
{{--required: true,--}}
{{--minlength: 3--}}
{{--},--}}
{{--url: {--}}
{{--required: true,--}}
{{--url: true--}}
{{--},--}}
{{--number: {--}}
{{--required: true,--}}
{{--number: true--}}
{{--},--}}
{{--max: {--}}
{{--required: true,--}}
{{--maxlength: 4--}}
{{--}--}}
{{--},--}}
{{--submitHandler: function (form) {--}}
{{--form.submit();--}}
{{--}--}}
{{--});--}}

{{--$("#form_2").validate({--}}
{{--rules: {--}}
{{--name: {--}}
{{--required: true,--}}
{{--minlength: 3--}}
{{--},--}}
{{--username: {--}}
{{--required: true,--}}
{{--minlength: 5--}}
{{--},--}}
{{--url: {--}}
{{--required: true,--}}
{{--url: true--}}
{{--},--}}
{{--number: {--}}
{{--required: true,--}}
{{--number: true--}}
{{--},--}}
{{--last_name: {--}}
{{--required: true,--}}
{{--minlength: 6--}}
{{--}--}}
{{--},--}}
{{--messages: {--}}
{{--number: {--}}
{{--required: "(Please enter your phone number)",--}}
{{--number: "(Please enter valid phone number)"--}}
{{--},--}}
{{--last_name: {--}}
{{--required: "This is custom message for required",--}}
{{--minlength: "This is custom message for min length"--}}
{{--}--}}
{{--},--}}
{{--submitHandler: function (form) {--}}
{{--form.submit();--}}
{{--},--}}
{{--errorPlacement: function (error, element) {--}}
{{--$(element)--}}
{{--.closest("form")--}}
{{--.find("label[for='" + element.attr("id") + "']")--}}
{{--.append(error);--}}
{{--},--}}
{{--errorElement: "span",--}}
{{--});--}}


{{--});--}}
{{--</script>--}}

</body>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:46:41 GMT -->
</html>