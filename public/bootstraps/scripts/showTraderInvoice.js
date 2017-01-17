/**
 * Created by Khalid on 7/20/2016.
 */

var invoices = [];
var dataRow = null;
var currentID = 0;
var traderid = 0;
var rowID = 0;
var arrayOfItems = new Array();
var itemsWithUnits = 0;
var invoiceNum = new Array();
var allItems = [];

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

$(document).ready(function () {

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
    });

    getshopItemsFunction = {
        getAllItems : function (id) {
            $('#table').find('#'+id).find('#item').autocomplete({
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

    $('#invoiceForm').validate({

        errorPlacement: function (element) {
            return false;
        },
        submitHandler: function (event) {
            if($('#table >tbody >tr').length != invoiceNum.length) {
                var idItem = $('#submit').data('iditem');
                //var traderid = $('#traderid').val();
                $('#table >tbody >tr').each(function () {
                    var rowData = [];
                    var status = 0;
                    for (var count = 0; count < invoiceNum.length; count++) {
                        if ($(this).attr('class') == invoiceNum[count]) {
                            status = 1;
                        }
                    }
                    if (status == 0) {
                        rowData = $(this).children('td').find('.form-control').map(function () {
                            return $(this).val();
                        }).get();
                        rowData.push(parseInt($(this).children('td').find('strong#autoTotal').text().trim()));
                        rowData.push($(this).attr('class'));
                        rowData.push(idItem);
                        rowData.push(traderid);
                        allItems.push(rowData);
                    }
                });
                var total = $('#generalTotal2').text().trim();
                $.ajax({
                    method: 'POST',
                    url: editInvoice,
                    data: {_token: token, items: allItems, delItem: invoiceNum, invoiceID: idItem, total: total}
                }).done(function (msg) {
                    var id = $('strong#invoiceNum').text().trim();
                    $('#invoices').DataTable().cell({row: id - 1, column: 1}).data(total).draw();
                    $('#closePopup').trigger('click');
                    $('#invoices').DataTable().row(id - 1).nodes().to$().addClass('highlight');
                    window.setTimeout(function () {
                        $('#invoices').DataTable().row(id - 1).nodes().to$().removeClass('highlight');
                    }, 2000);
                    Lobibox.notify('success', {
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        sound: false,
                        msg: 'تمت عملية اضافة التعديلات بنجاح'
                    });
                });
            }
            else {
                alert('لا يمكنك حذف جميع المنتجات من هنا .. فقط للتعديل او حذف عنصر معين')
            }
        }

    });


    var table = $('#invoices').DataTable();
    $.ajax({
        method: 'GET',
        url: getAllInvoices
    }).done(function (msg) {
        for(var i=0; i<msg.invoices.length; i++){
            var singleInvoice = [];
            singleInvoice.push(msg.invoices[i].invoiceid);
            singleInvoice.push(msg.invoices[i].Trader_ID);
            singleInvoice.push(msg.invoices[i].invoicenumber);
            singleInvoice.push(msg.invoices[i].total);
            //singleInvoice.push(msg.invoices[i].Mobile);
            //singleInvoice.push(msg.invoices[i].Address);
            var date = (msg.invoices[i].created_at).split(" ");
            singleInvoice.push(date[0]);
            singleInvoice.push(msg.invoices[i].name);
            invoices.push(singleInvoice);

            var rowIndex = $('#invoices').dataTable().fnAddData([
                [i+1,singleInvoice[3],singleInvoice[5],singleInvoice[4],'' +
                '<button class="btn btn-xs btn-success fadeandscale_open"  title="عرض التفاصيل" id="'+singleInvoice[0]+'"><i class="fa fa-check"></i></button>&nbsp;' +
                '<button class="btn btn-xs btn-warning showInvoice"   data-target="#contact" title="تعديل الفاتوره" id="'+singleInvoice[0]+'"><i class="fa fa-pencil"></i></button>&nbsp;' +
                '<button class="btn btn-xs btn-danger deleteItem" data-placement="bottom" data-original-title title id="'+singleInvoice[0]+'"><i class="fa fa-times"></i></button>']
            ]);
            var row = $('#invoices').dataTable().fnGetNodes(rowIndex);
            // $('.btn-success').attr('id', singleInvoice[0]);
            // $('.btn-warning').attr('id', singleInvoice[0]);
            // $('.btn-danger').attr('id', singleInvoice[0]);
            // $('.btn-success').attr('class', 'btn btn-xs btn-success fadeandscale_open');
            //$(row).attr('class', 'fadeandscale_open');
            $(row).attr('id',singleInvoice[0]);
        }
    });

    $( "body" ).on('click', ".fadeandscale_open", function() {
        $('#invoiceDetails').DataTable().clear();
             dataRow = table.row( $(this).closest('tr') ).data();
             currentID = $(this).attr('id');
            $('#invoiceNumber').html(dataRow[0]);
            $('#generalTotal1').html(dataRow[1]);
            $.ajax({
                method: 'GET',
                url: getInvoice,
                data: {_token: token, invoiceNumber: currentID}
            }).done(function (msg) {
                for (var i=0;i<msg.invoice.length;i++) {
                $('#invoiceDetails').dataTable().fnAddData([
                    [msg.invoice[i].NameOfProduct, msg.invoice[i].WholeQuantity]
                ]);
            }
            });
    });


    $( "body" ).on('click', ".showInvoice", function(e) {
        // $('table.scroll >tbody').css('height','100px');
        // $('table.scroll >tbody').css('overflow-y','auto');
        // $('table.scroll >tbody').css('overflow-x','hidden');
        // $('table.scroll >tbody').css('overflow-x','hidden');
        // $('table.scroll >tbody').css('display','block');
        // $('table.scroll >thead').css('display','block');


        $("#table >tbody >tr").remove();
        $('.fade').modal('show');
        allItems = [];
        invoiceNum = [];
        $('#submit').data('iditem',$(this).attr('id'));
        dataRow = table.row( $(this).closest('tr') ).data();
        $('#invoiceNum').html(dataRow[0]);
        $('#generalTotal2').html(dataRow[1]);
        var invoicesID = $(this).attr('id');
        $.ajax({
           method: 'GET',
            url: getInvoice,
            data: {_token: token, invoiceNumber:invoicesID}
        }).done(function (msg) {
            traderid = msg.invoice[0].Trader_ID;
           for(var count=0;count<msg.invoice.length;count++){
               var txt;
               var currentRow = $('#table >tbody >tr').length+1;
               txt = "<tr id='"+currentRow+"' class='"+msg.invoice[count].TInvID+"'><td style=''>" +
                   "<button type='button' id='del-item' class='btn btn-xs btn-danger' title='حذف الصنف' style='margin-top: 7px'><i class='fa fa-times'></i></button></td> " +
                   "<td><input type='text' name='item-"+currentRow+"' class='form-control' value='"+msg.invoice[count].NameOfProduct+"' id='item' onkeyup='$(this).validateItem();$(this).checkItem();$(this).checkItems()' disabled/></td>" +
                   "<td><input type='text' name='amount-"+currentRow+"' class='form-control' id='amount' value='"+msg.invoice[count].WholeQuantity+"' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"wholePriceFromTrader\")'/></td>" +
                   "<td><input type='text' name='wholePriceFromTrader-"+currentRow+"' class='form-control' id='wholePriceFromTrader' value='"+msg.invoice[count].wholepricetrader+"' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"amount\")'/>" +
                   "</td> <td><input type='text' name='wholePriceForSale-"+currentRow+"' class='form-control' id='wholePriceForSale' value='"+msg.invoice[count].wholepricesale+"' onkeyup='$(this).validateItem()'/>" +
                   "</td> <td><input type='text\' name='singleUnit-"+currentRow+"' class='form-control' id='singleUnit' value='"+msg.invoice[count].numberOfUnitInCartoon+"' onkeyup='$(this).validateItem()' disabled/></td>" +
                   " <td><input type='text\' name='singlePrice-"+currentRow+"' class='form-control' id='singlePrice' value='"+msg.invoice[count].SingleUnitPrice+"' onkeyup='$(this).validateItem()'/></td>" +
                   " <td style='text-align: center'><strong name='autoTotal-"+currentRow+"' id='autoTotal'>"+msg.invoice[count].total+"</strong></td></tr>";
               $(txt).appendTo('#table tbody');
               getshopItemsFunction.getAllItems(currentRow);
               addRules(currentRow,itemRules);
           }
        });


    });

    $('.addButton').click(function () {
        var currentRow = $('#table >tbody >tr').length+1;
        txt = "<tr id='"+currentRow+"' class='"+0+"'><td style=''>" +
            "<button type='button' class='btn btn-xs btn-default removeButton' style='height: 100%;width: 110%'><i class='fa fa-minus'></i></button></td> " +
            "<td><input type='text' name='item-"+currentRow+"' class='form-control' value='' id='item' onkeyup='$(this).validateItem();$(this).checkItem();$(this).checkItems()'/></td>" +
            "<td><input type='text' name='amount-"+currentRow+"' class='form-control' id='amount' value='' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"wholePriceFromTrader\")'/></td>" +
            "<td><input type='text' name='wholePriceFromTrader-"+currentRow+"' class='form-control' id='wholePriceFromTrader' value='' onkeyup='$(this).validateItem();$(this).clacualteTotal(\"amount\")'/>" +
            "</td> <td><input type='text' name='wholePriceForSale-"+currentRow+"' class='form-control' id='wholePriceForSale' value='' onkeyup='$(this).validateItem()'/>" +
            "</td> <td><input type='text\' name='singleUnit-"+currentRow+"' class='form-control' id='singleUnit' value='' onkeyup='$(this).validateItem()'/></td>" +
            " <td><input type='text\' name='singlePrice-"+currentRow+"' class='form-control' id='singlePrice' value='' onkeyup='$(this).validateItem()'/></td>" +
            " <td style='text-align: center'><strong name='autoTotal-"+currentRow+"' id='autoTotal'>"+0+"</strong></td></tr>";
        $(txt).appendTo('#table tbody');
        getshopItemsFunction.getAllItems(currentRow);
        addRules(currentRow,itemRules);
    });

    $('#invoiceForm').on('click', '.removeButton', function() {
        var $row    = $(this).parents('tr');
        // Remove element containing the option
        $('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) - parseInt(parseInt($row.find('#autoTotal').text().trim())));
        $row.remove();
    });

    // $('#invoices tbody').on('click', 'tr', function () {
    //
    //     $('#invoiceDetails').DataTable().clear();
    //      dataRow = table.row( this ).data();
    //      currentID = $(this).attr('id');
    //     $('#invoiceNumber').html(dataRow[0]);
    //     $('#generalTotal').html(dataRow[1]);
    //     $.ajax({
    //         method: 'GET',
    //         url: getInvoice,
    //         data: {_token: token, invoiceNumber: dataRow[0]}
    //     }).done(function (msg) {
    //         for (var i=0;i<msg.invoice.length;i++) {
    //         $('#invoiceDetails').dataTable().fnAddData([
    //             [msg.invoice[i].NameOfProduct, msg.invoice[i].WholeQuantity]
    //         ]);
    //     }
    //     });
    // });
    $( "#invoiceForm" ).on('focusout', "#item", function() {
        if($(this).valid()){
            var check = false;
            for(var count=0; count<itemsWithUnits.length; count++){
                if($(this).val() == itemsWithUnits[count].Name){
                    //$(this).closest('tr').find('#singleUnit').prop("disabled", true);
                    $(this).closest('tr').find('#singleUnit').val(itemsWithUnits[count].numberOfUnitInCartoon);
                    $(this).closest('tr').find('#singleUnit').removeClass('error').addClass('valid');
                    $(this).closest('tr').find('#singleUnit').css('border-color','#4CAF50');
                    check = true;
                }
            }
            if(check == false){
                //$(this).closest('tr').find('#singleUnit').prop("disabled", false);
                $(this).closest('tr').find('#singleUnit').val("");
            }
        }
    });

    $( "#invoiceForm" ).on('click', "#del-item", function() {
        $(this).closest('tr').find('input').attr('disabled',true);
        $(this).closest('tr').css("background-color", "gray");
        $(this).removeClass('btn-danger').addClass('btn-success');
        $(this).attr('id','ret-item');
        $(this).closest('tr').find('.fa-times').removeClass('fa fa-times').addClass('fa fa-check');
        $(this).attr('title','تراجع');

        $('.wholeTotal').find('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) - parseInt($(this).closest('tr').find('#autoTotal').text().trim()));

        invoiceNum.push($(this).closest('tr').attr('class'));
    });

    $( "#invoiceForm" ).on('click', "#ret-item", function() {
        $(this).closest('tr').find('input').attr('disabled',false);
        $(this).closest('tr').find('#item').attr('disabled',true);
        $(this).closest('tr').find('#singleUnit').attr('disabled',true);
        $(this).closest('tr').css("background-color", "");
        $(this).removeClass('btn-success').addClass('btn-danger');
        $(this).attr('id','del-item');
        $(this).closest('tr').find('.fa-check').removeClass('fa fa-check').addClass('fa fa-times');
        $(this).attr('title','حذف الصنف');

        $('.wholeTotal').find('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) + parseInt($(this).closest('tr').find('#autoTotal').text().trim()));

        var removeItem = $(this).closest('tr').attr('class');
        invoiceNum = jQuery.grep(invoiceNum, function(value) {
            return value != removeItem;
        });
    });

    $( "body" ).on('click', ".deleteItem", function() {
        $(this).confirmation('show');
        //rowID = $(this).attr('id');
        // $(this).confirmation({
        //     onConfirm: function(event) { alert('confirm') }
        // })
    });

    $('body').on('click','.rmRow',function () {
        rowID = $(this).parents('tr').attr('id');
        table.row($(this).parents('tr')).remove().draw();
        var id = 1;
        if($('#invoices').dataTable().fnGetData().length != 0) {
            $('#invoices > tbody > tr').each(function () {
                table.cell({row: id - 1, column: 0}).data(id).draw();
                id++;
            })
        }
        $.ajax({
            method: 'GET',
            url: deleteInvoice,
            data:{_token: token, invoiceID: rowID}
        })
    });


    // $('#submit').click(function () {
    //
    //
    // });

    function addRules(index,rulesObj){
        for (var item in rulesObj){
            $('#table').find('#'+index).find('#'+item).rules('add',rulesObj[item]);
        }
    }

    // $("#submit").click(function(e){
    //     var rowItems = $('#table >tbody >tr').length;
    //     for(var index=1;index<=rowItems;index++) {
    //         $('#table').find("#" + index).find("#item").rules("add", {
    //             required: true
    //         });
    //         $('#table').find("#" + index).find("#amount").rules("add", {
    //             required: true,
    //             digits: true
    //         });
    //         $('#table').find("#" + index).find("#wholePriceFromTrader").rules("add", {
    //             required: true,
    //             digits: true
    //         });
    //         $('#table').find("#" + index).find("#wholePriceForSale").rules("add", {
    //             required: true,
    //             digits: true
    //         });
    //         $('#table').find("#" + index).find("#singlePrice").rules("add", {
    //             required: true,
    //             digits: true
    //         });
    //         $('#table').find("#" + index).find("#singleUnit").rules("add", {
    //             required: true,
    //             digits: true
    //         });
    //     }
    // });
    
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
            $('#generalTotal2').html(parseInt($('#generalTotal2').text().trim())- parseInt($(this).closest('tr').find('#autoTotal').text().trim()));
            $(this).closest('tr').find('#autoTotal').html($(this).val() * $(this).closest('tr').find('#'+value).val());
            plusValue = parseInt($('#generalTotal2').text().trim()) + parseInt($(this).closest('tr').find('#autoTotal').text().trim());
            $('#generalTotal2').html(plusValue);
        }
        if($(this).val() == ""){
            minusValue = parseInt($(this).closest('tr').find('#autoTotal').text().trim());
            $(this).closest('tr').find('#autoTotal').html(0);
            $('#generalTotal2').html(parseInt($('#generalTotal2').text().trim()) - minusValue);
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
