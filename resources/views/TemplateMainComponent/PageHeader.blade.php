<?php
/**
 * Created by PhpStorm.
 * User: Amr Saidam
 * Date: 6/19/2016
 * Time: 3:11 PM
 */
?>
<style>
    body.modal-open {
        padding-right: 0 !important;
    }

    .power-off:hover .pe-7s-power {
        color: #FF0000;
    }

    .notifications:hover .dropdown-toggle {
        color: #62CB31;
    }
</style>
<script>
    var updatePath = '{{route('updateNotificationStatus')}}';
    var getAllNotificationPath = '{{route('getAllNotifications')}}';
    var token = '{{csrf_token()}}';
</script>
{{--{{var_dump(Session::get('product'))}}--}}


<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version" style="text-align: center !important;">
        <span style="font-size: 20px; ">
تجارتي
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">HOMER APP</span>
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown power-off">
                    <a href="#">
                        <i class="pe-7s-power notAnimation"></i>
                    </a>
                </li>

                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" href="#" data-toggle="dropdown">--}}
                        {{--<i class="pe-7s-keypad"></i>--}}
                    {{--</a>--}}

                    {{--<div class="dropdown-menu hdropdown bigmenu animated flipInX">--}}
                        {{--<table>--}}
                            {{--<tbody>--}}
                            {{--<tr>--}}
                                {{--<td>--}}
                                    {{--<a href="projects.html">--}}
                                        {{--<i class="pe pe-7s-portfolio text-info"></i>--}}
                                        {{--<h5>Projects</h5>--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="mailbox.html">--}}
                                        {{--<i class="pe pe-7s-mail text-warning"></i>--}}
                                        {{--<h5>Email</h5>--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="contacts.html">--}}
                                        {{--<i class="pe pe-7s-users text-success"></i>--}}
                                        {{--<h5>Contacts</h5>--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<td>--}}
                                    {{--<a href="forum.html">--}}
                                        {{--<i class="pe pe-7s-comment text-info"></i>--}}
                                        {{--<h5>Forum</h5>--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="analytics.html">--}}
                                        {{--<i class="pe pe-7s-graph1 text-danger"></i>--}}
                                        {{--<h5>Analytics</h5>--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="file_manager.html">--}}
                                        {{--<i class="pe pe-7s-box1 text-success"></i>--}}
                                        {{--<h5>Files</h5>--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</li>--}}

                <li class="dropdown notifications">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-speaker notAnimation"></i>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX notificationMessages  notification" style=""
                        aria-expanded="true">
                        <div style=" overflow: auto;">

                        </div>
                    </ul>
                </li>
                <li>
                    <a href="#" id="aboutProject" class="" style="text-align: center">
                        <i class="pe-7s-upload pe-7s-news-paper notAnimation"></i>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</div>

<div id="aboutProjectModal" class="modal fade" tabindex="-1" role="dialog" dir="rtl">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 20px !important;  ">
            <div class="modal-header"
                 style=" color:whitesmoke !important; padding:10px 10px !important; border-top-left-radius: 10px !important; border-top-right-radius: 10px !important; background-color: #7ECB7B">
                {{--<div class="col-md-12">--}}

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="float:left !important; margin-top: 10px !important; "><span aria-hidden="true"
                                                                                           style=""><i
                                class="glyphicon glyphicon-remove-circle" style="color:black !important;"></i></span></button>
                <h4 class="modal-title">نبذة عن نظام تيجارتي</h4>
                {{--</div>--}}

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-8" style="font-size:16px !important; margin-right:20px !important;">
                        <p>هو نظام يهدف الى خدمة أصحاب المحلات التجارية عن طريق مساعدتهم في تتبع أحوال المتجر من مدخلات
                            ومبيعات الى جانب تتبع النظام المالي الخاص بالمحل </p>
                        <p> يركز نظام <strong> تيجارتي</strong> على توفير جميع خدماته باسلوب سهل وبسيط حتى يستطيع جميع الزبائن التعامل معه
                            بشكل بسيط دون الحاجة الى خلفية تكنولوجية .</p>
                        <p style="font-weight: 900 ">اصدار رقم : 1.1</p>
                        <p style="font-weight: 900 "> لتواصل :</p>
                        <p><i class="glyphicon glyphicon-phone"></i> 0595555555 </p>
                        <p><i class="glyphicon glyphicon-globe"></i> tigarty@hotmail.com</p>
                    </div>
                    <div class="col-md-4" style="margin-top: 0!important; margin-right:-40px !important;">
                        <img src="{{URL::asset('bootstraps/images/Tigarty/newLogo.png')}}" width="200px" height="200px" >
                    </div>
                </div>
            </div>
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
            {{--</div>--}}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="existConformation"  class="modal fade " tabindex="-1" role="dialog" dir="rtl" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 20px !important; ">
            <div class="modal-header"
                 style=" color:whitesmoke !important; padding:10px 10px !important; border-top-left-radius: 10px !important; border-top-right-radius: 10px !important; background-color: #ea6557">
                {{--<div class="col-md-12">--}}

                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"--}}
                        {{--style="float:left !important; margin-top: 10px !important; "><span aria-hidden="true"--}}
                                                                                           {{--style=""><i--}}
                                {{--class="glyphicon glyphicon-remove-circle" style="color:black !important;"></i></span></button>--}}
                <h4 class="modal-title"><i class="pe-7s-power"></i> تأكيد الخروج  </h4>
                {{--</div>--}}

            </div>
            <div class="modal-body" style="font-size: 25px;">
               هل تريد تسجيل الخروج ؟
            </div>
            <div class="modal-footer" style="text-align: center; background-color: white !important; border-bottom-left-radius: 10px !important; border-bottom-right-radius: 10px !important;">
            <button id="closeModal" type="button" class="btn btn-default" data-dismiss="modal" >لا</button>
            <button id="logout" type="button" class="btn btn-danger">نعم</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

