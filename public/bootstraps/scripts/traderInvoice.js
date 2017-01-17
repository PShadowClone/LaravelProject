/**
 * Created by Khalid on 6/30/2016.
 */
var allTraders = [];
var rowData = [];
var newTrader = new Array();
var arrayOfItems = new Array();
var itemsWithUnits = new Array();
var lastTraderID =0;
var lastInvoiceID = 0;
var itemRules = {
    item:
    {
        required: true
    },
    amount:
    {
        required: true,
        digits: true,
        min:1
    },
    wholePriceFromTrader:
    {
        required: true,
        digits: true,
        min:1
    },
    wholePriceForSale:
    {
        required: true,
        digits: true,
        min:1
    },
    singlePrice:
    {
        required: true,
        digits: true,
        min:1
    },
    singleUnit:
    {
        required: true,
        digits: true,
        min:1
    }
};

function setFlag(){
    $.cookie('show_dlg', 'true');
}

function clearFlag(){
    $.cookie('show_dlg', null);
}
function checkFlag(){
    return $.cookie('show_dlg') == 'true';
}

$( window ).load(function() {
    var date = new Date();
    $.ajax({
        method: 'GET',
        url: getInvoiceID,
        data: {_token: token}
    }).done(function (msg) {
        lastInvoiceID = msg['id']+1;
        $('#invoiceId').html(lastInvoiceID);
        var outputDate = date.getDate() + '/' + (date.getMonth()+1) + '/' + date.getFullYear();
        $('#invoiceDate').html(outputDate);

        //allTraders = msg;
        var array = [];
        for(i=0;i<msg.traders.length;i++)
        {
            array = [];
             array.push(msg.traders[i].Trader_ID);
             array.push(msg.traders[i].name);
             array.push(msg.traders[i].Email);
             array.push(msg.traders[i].Address);
             array.push(msg.traders[i].Mobile);

            allTraders.push(array);

            var fullName = JSON.parse(JSON.stringify(msg.traders[i].name));
            var traderID = JSON.parse(msg.traders[i].Trader_ID);

            $('#selectedTraderName').append($('<option>', {
                text : fullName,
                value: traderID
            }));
        }
        lastTraderID = $('#selectedTraderName option:last-child').attr('value');
    });
    $.ajax({
        method: 'GET',
        url: getshopItems,
        data:{_token:token},
        dataType: 'json'
    }).done(function (msg) {
        for(item in msg['item']) {
            arrayOfItems[item] = msg['item'][item].Name;
        }
        itemsWithUnits = msg['item'];
        getshopItemsFunction.getAllItems(1);
    });

    getshopItemsFunction = {
        getAllItems : function (id) {
            $('#'+id).find('#item').autocomplete({
                // source: arrayOfItems
                // serviceUrl: '/autosuggest/service/url',
                lookup: arrayOfItems,
                lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
                    var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                    return re.test(suggestion.value);
                },
                onSelect: function (suggestion) {
                    $(this).val(suggestion.value);
                }
            });
        }
    };
    addRules(1,itemRules);
});


$( "body" ).on('focusout', "#item", function() {
    if($(this).valid()){
        var check = false;
        for(var count=0; count<itemsWithUnits.length; count++){
            if($(this).val() == itemsWithUnits[count].Name){
                $(this).closest('tr').find('#singleUnit').prop("disabled", true);
                $(this).closest('tr').find('#singleUnit').val(itemsWithUnits[count].numberOfUnitInCartoon);
                $(this).closest('tr').find('#singleUnit').removeClass('error').addClass('valid');
                check = true;
            }
        }
        if(check == false){
            $(this).closest('tr').find('#singleUnit').prop("disabled", false);
            $(this).closest('tr').find('#singleUnit').val("");
        }
    }
});

$('#invoiceForm').on('click', '.removeButton', function() {
    var $row    = $(this).parents('.inputsItem');
    // Remove element containing the option
    $('#generalTotal').html(parseInt($('#generalTotal').text().trim()) - parseInt(parseInt($row.find('#autoTotal').text().trim())));
    $row.remove();
});

