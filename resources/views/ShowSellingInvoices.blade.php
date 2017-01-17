<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/search.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:46:25 GMT -->
<head>
<style>
    .glyphicon { margin-left:5px; }
    .popover-title{
        text-align: right;
    }
</style>
@include('TemplateMainComponent.IncodingHeader')

<!-- Page title -->
    <title>Tigarty | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ URL::to('lobibox/demo/demo.css') }}"/>

    <link rel="stylesheet" href="{{ URL::to('lobibox/dist/css/Lobibox.min.css') }}"/>
    <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" />

    <link rel="stylesheet" href="{{URL::asset('bootstraps/styles/CustomStyleForShowProductAndSellingInvoices.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" />

    @include('TemplateMainComponent.CSSHeader')
    <link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/select2-3.5.2/select2.css')}}"/>
    <link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/select2-bootstrap/select2-bootstrap.css')}}"/>
    <link rel="stylesheet"
          href="{{URL::asset('bootstraps/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}"/>
    <link rel="stylesheet"
          href="{{URL::asset('bootstraps/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css')}}"/>
    <link rel="stylesheet"
          href="{{URL::asset('bootstraps/vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}"/>
    {{--bootstraps\vendor\datatables_plugins\integration\bootstrap\3--}}
    {{--bootstraps\vendor\datatables_plugins\integration\bootstrap\3--}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>--}}

