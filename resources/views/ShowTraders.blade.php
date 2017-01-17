<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:46:40 GMT -->
<head>

    @include('TemplateMainComponent.IncodingHeader')

            <!-- Page title -->
    <title>Tigarty | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    @include('TemplateMainComponent.CSSHeader')
    <script>
        var getAllTraders = "{{ route('Traders') }}";
        var editTrader = '{{ route('EditTrader') }}';
        var token = '{{csrf_token()}}';
    </script>
</head>
<body>
<link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" />

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

    <div class="normalheader transition animated fadeIn" dir="rtl">
        <div class="hpanel">
            <div class="panel-body">
                <h2 class="font-light m-b-xs">
                    عرض التجار
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

        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading" dir="rtl">
                        <div class="panel-tools" style="float: left;">
                            <a class="closebox"><i class="fa fa-times"></i></a>
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        عرض جميع التجار الذي تم التعامل معهم
                    </div>
                    <div class="panel-body">
                        <table id="traders" class="table table-striped table-bordered table-hover" dir="rtl">
                            <thead>
                            <tr>
                                <th>اسم التاجر</th>
                                <th>البريد الالكتروني</th>
                                <th>رقم الجوال</th>
                                <th>العنوان</th>
                                <th>تاريخ الاضافة</th>
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
<div id="fadeandscale" class="well">
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
            <input type="submit" id="traderSubmit" class="btn btn-success" style="margin-left: 10px" value="تعديل">
            <button class="fadeandscale_close btn btn-default" id="closePopup" style="display: none;"></button>
        </div>
    </form>
</div>

<!-- Vendor scripts -->

@include('TemplateMainComponent.ScriptFooter')
<script src="{{ URL::to('bootstraps/scripts/showTraders.js') }}" defer="defer"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
<script src="{{ URL::to('bootstraps/popupTrader/jquery.popupoverlay.js') }}"></script>
@include('TemplateMainComponent.PusherScripts')


<script>

    $(function () {
        $('#traders').dataTable();
    });
    
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