$(document).ready(function(e) {

    $('#invoiceForm').validate({

        //rules: itemRules,

        errorPlacement: function (element) {
            return false;
        },
        submitHandler: function (event) {
            //event.preventDefault();
           // $('#selectedTraderName').valid();
            var allItems = [];
            var oldID;
            var newID;
            var deferred = $.Deferred();
            if($('select[id=selectedTraderName]').val() <= lastTraderID) {
                oldID = $('select[id=selectedTraderName]').val();
                deferred.resolve();
            }
            else{
                newTrader = [];
                newTrader.push(($('span#traderName').text().trim()));
                newTrader.push(($('span#tMail').text().trim()));
                newTrader.push(parseInt($('span#traderPhone').text().trim()));
                newTrader.push(($('span#traderAddress').text().trim()));
                $.ajax({
                    type: 'POST',
                    url: insertNewTrader,
                    data:{_token:token, trader:newTrader}
                }).done(function (msg) {
                    newID = msg['id'];
                    deferred.resolve();
                });

            }
            deferred.then(function() {
                $('tr.inputsItem').each(function () {
                rowData = [];
             rowData = $(this).children('td').find('.form-control').map(function () {
                return $(this).val();
            }).get();
                rowData.push(parseInt($(this).children('td').find('strong#autoTotal').text().trim()));
                if($('select[id=selectedTraderName]').val() <= lastTraderID){
                    rowData.push(oldID);
                }
                else{
                    rowData.push(newID);
                }
                    //rowData.push(lastInvoiceID);
                    allItems.push(rowData);
                });
                console.log(rowData);
                var total = parseInt($('tr.wholeTotal').children('td').find('strong#generalTotal').text().trim());
                $.ajax({
                    type: 'POST',
                    url: insertNewItem,
                    data:{_token:token, items:allItems, total: total}
                }).done(function () {
                    Lobibox.notify('info', {
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        sound: false,
                        msg: '              تمت عملية ادخال الفاتوره كاملة بنجاح , انتظر قليلاً'
                    });
                    $('#submit').prop('disabled',true);
                    window.setTimeout(function(){location.reload()},5000);
                    //$(".row").load(sinvoice+" .row")
                    //window.location = document.URL + "?trader=true";
                    //location.reload();
                    //window.onload=happyCode() ;
                    // $(document).ready(function() {
                    //     if (checkFlag()){
                    //         Lobibox.notify('info', {
                    //             size: 'mini',
                    //             rounded: true,
                    //             delayIndicator: false,
                    //             sound: false,
                    //             msg: '              تمت عملية ادخال الفاتوره كاملة بنجاح'
                    //         });
                    //         clearFlag();
                    //     }
                    // });
                });
            });

        }

    });

        $.ajax({
            type: 'GET',
            url: getLastTraderID,
            data: {_token: token}
        }).done(function (msg) {
            lastTraderID = msg['id'];
        });
    
    $('#traderForm').validate({
        rules:{
            name: "required",
            traderMail: "email",
            mobileNumber: {
                required: true,
                digits: true,
                minlength:7
            },
            address: "required"
        },
       errorPlacement: function (element) {
           return false;
       } ,
        submitHandler: function (event) {
            newTrader = [];
            var lastID = $('#selectedTraderName option:last-child').attr('value');
            newTrader.push(parseInt(lastID,10)+1);
            newTrader.push($('#name').val());
            newTrader.push($('#traderMail').val());
            newTrader.push($('#address').val());
            newTrader.push($('#mobileNumber').val());
            // $.ajax({
            //    type: 'POST',
            //    url: insertNewTrader,
            //    data: {_token:token, trader: newTrader}
            // }).done(function (msg) {
            //     if(msg['msg'] == 'success'){
            //         $('#selectedTraderName').append($('<option>', {
            //             text : $('#name').val(),
            //             value: lastTraderID
            //         }));
            //         allTraders.push(newTrader);
            //         newTrader.length = 0;
            //         newTrader.push(msg['trader'].TID);
            //         newTrader.push(JSON.parse((JSON.stringify(msg['trader'].name))));
            //         newTrader.push(JSON.parse(JSON.stringify(msg['trader'].Email)));
            //         newTrader.push(JSON.parse(JSON.stringify(msg['trader'].Address)));
            //         newTrader.push(JSON.parse(msg['trader'].Mobile));
            //         allTraders.push(newTrader);
            //
            //         allTraders.traders.push(msg['newTrader']);
            //         allTraders.traders[0] = msg['newTrader'];
            //         alert(allTraders.traders);
            //         alert(msg['id']);
            //     }
            // });
            $('#selectedTraderName').append($('<option>', {
                text : $('#name').val(),
                value: parseInt(lastID,10)+1
            }));
            allTraders.push(newTrader);
            $('#traderForm').find('input[type=text]').val("");
            $( "#closePopup" ).trigger( "click" );
            $('#selectedTraderName').val(parseInt(lastID,10)+1);
            $('select#selectedTraderName').removeClass('error').addClass('valid');
            $('#selectedTraderName').change();
        }
    });

    $('#invoiceForm').on('click', '.addButton', function() {

        var txt;
        var currentRow = $('#table >tbody >tr').length+1;
        txt = "<tr class='inputsItem' id='"+currentRow+"'><td style='padding: 3px'>" +
            "<button type='button' class='btn btn-default removeButton'><i class='fa fa-minus'></i></button></td> <td><input type='text'" +
            " name='item-"+currentRow+"' class='form-control' id='item' onkeyup='$(this).validateItem();$(this).checkItem();$(this).checkItems()'/></td> <td><input type='text'" +
            " name='amount-"+currentRow+"' class='form-control' id='amount' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"wholePriceFromTrader\")'/></td> <td><input type='text'" +
            " name='wholePriceFromTrader-"+currentRow+"' class='form-control' id='wholePriceFromTrader' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"amount\")'/>" +
            "</td> <td><input type='text' name='wholePriceForSale-"+currentRow+"' class='form-control' id='wholePriceForSale' onkeyup='$(this).validateItem()'/>" +
            "</td> <td><input type='text\' name='singleUnit-"+currentRow+"' class='form-control' id='singleUnit' onkeyup='$(this).validateItem()'/></td>" +
            " <td><input type='text\' name='singlePrice-"+currentRow+"' class='form-control' id='singlePrice' onkeyup='$(this).validateItem()'/></td>" +
            " <td style='text-align: center'><strong name='autoTotal-"+currentRow+"' id='autoTotal'>0</strong></td></tr>";

            $(txt).appendTo('#table tbody');
            getshopItemsFunction.getAllItems(currentRow);
        addRules(currentRow,itemRules);
            //addRules(currentRow,itemRules);

        /*
                var $template = $("#itemRoww"),
                    $clone    = $template
                        .clone()
                        .removeClass('hide')
                        .removeAttr('name')
                        .insertBefore($template);
                // Add new field
               // addRules(itemRules);
               */
    });

    $("#submit").click(function(e){
        var rowItems = $('#table >tbody >tr').length;
        for(var index=1;index<=rowItems;index++) {
            $("#" + index + "").find("#item").rules("add", {
                required: true
            });
            $("#" + index + "").find("#amount").rules("add", {
                required: true,
                digits: true
            });
            $("#" + index + "").find("#wholePriceFromTrader").rules("add", {
                required: true,
                digits: true
            });
            $("#" + index + "").find("#wholePriceForSale").rules("add", {
                required: true,
                digits: true
            });
            $("#" + index + "").find("#singlePrice").rules("add", {
                required: true,
                digits: true
            });
            $("#" + index + "").find("#singleUnit").rules("add", {
                required: true,
                digits: true
            });
        }
        $('#invoiceForm').find('#selectedTraderName').rules("add",{
                required: function () {
                    if ($("#selectedTraderName option[value='']")) {
                        return true;
                    } else {
                        return false;
                    }
                }
        });

        //alert($('#selectedTraderName').valid());
            //alert($('#table >tbody >tr').length);

    });
    
    $('#reset').click(function () {
        $('span#traderName').html('');
        $('span#traderAddress').html('');
        $('span#traderPhone').html('');
        $('span#tMail').html('');
        $('strong#autoTotal').html(0);
        $('strong#generalTotal').html(0);
        $('.form-control').removeClass('valid').addClass('error');
        $('#singleUnit').prop('disabled',false);
    });

    // $('#traderSubmit').click(function (e) {
    //     $('#traderName').rules('add',{
    //
    //     });
    // });
});