<!-- Vendor styles -->
    {{--<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>--}}

    {{--<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/dt-1.10.12/datatables.min.js"></script>--}}

    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" />--}}

    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/bootstrap/dist/css/bootstrap.css')}}"/>--}}
    {{--<link rel="stylesheet" href="vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.css" />--}}

    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/fontawesome/css/font-awesome.css')}}"/>--}}
    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/metisMenu/dist/metisMenu.css')}}"/>--}}
    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/vendor/animate.css/animate.css')}}"/>--}}




<!-- App styles -->
    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}"/>--}}
    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/fonts/pe-icon-7-stroke/css/helper.css')}}"/>--}}
    {{--<link rel="stylesheet" href="{{URL::asset('bootstraps/styles/style.css')}}">--}}

    {{--@include('TemplateMainComponent.CSSHeader')--}}
    <script>
        var getResult = '{{route('getResultBySingleDate')}}';
        var getInvoices = '{{ route('saleInvoices') }}';
        var editInvoice = '{{ route('editSaleInvoice') }}';
        var deleteInvoice = '{{ route('deleteSaleInvoice') }}';
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
<div id="ex1" style="display:none;">
    <p>Thanks for clicking. That felt good. <a href="#" rel="modal:close">Close</a> or press ESC</p>
</div>
<div id="wrapper">

    <div class="normalheader transition animated fadeIn" dir="rtl">
        <div class="hpanel">
            <div class="panel-body">
                <h2 class="font-light m-b-xs">
                    عرض فواتير البيع
                </h2>
                <a class="small-header-action" href="#">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>


            </div>
        </div>
    </div>


    <div class="content animate-panel" >

        <div >


            <div class="row">

                <div class="col-lg-12">
                    <div class="hpanel">


                        <div class="panel-body">

                            <div class="">


                                {{--<div>--}}
                                {{--<a class="showhide"><i class="fa fa-chevron-up"></i></a>--}}
                                {{--<a class="closebox"><i class="fa fa-times"></i></a>--}}
                                {{--</div>--}}
                                <table id="example2" class="table table-striped table-bordered table-hover dataTable no-footer" >
                                    <thead dir="rtl">
                                    <tr>
                                        {{--<th style="text-align: center">#</th>--}}
                                        <th style="text-align: center"> رقم الفاتورة</th>
                                        <th style="text-align: center"> السعر الكلي</th>
                                        <th style="text-align: center;"> تاريخ اصدار الفاتورة</th>
                                        <th style="text-align: center; ">توقيت اصدار الفاتورة</th>
                                        <th style="text-align: center; ">التحكم</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align: center" dir="rtl">
                                    @if(isset($saleInvoices))
                                        @for($i = 1; $i <= $saleInvoices->count(); $i++)
                                            <tr id="{{$saleInvoices[$i-1]->SInvID}}">
                                                {{--<td></td>--}}
                                                <td>{{$i}}</td>
                                                <td>{{$saleInvoices[$i-1]->InvoiceTotal}}</td>
                                                <td>{{explode(' ',$saleInvoices[$i-1]->created_at)[0]}}</td>
                                                <td>{{explode(' ',$saleInvoices[$i-1]->created_at)[1]}}</td>
                                                <td><button class="btn btn-xs btn-warning showInvoice"   data-target="#contact" title="تعديل الفاتوره" id="{{$saleInvoices[$i-1]->SInvID}}"><i class="fa fa-pencil"></i></button>&nbsp;
                                                    <button class="btn btn-xs btn-danger deleteItem" data-placement="bottom" data-original-title title id="{{$saleInvoices[$i-1]->SInvID}}"><i class="fa fa-times"></i></button>
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif




                                    {{--@if(Session::has('saleInvoices'))--}}

                                    {{--@for($i = 1; $i <= Session::get('saleInvoices')->count(); $i++)--}}
                                    {{--<tr>--}}
                                    {{--<td>{{$i}}</td>--}}
                                    {{--<td>{{Session::get('saleInvoices')[$i-1]->SInvID}}</td>--}}
                                    {{--<td>{{Session::get('saleInvoices')[$i-1]->InvoiceTotal}}</td>--}}
                                    {{--<td>{{explode(' ',Session::get('saleInvoices')[$i-1]->created_at)[0]}}</td>--}}
                                    {{--<td>{{explode(' ',Session::get('saleInvoices')[$i-1]->created_at)[1]}}</td>--}}

                                    {{--</tr>--}}
                                    {{--@endfor--}}
                                    {{--@endif--}}
                                    {{--@else--}}

                                    {{--@for($i = 1; $i <= session()->get('saleInvoices')->count(); $i++)--}}
                                    {{--<tr>--}}
                                    {{--<td>{{$i}}</td>--}}
                                    {{--<td>{{session()->get('saleInvoices')[$i-1]->SInvID}}</td>--}}
                                    {{--<td>{{session()->get('saleInvoices')[$i-1]->InvoiceTotal}}</td>--}}
                                    {{--<td>{{session()->get('saleInvoices')[$i-1]->created_at}}</td>--}}

                                    {{--</tr>--}}
                                    {{--@endfor--}}
                                    {{--@endif--}}

                                    </tbody>
                                </table>

                            </div>


                            {{--<div class="row" dir="ltr">--}}
                            {{--<div id="pagination" class="col-sm-6 " >--}}
                            {{--@if(Session::has('saleInvoices'))--}}

                            {{--@include('TemplateMainComponent.CustomePagination',['paginator' => Session::get('saleInvoices')])--}}

                            {{--{{Session::get('saleInvoices')->render()}}--}}

                            {{--@else--}}

                            {{--@include('TemplateMainComponent.CustomePagination',['paginator' => session()->get('saleInvoices')])--}}
                            {{--{{session()->get('saleInvoices')->render()}}--}}
                            {{--@endif--}}

                            {{--</div>--}}
                            {{--</div>--}}


                        </div>


                    </div>

                </div>


            </div>




        </div>
        {{--<div class="col-md-4" dir="rtl">--}}
        {{--<form method="get" action="{{route('getResultBySingleDate')}}">--}}
        {{--<input name="_token" type="hidden" value="{{Session::token()}}">--}}
        {{--<input name="_token" type="hidden" value="{{csrf_token()}}">--}}
        {{--<div class="hpanel">--}}
        {{--<div class="panel-body">--}}
        {{--<div class="m-b-md">--}}
        {{--<h4>--}}
        {{--<i class="pe-7s-search"> </i>--}}
        {{--البحث--}}
        {{--</h4>--}}
        {{--<small>--}}
        {{--البحث عن طريق التاريخ--}}
        {{--</small>--}}
        {{--</div>--}}



        {{--<div class="form-group">--}}
        {{--<label class="control-label"> أدخل تاريخ البحث :</label>--}}
        {{--<div class="input-group date">--}}
        {{--<input id="fullDate" name="singleDate" type="text"--}}
        {{--class="input-sm form-control searchInput" value="{{session()->get('Date')}}">--}}
        {{--<span class="input-group-addon searchIcon"><i--}}
        {{--class="glyphicon glyphicon-th"></i></span>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group"><label> أو </label></div>--}}
        {{--<div class="form-group">--}}

        {{--<label> أدخل فترة البحث من -> الي :</label>--}}

        {{--<div class="input-daterange input-group" id="datepicker">--}}
        {{--<input id="firstDate" name="firstDate" type="text" class="input-sm form-control firstDoubleInput"--}}

        {{--value="{{session()->get('firstDate')}}"/>--}}
        {{--<span class="input-group-addon">to</span>--}}
        {{--<input id="lastDate" name="lastDate" type="text" class="input-sm form-control secondDoubleInput"--}}
        {{--value="{{session()->get('lastDate')}}"/>--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--@if(session()->has('dateError'))--}}
        {{--<div class="alert alert-danger newAlertStyle">--}}
        {{--<strong>خطأ!  </strong>--}}
        {{--{{session()->get('dateError')}}--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--<button id="search" name="search" class="btn btn-success btn-block"><i--}}
        {{--class="pe-7s-search"></i> بحث--}}
        {{--</button>--}}

        {{--</div>--}}

        {{--</div>--}}

        {{--</form>--}}
        {{--</div>--}}


    </div>

    <!-- Right sidebar -->
{{--<div id="right-sidebar" class="animated fadeInRight">--}}

{{--<div class="p-m">--}}
{{--<button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i--}}
{{--class="pe pe-7s-close"></i>--}}
{{--</button>--}}
{{--<div>--}}
{{--<span class="font-bold no-margins"> Analytics </span>--}}
{{--<br>--}}
{{--<small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>--}}
{{--</div>--}}
{{--<div class="row m-t-sm m-b-sm">--}}
{{--<div class="col-lg-6">--}}
{{--<h3 class="no-margins font-extra-bold text-success">300,102</h3>--}}

{{--<div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>--}}
{{--</div>--}}
{{--<div class="col-lg-6">--}}
{{--<h3 class="no-margins font-extra-bold text-success">280,200</h3>--}}

{{--<div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="progress m-t-xs full progress-small">--}}
{{--<div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"--}}
{{--class=" progress-bar progress-bar-success">--}}
{{--<span class="sr-only">35% Complete (success)</span>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="p-m bg-light border-bottom border-top">--}}
{{--<span class="font-bold no-margins"> Social talks </span>--}}
{{--<br>--}}
{{--<small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>--}}
{{--<div class="m-t-md">--}}
{{--<div class="social-talk">--}}
{{--<div class="media social-profile clearfix">--}}
{{--<a class="pull-left">--}}
{{--<img src="images/a1.jpg" alt="profile-picture">--}}
{{--</a>--}}

{{--<div class="media-body">--}}
{{--<span class="font-bold">John Novak</span>--}}
{{--<small class="text-muted">21.03.2015</small>--}}
{{--<div class="social-content small">--}}
{{--Injected humour, or randomised words which don't look even slightly believable.--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="social-talk">--}}
{{--<div class="media social-profile clearfix">--}}
{{--<a class="pull-left">--}}
{{--<img src="images/a3.jpg" alt="profile-picture">--}}
{{--</a>--}}

{{--<div class="media-body">--}}
{{--<span class="font-bold">Mark Smith</span>--}}
{{--<small class="text-muted">14.04.2015</small>--}}
{{--<div class="social-content">--}}
{{--Many desktop publishing packages and web page editors.--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="social-talk">--}}
{{--<div class="media social-profile clearfix">--}}
{{--<a class="pull-left">--}}
{{--<img src="images/a4.jpg" alt="profile-picture">--}}
{{--</a>--}}

{{--<div class="media-body">--}}
{{--<span class="font-bold">Marica Morgan</span>--}}
{{--<small class="text-muted">21.03.2015</small>--}}

{{--<div class="social-content">--}}
{{--There are many variations of passages of Lorem Ipsum available, but the majority have--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="p-m">--}}
{{--<span class="font-bold no-margins"> Sales in last week </span>--}}
{{--<div class="m-t-xs">--}}
{{--<div class="row">--}}
{{--<div class="col-xs-6">--}}
{{--<small>Today</small>--}}
{{--<h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>--}}
{{--</div>--}}
{{--<div class="col-xs-6">--}}
{{--<small>Last week</small>--}}
{{--<h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--<div class="col-xs-6">--}}
{{--<small>Today</small>--}}
{{--<h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>--}}
{{--</div>--}}
{{--<div class="col-xs-6">--}}
{{--<small>Last week</small>--}}
{{--<h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.--}}
{{--Many desktop publishing packages and web page editors.--}}
{{--</small>--}}
{{--</div>--}}

{{--</div>--}}

<!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>

</div>
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true" data-backdrop="static"  data-keyboard="false" dir="rtl">
    <div class="modal-dialog modal-md">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="float: left;color: white;margin-top: -3px">×</button>
                <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign"></span>تعديل فاتورة رقم <strong id="invoiceNum"></strong></h4>
            </div>
            <form id="invoiceForm" class="invoiceForm" method="post">
                <div class="row" style="margin-left: 30px;margin-right: 35px;margin-top: 20px">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped scroll" DIR="rtl" id="table">
                            <colgroup>
                                <col width="40px">
                                <!--<col width="50px">-->
                                <col width="190px">
                                <col width="130px">
                                <col width="120px">
                                <col width="120px">
                            </colgroup>
                            <thead>
                            <tr>
                                <th style="text-align: center"></th>
                                <th style="text-align: center">الصنف</th>
                                <th style="text-align:center">الكمية</th>
                                <th style="text-align: center">سعر الصنف</th>
                                <th style="text-align: center">المجموع</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr class="wholeTotal" style="background-color: #DFF2BF;">
                                <td colspan="4">
                                    <strong style="float: left;">المجموع الاجمالي</strong>
                                </td>
                                <td style="text-align: center"><strong id="generalTotal2">0</strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="panel-footer" style="margin-bottom:-14px;">
                    <input type="submit" id="submit" data-iditem="" class="btn btn-info" value="حفظ التعديلات"/>
                    <button style="float: left;" type="button" class="btn btn-default btn-close" id="closePopup" data-dismiss="modal">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Vendor scripts -->

{{--<script src="{{URL::asset('bootstraps/vendor/jquery/dist/jquery.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/jquery-ui/jquery-ui.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/slimScroll/jquery.slimscroll.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/metisMenu/dist/metisMenu.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/iCheck/icheck.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/sparkline/index.js')}}"></script>--}}

<script src="{{URL::asset('bootstraps/vendor/moment/moment.js')}}"></script>
<script src="{{URL::asset('bootstraps/vendor/select2-3.5.2/select2.min.js')}}"></script>
<script src="{{URL::asset('bootstraps/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{URL::asset('bootstraps/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{URL::asset('bootstraps/vendor/jquery/jquery-modal-master/jquery.modal.js')}}" type="text/javascript"
        charset="utf-8"></script>
{{--<script src="{{URL::asset('bootstraps/scripts/homer.js')}}"></script>--}}

{{--<script src="{{URL::asset('bootstraps/vendor/datatables_plugins/integration/bootstrap/3/jquery.dataTables.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>--}}

<script src="{{URL::asset('bootstraps/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('bootstraps/vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
{{--<script src="vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>--}}

{{--<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>--}}
{{--<script src="{{URL::asset('bootstraps/vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>--}}
@include('TemplateMainComponent.ScriptFooter')

        <!-- App scripts -->
<script src="{{URL::asset('bootstraps/scripts/ShowSaleInvoices.js')}}"></script>
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>--}}
<script src="{{ URL::to('scripts/bootstrap-confirmation.js') }}"></script>
{{--<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>--}}
<script src="{{ URL::to('lobibox/js/Lobibox.js') }}"></script>
<script src="{{ URL::to('lobibox/demo/demo.js') }}"></script>
@include('TemplateMainComponent.PusherScripts')

<script>

    $(function () {

        // Initialize Example 1
        $('#example1').dataTable( {
            "ajax": 'api/datatables.json'
        });

        // Initialize Example 2
        $('#example2').dataTable();

    });

</script>

<script>

    $(function () {

        $('.input-group.date').datepicker();

        $("#demo1").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10
        });

        $("#demo2").TouchSpin({
            verticalbuttons: true
        });

        $(".select2").select2();

    });

</script>
<script>

    $(function () {

        $('#datepicker').datepicker();
        $("#datepicker").on("changeDate", function (event) {
            $("#my_hidden_input").val(
                    $("#datepicker").datepicker('getFormattedDate')
            )
        });

        $('#datapicker2').datepicker();
        $('.input-group.date').datepicker({});
        $('.input-daterange').datepicker({});

        $("#demo1").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
        });

        $("#demo2").TouchSpin({
            verticalbuttons: true
        });

        $("#demo3").TouchSpin({
            postfix: '%'
        });

        $("#demo4").TouchSpin({
            postfix: "a button",
            postfix_extraclass: "btn btn-default"
        });

        $(".js-source-states").select2();
        $(".js-source-states-2").select2();

        //turn to inline mode
        $.fn.editable.defaults.mode = 'inline';

        //defaults
        $.fn.editable.defaults.url = '#';

        //editables
        $('#username').editable({
            url: '#',
            type: 'text',
            pk: 1,
            name: 'username',
            title: 'Enter username'
        });

        $('#firstname').editable({
            validate: function (value) {
                if ($.trim(value) == '') return 'This field is required';
            }
        });

        $('#sex').editable({
            prepend: "not selected",
            source: [
                {value: 1, text: 'Male'},
                {value: 2, text: 'Female'}
            ],
            display: function (value, sourceData) {
                var colors = {"": "gray", 1: "green", 2: "blue"},
                        elem = $.grep(sourceData, function (o) {
                            return o.value == value;
                        });

                if (elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            }
        });

        $('#dob').editable();

        $('#event').editable({
            placement: 'right',
            combodate: {
                firstItem: 'name'
            }
        });

        $('#comments').editable({
            showbuttons: 'bottom'
        });

        $('#fruits').editable({
            pk: 1,
            limit: 3,
            source: [
                {value: 1, text: 'banana'},
                {value: 2, text: 'peach'},
                {value: 3, text: 'apple'},
                {value: 4, text: 'watermelon'},
                {value: 5, text: 'orange'}
            ]
        });

        $('#user .editable').on('hidden', function (e, reason) {
            if (reason === 'save' || reason === 'nochange') {
                var $next = $(this).closest('tr').next().find('.editable');
                if ($('#autoopen').is(':checked')) {
                    setTimeout(function () {
                        $next.editable('show');
                    }, 300);
                } else {
                    $next.focus();
                }
            }
        });

    });

</script>

</body>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/search.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:46:32 GMT -->
</html>