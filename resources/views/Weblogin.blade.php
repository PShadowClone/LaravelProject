<!DOCTYPE html>
<html>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:41:48 GMT -->
<head>

    @include('TemplateMainComponent.IncodingHeader')

            <!-- Page title -->
    <title>Tigarty | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    @include('TemplateMainComponent.CSSHeader')

</head>
<body class="blank">

<!-- Simple splash screen-->
@include('TemplateMainComponent.SimpleSplash')
<!--[if lt IE 7]>
@include('TemplateMainComponent.InternetExplorerValidation')
<!--[endif]-->

<div class="color-line"></div>

<div class="login-container" dir="rtl" style="padding-top:3% !important ">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <img src="{{URL::asset('bootstraps/images/Tigarty/newLogo.png')}}" width="200px" height="200px" style="margin-bottom: -20px">
                <h2>تجارتي</h2>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <form action="{{ route('signin') }}" method="post" id="loginForm">
                        <div class="form-group {{ $errors->has("email") ? 'has-error' : '' }}">
                            <label for="email">الايميل</label>
                            <input type="text" placeholder="example@gmail.com" title="Please enter you username"
                                   value="{{ Request::old('email') }}" name="email" id="email" class="form-control">
                            
                        </div>
                        <div class="form-group {{ $errors->has("password") ? 'has-error' : '' }}">
                            <label for="password">كلمة المرور </label>
                            <input type="password" title="Please enter your password" placeholder="******"
                                   value="" name="password" id="password" class="form-control">

                        </div>
                        <div class="checkbox" style="font-size:15px;;">
                            <input type="checkbox" class="i-checks" checked>
                            ابقى متصلاً

                        </div>
                        <button class="btn btn-success btn-block">تسجيل الدخول</button>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <a class="btn btn-default btn-block" href="{{route('RegisterNewAccount')}}">حساب جديد</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Vendor scripts -->
@include('TemplateMainComponent.ScriptFooter')

</body>

<!-- Mirrored from webapplayers.com/homer_admin-v1.7/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2015 12:41:48 GMT -->
</html>