function addRules(index,rulesObj){
    for (var item in rulesObj){
        $('#'+index).find('#'+item).rules('add',rulesObj[item]);
    }
}

$( "#selectedTraderName" ).change(function() {
    //var selectorID = $('select[id=selectedTraderName]').val();
    var selectorID = $('#selectedTraderName option:selected').attr('value');
        // for(i=0;i<allTraders.traders.length;i++){
        //     if(selectorID == JSON.parse(allTraders.traders[i].Trader_ID)){
        //         $('#traderName').html(JSON.parse(JSON.stringify(allTraders.traders[i].name)));
        //         $('#traderAddress').html(JSON.parse(JSON.stringify(allTraders.traders[i].Address)));
        //         $('#traderPhone').html(JSON.parse(allTraders.traders[i].Mobile));
        //         $('#traderMail').html(JSON.parse(JSON.stringify(allTraders.traders[i].Email)));
        //     }
        // }
    for(var i=0; i<allTraders.length; i++){
        if(parseInt(selectorID,10) == allTraders[i][0]){
            $('#traderName').html(allTraders[i][1]);
            $('#tMail').html(allTraders[i][2]);
            $('#traderAddress').html(allTraders[i][3]);
            $('#traderPhone').html(allTraders[i][4]);
        }
    }
    //alert($('#selectedTraderName option:selected').attr('value'));
});

