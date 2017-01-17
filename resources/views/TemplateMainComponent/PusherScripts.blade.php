@if(!\Illuminate\Support\Facades\Auth::check())
    {{redirect()->route('Weblogin')}}
@endif
<script>
    var displayedNotification = [];
    var notificationProducts = null;
    var pusher = new Pusher('50de759f9fcf328ef11b');


   // console.log(token);
    $(document).ready(function(){
        console.log('Start');
        $.ajax({
            method:'POST',
            url:'{{route('getData')}}',
            data:{body:'', post_id: '', _token:token}
        }).success(function(notifications){
//            status
            if(notifications['notification'] == null)
                    return;
            notificationProducts = notifications['notification'];
            console.log(notificationProducts);

            $.each(notifications['notification']['products'],function(index,value){
                $content = 'name=' + index + '/productId=' + notifications['notification']['products'][index]['Product_ID'] + '/updated_at=' + notifications['notification']['products'][index]['updated_at'];
                displayedNotification[index] = $content;
            });
            callShowingPackageForReady(notificationProducts,1);

        });
    });

    $('#aboutProject').click(function()
    {
        $('#aboutProjectModal').modal('show');
    });

    $('.power-off').click(function(){

        $('#existConformation').modal('show');
    });

    $('#closeModal').click(function(){
        $('#existConformation').modal('hide');
    });
    $('#logout').click(function(){
        location.href = "{{route('logout')}}";
    });

    $('.notAnimation').hover(function(){
        $(this).effect("bounce", "slow");
        //$('.pe-7s-speaker')
    });

    var channel = pusher.subscribe('{{\Illuminate\Support\Facades\Auth::user()->name.''.\Illuminate\Support\Facades\Auth::user()->id}}');
    channel.bind('my_event', function (data) {
        callShowingPackage(data, 1);


    });

    function callShowingPackageForReady(data, numberOfUnseenNotifications) {
        this.notificationAnimationScript(data, numberOfUnseenNotifications);
       showNotificationMessagesForReady(data);
    }
    function callShowingPackage(data, numberOfUnseenNotifications) {
        this.showNotificationMessages(data);
    }

    //checking the existing of came notification
    function checkNotifications(data) {

        if (displayedNotification.length == 0)
            callShowingPackage(data);

        $.each(displayedNotification, function (notificationIndex, notificationValue) {
            $.each(data['data']['products'], function (index, value) {
                $content = 'name=' + index + '/productId=' + data['data']['products'][index]['Product_ID'] + '/updated_at=' + data['data']['products'][index]['updated_at'];
                if (notificationValue == $content) {
                    data['data']['traders']['lowestPrice'][index] = null;

                }

            });
        });
       return data;

    }

    function notificationAnimationScript(data, numberOfUnseenNotifications) {

        $('.notifications').addClass('label-menu-corner');
        $('.notifications').children('.dropdown-toggle').append('<span class="label label-success"></span>');
        $('.label-menu-corner .label').css('right', '15px');

        $.each(data['products'], function(index,value){
            if(value[0] == 'unseen') {
                $notificationNumber = parseInt($('.notifications').children('.dropdown-toggle').children('span').html());
                $('.notifications').children('.dropdown-toggle').children('span').html(isNaN($notificationNumber) ? 1 : $notificationNumber + 1);

            }
        });
    }


    function showNotificationMessages($message) {
        $message = checkNotifications($message);

        if ($('.notificationMessages').children('div').children('li').length == 6)
            $('.notificationMessages').children('div').css('height', '300px');

        $notificationTitle = '';
        $.each($message['data']['traders']['lowestPrice'], function (index, value) {
            if ($message['products'][index][0] == 'unseen') {
                $content = 'name=' + index + '/productId=' + $message['data']['products'][index]['Product_ID'] + '/updated_at=' + $message['data']['products'][index]['updated_at'];
                $id = '' + index + '' + $message['data']['products'][index]['Product_ID'];
                notificationProducts = $message['data'];
                $notificationTitle = '<li class=\'notificationElement' + $id + '\'>' +
                        '<a  onclick="ShowNotificationContent(\'' + index + '\' ,\'' + $content + '\',\'' + $id + '\')" style="white-space: nowrap !important; font-weight: lighter" >انخفاض في كمية المنتج ' + index + '</a>' +
                        '</li>';
                $('.notificationMessages').children('div').append($notificationTitle);
                notificationAnimationScript(1,0);
            }else
            {
                $content = 'name=' + index + '/productId=' + $message['data']['products'][index]['Product_ID'] + '/updated_at=' + $message['data']['products'][index]['updated_at'];
                $id = '' + index + '' + $message['data']['products'][index]['Product_ID'];
                notificationProducts = $message['data'];
                $notificationTitle = '<li class=\'notificationElement' + $id + '\' style="background-color: white">' +
                        '<a  onclick="ShowNotificationContent(\'' + index + '\' ,\'' + $content + '\',\'' + $id + '\')" style="white-space: nowrap !important; font-weight: lighter" >انخفاض في كمية المنتج ' + index + '</a>' +
                        '</li>';
                $('.notificationMessages').children('div').append($notificationTitle);
            }

        });
    }



    function showNotificationMessagesForReady($message) {

        if ($('.notificationMessages').children('div').children('li').length == 6)
            $('.notificationMessages').children('div').css('height', '300px');

        $notificationTitle = '';
        $.each($message['traders']['lowestPrice'], function (index, value) {

            if ($message['products'][index][0] == 'unseen') {
                $content = 'name=' + index + '/productId=' + $message['products'][index]['Product_ID'] + '/updated_at=' + $message['products'][index]['updated_at'];
                displayedNotification.push($content);
                $id = '' + index + '' + $message['products'][index]['Product_ID'];
                notificationProducts = $message;
                $notificationTitle = '<li class=\'notificationElement' + $id + '\'>' +
                        '<a  onclick="ShowNotificationContent(\'' + index + '\' ,\'' + $content + '\',\'' + $id + '\')" style="white-space: nowrap !important; font-weight: lighter" >انخفاض في كمية المنتج ' + index + '</a>' +
                        '</li>';
                $('.notificationMessages').children('div').append($notificationTitle);
            }else
            {

                $content = 'name=' + index + '/productId=' + $message['products'][index]['Product_ID'] + '/updated_at=' + $message['products'][index]['updated_at'];
                $id = '' + index + '' + $message['products'][index]['Product_ID'];
                notificationProducts = $message;
                $notificationTitle = '<li class=\'notificationElement' + $id + '\' style="background-color: white">' +
                        '<a  onclick="ShowNotificationContent(\'' + index + '\' ,\'' + $content + '\',\'' + $id + '\')" style="white-space: nowrap !important; font-weight: lighter" >انخفاض في كمية المنتج ' + index + '</a>' +
                        '<span class="status" style="display: none;">clicked</span></li>';
                $('.notificationMessages').children('div').append($notificationTitle);
            }

        });
    $('.pe-7s-speaker').effect("bounce", "slow");
    }


    function ShowNotificationContent(index, content, id) {
        $bestPrice = notificationProducts['traders']['lowestPrice'][index][index];
        $wholeQuantity = '<i class="glyphicon glyphicon-credit-card" ></i> ' + notificationProducts['products'][index]['WholeQuantity'];
        $singleUnitAmount = '<i class="glyphicon glyphicon-ice-lolly"></i> ' + notificationProducts['products'][index]['SingleUnitAmount'];
        $messageTitle = "<h3>تحذير</h3>" +
                "<div>هناك انخفاض في كمية المنتج " + index + " الى الربع  <br/> لذالك يحتاج المتجر منك الى تزويده بكميات جديدة من هذا المنتج </div>";
        $('#right-sidebar').children().children('#notificationTitle').html($messageTitle);
        $('#right-sidebar').children().children('#notificationContent').children('#cartoon').children('h3').html($wholeQuantity);
        $('#right-sidebar').children().children('#notificationContent').children('#single').children('h3').html($singleUnitAmount);

        $('#Traders').children('span').html('<h4>أفضل تجار لهذه السلعة </h4>');
        $('#Traders').children('.m-t-md').html('');

        $.each(notificationProducts['traders']['requiredProducts'][index], function (index, value) {
            $('#Traders').children('.m-t-md').append($(" <div class='social-talk' style='font-size: 15px !important;'>" +
                    "<div class='media social-profile clearfix'>" +
                    " <div class='media-body'>" +
                    " <span class='font-bold'><i class='glyphicon glyphicon-user' style='margin-left:10px'></i>" + value['name'] + "</span>" +
                    "<div style='margin-right: 15px ;'> <div class='social-content small'> <i class=' glyphicon glyphicon-usd' style='margin-left:10px'></i>سعر الصنف  " + $bestPrice + "</div>" +
                    " <div class='social-content small '> <i class='glyphicon glyphicon-earphone' style='margin-left:10px'></i>" + value['Mobile'] + "</div>" +
                    " <div class='social-content small '> <i class='glyphicon glyphicon-globe' style='margin-left:10px'></i>" + value['Address'] + "</div>" +
                    " <div class='social-content small '> <i class='glyphicon glyphicon-cloud' style='margin-left:10px'></i>" + value['Email'] + "</div>" +
                    " </div>" +
                    " </div>" +
                    " </div>" +
                    " </div>"));
        });

        $('#right-sidebar').addClass('sidebar-open');
        updateNotificationStatus(content, id);


    }
    function updateNotificationStatus(content, id) {
        $.ajax({
            method: 'POST',
            url: updatePath,
            data: {body: content, post_id: '', _token: token}
        }).success(function (message) {
            $('.notificationElement' + id).css('background-color', 'white');
            if($('.notificationElement' + id).children('.status').html() == '' ||
                    $('.notificationElement' + id).children('.status').html() != 'clicked')
            {
                $unseenNotificationCount = parseInt($('.notifications').children('.dropdown-toggle').children('.label-success').html()) - 1;
                $('.notificationElement' + id).append('<span class="status" style="display: none;">clicked</span>');
            }

            if ($unseenNotificationCount == 0)
                $('.notifications').children('.dropdown-toggle').children('.label-success').remove();
            else
                $('.notifications').children('.dropdown-toggle').children('.label-success').html($unseenNotificationCount);


        });

    }
</script>