(function ($) {
    $.fn.validateItem = function () {

        if($(this).valid()){$(this).removeClass("error").addClass("valid");}
        if(!$(this).valid()){$(this).removeClass("valid").addClass("error");}

    };

    $.fn.clacualteTotal = function (value) {
        //var multipleValue = 0;
        var plusValue = 0;
        var minusValue = 0;
        $(this).closest('tr').find('#item').valid();
        if($(this).valid() && $(this).closest('tr').find('#'+value).valid()){
            $('#generalTotal').html(parseInt($('#generalTotal').text().trim())- parseInt($(this).closest('tr').find('#autoTotal').text().trim()));
            $(this).closest('tr').find('#autoTotal').html($(this).val() * $(this).closest('tr').find('#'+value).val());
            plusValue = parseInt($('#generalTotal').text().trim()) + parseInt($(this).closest('tr').find('#autoTotal').text().trim());
            $('#generalTotal').html(plusValue);
        }
        if($(this).val() == ""){
            minusValue = parseInt($(this).closest('tr').find('#autoTotal').text().trim());
            $(this).closest('tr').find('#autoTotal').html(0);
            $('#generalTotal').html(parseInt($('#generalTotal').text().trim()) - minusValue);
        }
    };

    $.fn.checkItem = function () {
      if(!$(this).valid()){
          $(this).closest('tr').find('#singleUnit').prop("disabled", false);
          $(this).closest('tr').find('#singleUnit').val("");
          $(this).closest('tr').find('#singleUnit').removeClass('valid').addClass('error');
      }
    };

    $.fn.checkItems = function () {
        var status = false;
        var items = [];
        $('#table >tbody >tr').each(function () {
            items.push($(this).find('#item').val());
        });
        for(var count = 0; count < items.length-1; count++){
            if($(this).val() == items[count])
                status = true;
        }
        if(status){
            $(this).closest('tr').find('input').attr('disabled',true);
            $(this).closest('tr').find('#item').attr('disabled',false);
        }
        if(!status){
            $(this).closest('tr').find('input').attr('disabled',false);
        }
    };

})(jQuery);



